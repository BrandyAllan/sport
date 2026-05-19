<?php

namespace App\Controllers;

use App\Models\CreneauModel;

class Creneau extends BaseController
{
    public function creneau_client()
    {
        $creneauModel = new CreneauModel();

        $creneaux = $creneauModel
            ->select('
                creneaux.id,
                creneaux.ressource_id,
                creneaux.date_debut,
                creneaux.date_fin,
                creneaux.places_dispo,
                creneaux.actif,
                ressources.nom AS ressource_nom,
                ressources.type AS ressource_type,
                ressources.capacite,
                ressources.description
            ')
            ->join('ressources', 'ressources.id = creneaux.ressource_id')
            ->orderBy('creneaux.date_debut', 'ASC')
            ->findAll();

        $data = [
            'creneaux' => $creneaux,
            'total'    => count($creneaux),
        ];

        return view('client/creneaux', $data);
    }

    public function creneau_admin()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Accès refusé.');
        }

        $db = \Config\Database::connect();

        $ressources = $db->table('ressources')
            ->orderBy('nom', 'ASC')
            ->get()
            ->getResultArray();

        $creneaux = $db->table('creneaux c')
            ->select('
                c.id,
                c.ressource_id,
                c.date_debut,
                c.date_fin,
                c.places_dispo,
                c.actif,
                r.nom AS ressource_nom,
                r.type AS ressource_type,
                r.capacite
            ')
            ->join('ressources r', 'r.id = c.ressource_id')
            ->orderBy('c.date_debut', 'ASC')
            ->get()
            ->getResultArray();

        return view('admin/creneaux', [
            'ressources' => $ressources,
            'creneaux'   => $creneaux,
        ]);
    }

    public function creneau() {
        if(!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        
        if(session()->get('role') !== 'admin') {
            return $this->creneau_client();
        } else {
            return $this->creneau_admin();
        }
    }

    public function ajouter_creneau()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $ressourceId  = $this->request->getPost('ressource_id');
        $placesDispo  = $this->request->getPost('places_dispo');
        $dateDebut    = $this->request->getPost('date_debut');
        $dateFin      = $this->request->getPost('date_fin');

        if (!$ressourceId || !$placesDispo || !$dateDebut || !$dateFin) {
            return redirect()->back()->with('error', 'Veuillez remplir tous les champs.');
        }

        if (strtotime($dateFin) <= strtotime($dateDebut)) {
            return redirect()->back()->with('error', 'La date de fin doit être après la date de début.');
        }

        $db = \Config\Database::connect();

        $db->table('creneaux')->insert([
            'ressource_id'  => $ressourceId,
            'date_debut'    => str_replace('T', ' ', $dateDebut) . ':00',
            'date_fin'      => str_replace('T', ' ', $dateFin) . ':00',
            'places_dispo'  => $placesDispo,
            'actif'         => 1,
        ]);

        return redirect()->to('/admin/creneaux')->with('success', 'Créneau ajouté avec succès.');
    }

    public function supprimer_creneau($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        $db->table('creneaux')
            ->where('id', $id)
            ->delete();

        return redirect()->to('/admin/creneaux')->with('success', 'Créneau supprimé.');
    }

    public function edit_creneau($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        $creneau = $db->table('creneaux')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        $ressources = $db->table('ressources')
            ->orderBy('nom', 'ASC')
            ->get()
            ->getResultArray();

        if (!$creneau) {
            return redirect()->to('/admin/creneaux')
                ->with('error', 'Créneau introuvable.');
        }

        return view('admin/edit_creneau', [
            'creneau'    => $creneau,
            'ressources' => $ressources,
        ]);
    }

    public function update_creneau()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }
        $creneauId = $this->request->getPost('id_creneau');
        $ressourceId = $this->request->getPost('ressource_id');
        $placesDispo = $this->request->getPost('places_dispo');
        $dateDebut   = $this->request->getPost('date_debut');
        $dateFin     = $this->request->getPost('date_fin');
        $actif       = $this->request->getPost('actif') ? 1 : 0;

        if (!$ressourceId || !$placesDispo || !$dateDebut || !$dateFin) {
            return redirect()->to('/editer-creneau/' . $creneauId)->with('error', 'Veuillez remplir tous les champs.');
        }

        if (strtotime($dateFin) <= strtotime($dateDebut)) {
            return redirect()->to('/editer-creneau/' . $creneauId)->with('error', 'La date de fin doit être après la date de début.');
        }

        $db = \Config\Database::connect();

        $db->table('creneaux')
            ->where('id', $creneauId)
            ->update([
                'ressource_id' => $ressourceId,
                'places_dispo' => $placesDispo,
                'date_debut'   => str_replace('T', ' ', $dateDebut) . ':00',
                'date_fin'     => str_replace('T', ' ', $dateFin) . ':00',
                'actif'        => $actif,
            ]);

        return redirect()->to('/creneau')
            ->with('success', 'Créneau modifié avec succès.');
    }
}