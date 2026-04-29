<?php

namespace App\Models;

use CodeIgniter\Model;

class NoteModel extends Model
{
    protected $table = 'note';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id_eleve', 'id_matiere', 'note'];

    /**
     * Met à jour la note d'un étudiant pour une matière
     */
    public function updateNote($eleveId, $matiereId, $noteValue)
    {
        $existing = $this->where('id_eleve', $eleveId)
            ->where('id_matiere', $matiereId)
            ->first();

        if ($existing) {
            return $this->update($existing['id'], ['note' => $noteValue]);
        } else {
            return $this->insert([
                'id_eleve' => $eleveId,
                'id_matiere' => $matiereId,
                'note' => $noteValue
            ]);
        }
    }

    /**
     * Récupère une note spécifique
     */
    public function getNote($eleveId, $matiereId)
    {
        return $this->where('id_eleve', $eleveId)
            ->where('id_matiere', $matiereId)
            ->first();
    }
}
