<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RessourceSeeder extends Seeder
{
    public function run()
    {
        $data = [

            [
                'nom' => 'Salle Zen',
                'type' => 'Yoga',
                'capacite' => 15,
                'description' => 'Salle dédiée aux cours de yoga et méditation.'
            ],

            [
                'nom' => 'Studio Cardio',
                'type' => 'Fitness',
                'capacite' => 25,
                'description' => 'Salle équipée pour les cours cardio intensifs.'
            ],

            [
                'nom' => 'Terrain Indoor',
                'type' => 'Football',
                'capacite' => 20,
                'description' => 'Terrain intérieur synthétique.'
            ],

            [
                'nom' => 'Piscine Olympique',
                'type' => 'Natation',
                'capacite' => 30,
                'description' => 'Piscine chauffée 50 mètres.'
            ],

            [
                'nom' => 'Salle Musculation',
                'type' => 'Musculation',
                'capacite' => 40,
                'description' => 'Machines et poids libres.'
            ],
        ];

        $this->db->table('ressources')->insertBatch($data);
    }
}