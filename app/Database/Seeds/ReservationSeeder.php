<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ReservationSeeder extends Seeder
{
    public function run()
    {
        // récupérer utilisateur Brandy
        $user = $this->db->table('users')
            ->where('email', 'brandy@email.com')
            ->get()
            ->getRowArray();

        if (!$user) {

            echo "Utilisateur introuvable";

            return;
        }

        $userId = $user['id'];

        $data = [

            // réservation en attente
            [
                'user_id' => $userId,
                'creneau_id' => 1,
                'statut' => 'en_attente',
                'created_at' => date('Y-m-d H:i:s'),
            ],

            // réservation confirmée
            [
                'user_id' => $userId,
                'creneau_id' => 2,
                'statut' => 'confirmee',
                'created_at' => date('Y-m-d H:i:s'),
            ],

            // réservation annulée
            [
                'user_id' => $userId,
                'creneau_id' => 3,
                'statut' => 'annulee',
                'created_at' => date('Y-m-d H:i:s'),
            ],

            // autre réservation confirmée
            [
                'user_id' => $userId,
                'creneau_id' => 4,
                'statut' => 'confirmee',
                'created_at' => date('Y-m-d H:i:s'),
            ],

            // autre réservation en attente
            [
                'user_id' => $userId,
                'creneau_id' => 5,
                'statut' => 'en_attente',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('reservations')
            ->insertBatch($data);

        echo "Réservations ajoutées";
    }
}