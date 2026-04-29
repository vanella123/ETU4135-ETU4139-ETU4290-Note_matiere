<?php

namespace App\Models;

use CodeIgniter\Model;

class MatiereModel extends Model
{
    protected $table = 'matiere';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'ue', 'credit', 'id_semestre'];
}