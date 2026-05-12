<?php

namespace App\Models;

use CodeIgniter\Model;

class RessourceModel extends Model
{
    protected $table            = 'ressources';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'nom',
        'type',
        'capacite',
        'description',
    ];

    protected $useTimestamps = false;
}