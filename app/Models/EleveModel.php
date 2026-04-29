<?php

namespace App\Models;

use CodeIgniter\Model;

class EleveModel extends Model
{
    protected $table = 'eleve';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'id_classe'];
}