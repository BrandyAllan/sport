<?php

namespace App\Controllers;
use App\Models\CreneauModel;

class Dashboard extends BaseController 
{
    public function dashboard_client()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $name = session()->get('user_name');
        $role = session()->get('role');

        $db = \Config\Database::connect();

        $enAttente = $db->table('reservations')
            ->where('user_id', $userId)
            ->where('statut', 'en_attente')
            ->countAllResults();

        $confirmees = $db->table('reservations')
            ->where('user_id', $userId)
            ->where('statut', 'confirmee')
            ->countAllResults();

        $annulees = $db->table('reservations')
            ->where('user_id', $userId)
            ->where('statut', 'annulee')
            ->countAllResults();

        $aVenir = $db->table('reservations r')
            ->join('creneaux c', 'c.id = r.creneau_id')
            ->where('r.user_id', $userId)
            ->where('c.date_debut >=', date('Y-m-d H:i:s'))
            ->whereIn('r.statut', ['en_attente', 'confirmee'])
            ->countAllResults();

        $reservations = $db->table('reservations r')
            ->select('
                r.id,
                r.statut,
                r.created_at,
                c.date_debut,
                c.date_fin,
                ressources.nom AS ressource_nom,
                ressources.type AS ressource_type
            ')
            ->join('creneaux c', 'c.id = r.creneau_id')
            ->join('ressources', 'ressources.id = c.ressource_id')
            ->where('r.user_id', $userId)
            ->where('c.date_debut >=', date('Y-m-d H:i:s'))
            ->orderBy('c.date_debut', 'ASC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $data = [
            'en_attente'   => $enAttente,
            'confirmees'   => $confirmees,
            'annulees'     => $annulees,
            'a_venir'      => $aVenir,
            'reservations' => $reservations,
            'name'        => $name,
            'role'        => $role,
        ];

        return view('client/dashboard', $data);
    }

    public function dashboard_admin()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/creneau');
        }

        $name = session()->get('user_name');
        $role = session()->get('role');

        $db = \Config\Database::connect();

        $enAttente = $db->table('reservations')
            ->where('statut', 'en_attente')
            ->countAllResults();

        $confirmeesCeMois = $db->table('reservations')
            ->where('statut', 'confirmee')
            ->where('created_at >=', date('Y-m-01 00:00:00'))
            ->where('created_at <=', date('Y-m-t 23:59:59'))
            ->countAllResults();

        $creneauxActifs = $db->table('creneaux')
            ->where('actif', 1)
            ->countAllResults();

        $clientsInscrits = $db->table('users')
            ->where('role', 'client')
            ->countAllResults();

        $reservationsRecentes = $db->table('reservations r')
            ->select('
                r.id,
                r.statut,
                r.created_at,
                u.nom AS client_nom,
                u.email AS client_email,
                c.date_debut,
                c.date_fin,
                ressources.nom AS ressource_nom,
                ressources.type AS ressource_type,
            ')
            ->join('users u', 'u.id = r.user_id')
            ->join('creneaux c', 'c.id = r.creneau_id')
            ->join('ressources', 'ressources.id = c.ressource_id')
            ->where('r.statut !=', 'annulee')
            ->orderBy('r.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        $data = [
            'en_attente'           => $enAttente,
            'confirmees_ce_mois'   => $confirmeesCeMois,
            'creneaux_actifs'      => $creneauxActifs,
            'clients_inscrits'     => $clientsInscrits,
            'reservationsRecentes' => $reservationsRecentes,
            'name'           => $name,
            'role'                => $role,
        ];

        return view('admin/dashboard', $data);
    }

    public function dashbobard(): string
    {
        if(!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        if(session()->get('role') !== 'admin') {
            return $this->dashboard_client();
        } else {
            return $this->dashboard_admin();
        }
    }    
}