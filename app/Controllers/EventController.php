<?php

namespace App\Controllers;

use App\Models\EventModel;
use CodeIgniter\RESTful\ResourceController;

class EventController extends ResourceController
{
    // 1. Afficher la vue des réservations
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        return view('client/reservations', [
            'name' => session()->get('user_name')
        ]);
    }

    // 2. Fusionner et renvoyer toutes les données au format JSON (Modèle du prof amélioré)
    public function list()
    {
        $db = \Config\Database::connect();
        $userId = session()->get('user_id');
        $data = [];

        // --- SOURCE A : Les événements basiques du prof (Table 'events') ---
        $eventModel = new EventModel();
        $events = $eventModel->findAll();
        foreach ($events as $event) {
            $data[] = [
                'id'    => 'evt_' . $event['id'], // Préfixe pour éviter les conflits d'ID
                'title' => "📝 " . $event['title'],
                'start' => $event['start_date'],
                'end'   => $event['end_date'],
                'color' => '#9b59b6', // Couleur Violette pour les événements texte du prof
                'extendedProps' => ['type' => 'prof_event']
            ];
        }

        // --- SOURCE B : Tes réservations FitSpace actives ---
        if ($userId) {
            $mesReservations = $db->table('reservations')
                ->where('user_id', $userId)
                ->where('statut !=', 'annulee')
                ->get()
                ->getResultArray();
                
            $listeMesCreneauxIds = array_column($mesReservations, 'creneau_id');

            // Récupérer tous les créneaux futurs de la salle
            $creneaux = $db->table('creneaux c')
                ->select('c.id, c.date_debut, c.date_fin, c.places_dispo, c.capacite, r.nom AS ressource_nom')
                ->join('ressources r', 'r.id = c.ressource_id')
                ->where('c.date_debut >=', date('Y-m-d H:i:s'))
                ->get()
                ->getResultArray();

            foreach ($creneaux as $c) {
                // Si l'utilisateur est inscrit
                if (in_array($c['id'], $listeMesCreneauxIds)) {
                    $statut = 'validé';
                    foreach ($mesReservations as $res) {
                        if ($res['creneau_id'] == $c['id']) {
                            $statut = $res['statut'];
                            break;
                        }
                    }
                    $data[] = [
                        'id'    => $c['id'],
                        'title' => "🔒 " . $c['ressource_nom'] . " (" . ucfirst($statut) . ")",
                        'start' => $c['date_debut'],
                        'end'   => $c['date_fin'],
                        'color' => ($statut === 'en_attente') ? '#f39c12' : '#2ecc71', // Orange ou Vert
                        'extendedProps' => ['type' => 'deja_reserve']
                    ];
                } 
                // Si le cours est disponible à la réservation
                elseif ($c['places_dispo'] > 0) {
                    $data[] = [
                        'id'    => $c['id'],
                        'title' => "➕ " . $c['ressource_nom'] . " (" . $c['places_dispo'] . "/" . $c['capacite'] . " pl.)",
                        'start' => $c['date_debut'],
                        'end'   => $c['date_fin'],
                        'color' => '#7f8c8d', // Gris cliquable pour réserver
                        'extendedProps' => ['type' => 'creneau_libre']
                    ];
                }
            }
        }

        return $this->response->setJSON($data);
    }

    // 3. Sauvegarde d'un événement au clic (Code inchangé du prof)
    public function save()
    {
        $model = new EventModel();
        
        $title = $this->request->getPost('title');
        $start = $this->request->getPost('start');
        $end   = $this->request->getPost('end');

        $model->insert([
            'title'      => $title,
            'start_date' => $start,
            'end_date'   => $end
        ]);

        return $this->response->setJSON(['status' => 'success']);
    }
}