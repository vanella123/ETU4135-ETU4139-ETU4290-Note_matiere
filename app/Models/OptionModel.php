<?php

namespace App\Models;

use CodeIgniter\Model;

class OptionModel extends Model
{
    protected $table = 'option_etude';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom'];
}