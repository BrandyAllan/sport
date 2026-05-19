<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table            = 'events';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    
    protected $allowedFields    = ['title', 'start_date', 'end_date'];
}