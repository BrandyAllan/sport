<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEvent extends Migration
{
    public function up()
    {
        // Définition des champs de la table 'events'
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
            'start_date' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'end_date' => [
                'type' => 'DATETIME',
                'null' => true, // Peut être NULL comme dans le modèle du prof
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        // Définition de la clé primaire
        $this->forge->addKey('id', true);

        // Création effective de la table 'events'
        $this->forge->createTable('events');
    }

    public function down()
    {
        // Suppression de la table 'events' en cas de retour en arrière (rollback)
        $this->forge->dropTable('events');
    }
}