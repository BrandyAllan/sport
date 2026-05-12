<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateRessourceSeeder extends Seeder
{
    public function run()
    {
        $table = $this->db->table('ressources');

        // ID 1
        $table->update([
            'nom' => 'Yoga Détente',
            'type' => 'cours',
            'capacite' => 15,
            'description' => 'Cours collectif de yoga relaxation.'
        ], ['id' => 1]);

        // ID 2
        $table->update([
            'nom' => 'CrossFit Intensif',
            'type' => 'cours',
            'capacite' => 20,
            'description' => 'Cours cardio et renforcement musculaire.'
        ], ['id' => 2]);

        // ID 3
        $table->update([
            'nom' => 'Pilates Débutant',
            'type' => 'cours',
            'capacite' => 12,
            'description' => 'Cours de pilates pour débutants.'
        ], ['id' => 3]);

        // ID 4
        $table->update([
            'nom' => 'Salle de musculation',
            'type' => 'salle',
            'capacite' => 40,
            'description' => 'Salle équipée de machines et poids libres.'
        ], ['id' => 4]);

        // ID 5
        $table->update([
            'nom' => 'Terrain football indoor',
            'type' => 'terrain',
            'capacite' => 20,
            'description' => 'Terrain synthétique intérieur.'
        ], ['id' => 5]);
    }
}