<?php

namespace App\Controllers;

use App\Models\CreneauModel;

class Creneau extends BaseController
{
    public function index()
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
            ->where('creneaux.actif', 1)
            ->orderBy('creneaux.date_debut', 'ASC')
            ->findAll();

        $data = [
            'creneaux' => $creneaux,
            'total'    => count($creneaux),
        ];

        return view('client/creneaux', $data);
    }
}