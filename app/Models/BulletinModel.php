<?php

namespace App\Models;

use CodeIgniter\Model;

class BulletinModel extends Model
{
    protected $table = 'bulletin';
    protected $allowedFields = [
        'id_eleve',
        'id_option',
        'id_matiere',
        'note',
        'resultat'
    ];
}