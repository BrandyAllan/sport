<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CreneauSeeder extends Seeder
{
    public function run()
    {
        $data = [

            [
                'ressource_id' => 1,
                'date_debut' => '2026-05-13 08:00:00',
                'date_fin' => '2026-05-13 09:30:00',
                'places_dispo' => 15,
                'actif' => 1,
            ],

            [
                'ressource_id' => 1,
                'date_debut' => '2026-05-13 18:00:00',
                'date_fin' => '2026-05-13 19:30:00',
                'places_dispo' => 12,
                'actif' => 1,
            ],

            [
                'ressource_id' => 2,
                'date_debut' => '2026-05-14 10:00:00',
                'date_fin' => '2026-05-14 11:00:00',
                'places_dispo' => 20,
                'actif' => 1,
            ],

            [
                'ressource_id' => 3,
                'date_debut' => '2026-05-14 15:00:00',
                'date_fin' => '2026-05-14 17:00:00',
                'places_dispo' => 18,
                'actif' => 1,
            ],

            [
                'ressource_id' => 4,
                'date_debut' => '2026-05-15 09:00:00',
                'date_fin' => '2026-05-15 10:30:00',
                'places_dispo' => 25,
                'actif' => 1,
            ],

            [
                'ressource_id' => 5,
                'date_debut' => '2026-05-15 17:00:00',
                'date_fin' => '2026-05-15 19:00:00',
                'places_dispo' => 35,
                'actif' => 1,
            ],
        ];

        $this->db->table('creneaux')->insertBatch($data);
    }
}