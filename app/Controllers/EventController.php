<?php

namespace App\Controllers;

use App\Models\EventModel;
use CodeIgniter\RESTful\ResourceController;

class EventController extends ResourceController
{
    public function list()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([]);
        }

        $db = \Config\Database::connect();
        $userId = session()->get('user_id');

        $data = [];

        $eventModel = new EventModel();

        $events = $eventModel
            ->where('user_id', $userId)
            ->findAll();

        foreach ($events as $event) {
            $data[] = [
                'id'    => 'event_' . $event['id'],
                'title' => $event['title'],
                'start' => $event['start_date'],
                'end'   => $event['end_date'],
                'allDay' => (bool)$event['all_day'],
                'color' => '#9b59b6',
                'extendedProps' => [
                    'type' => 'event_perso',
                ],
            ];
        }

        $reservations = $db->table('reservations r')
            ->select('
                r.id,
                r.statut,
                c.date_debut,
                c.date_fin,
                ressources.nom AS ressource_nom,
                ressources.type AS ressource_type
            ')
            ->join('creneaux c', 'c.id = r.creneau_id')
            ->join('ressources', 'ressources.id = c.ressource_id')
            ->where('r.user_id', $userId)
            ->where('r.statut !=', 'annulee')
            ->get()
            ->getResultArray();

        foreach ($reservations as $reservation) {
            $color = '#2ecc71';

            if ($reservation['statut'] === 'en_attente') {
                $color = '#f39c12';
            }

            $data[] = [
                'id'    => 'reservation_' . $reservation['id'],
                'title' => $reservation['ressource_nom'] . ' - ' . $reservation['statut'],
                'start' => $reservation['date_debut'],
                'end'   => $reservation['date_fin'],
                'color' => $color,
                'extendedProps' => [
                    'type' => 'reservation',
                ],
            ];
        }

        return $this->response->setJSON($data);
    }

    public function save()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'status' => 'error',
            ]);
        }

        $title = $this->request->getPost('title');
        $start = $this->request->getPost('start');
        $end   = $this->request->getPost('end');
        $allDay = $this->request->getPost('allDay');

        if (!$title || !$start) {
            return $this->response->setJSON([
                'status' => 'error',
            ]);
        }

        $model = new EventModel();

        $model->insert([
            'user_id' => session()->get('user_id'),
            'title' => $title,
            'start_date' => $start,
            'end_date' => $end,
            'all_day' => ($allDay === 'true') ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON([
            'status' => 'success',
        ]);
    }
}