<?php

namespace App\Models;

use CodeIgniter\Model;

class EleveModel extends Model
{
    protected $table = 'eleve';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nom', 'id_classe'];

    /**
     * Récupère tous les étudiants
     */
    public function getAllEtudiants()
    {
        return $this->findAll();
    }

    /**
     * Récupère un étudiant avec ses options
     */
    public function getEtudiantWithOptions($eleveId)
    {
        $eleve = $this->find($eleveId);
        if ($eleve) {
            $eleve['options'] = $this->getEleveOptions($eleveId);
        }
        return $eleve;
    }

    /**
     * Récupère les options d'un étudiant par semestre
     */
    public function getEleveOptions($eleveId)
    {
        $db = \Config\Database::connect();
        return $db->table('eleve_option')
            ->select('eleve_option.*, option_etude.nom as option_nom, semestre.nom as semestre_nom')
            ->join('option_etude', 'eleve_option.id_option = option_etude.id')
            ->join('semestre', 'eleve_option.id_semestre = semestre.id')
            ->where('eleve_option.id_eleve', $eleveId)
            ->get()
            ->getResultArray();
    }

    /**
     * Récupère les notes d'un étudiant pour un semestre spécifique
     */
    public function getNotesBySemestre($eleveId, $semestreId = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('note')
            ->select('note.*, matiere.nom as matiere_nom, matiere.ue, matiere.credit, matiere.id_option, option_etude.nom as option_nom, semestre.nom as semestre_nom')
            ->join('matiere', 'note.id_matiere = matiere.id')
            ->join('semestre', 'matiere.id_semestre = semestre.id')
            ->leftJoin('option_etude', 'matiere.id_option = option_etude.id')
            ->where('note.id_eleve', $eleveId);

        if ($semestreId !== null) {
            $builder->where('matiere.id_semestre', $semestreId);
        }

        return $builder->orderBy('semestre.nom', 'ASC')
            ->orderBy('matiere.nom', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Récupère les notes du semestre 3 d'un étudiant
     */
    public function getNotesS3($eleveId)
    {
        return $this->getNotesBySemestre($eleveId, 1); // Semestre 3 a id=1
    }

    /**
     * Récupère les notes du semestre 4 d'un étudiant
     */
    public function getNotesS4($eleveId)
    {
        return $this->getNotesBySemestre($eleveId, 2); // Semestre 4 a id=2
    }

    /**
     * Récupère les notes filtrées par option pour S4
     */
    public function getNotesS4ByOption($eleveId, $optionId)
    {
        $db = \Config\Database::connect();
        return $db->table('note')
            ->select('note.*, matiere.nom as matiere_nom, matiere.ue, matiere.credit, option_etude.nom as option_nom')
            ->join('matiere', 'note.id_matiere = matiere.id')
            ->join('semestre', 'matiere.id_semestre = semestre.id')
            ->leftJoin('option_etude', 'matiere.id_option = option_etude.id')
            ->where('note.id_eleve', $eleveId)
            ->where('matiere.id_semestre', 2) // S4
            ->where(function ($builder) use ($optionId) {
                $builder->where('matiere.id_option', NULL)
                    ->orWhere('matiere.id_option', $optionId);
            })
            ->orderBy('matiere.nom', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Récupère toutes les notes (S3 + S4)
     */
    public function getAllNotes($eleveId)
    {
        $db = \Config\Database::connect();
        return $db->table('note')
            ->select('note.*, matiere.nom as matiere_nom, matiere.ue, matiere.credit, semestre.nom as semestre_nom, option_etude.nom as option_nom')
            ->join('matiere', 'note.id_matiere = matiere.id')
            ->join('semestre', 'matiere.id_semestre = semestre.id')
            ->leftJoin('option_etude', 'matiere.id_option = option_etude.id')
            ->where('note.id_eleve', $eleveId)
            ->orderBy('semestre.id', 'ASC')
            ->orderBy('matiere.nom', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Calcule la moyenne pour un ensemble de notes
     * Applique les règles de gestion:
     * - Note maximale par matière
     * - Meilleure note pour les matières optionnelles
     */
    public function calculerMoyenne($notes)
    {
        if (empty($notes)) {
            return 0;
        }

        $totalNotes = 0;
        $totalCredits = 0;
        $matieresTraitees = [];

        foreach ($notes as $note) {
            $matiereName = $note['matiere_nom'];

            // Règle 1: Pour une même matière, garder la note maximale
            if (!isset($matieresTraitees[$matiereName])) {
                $matieresTraitees[$matiereName] = [
                    'note' => $note['note'],
                    'credit' => $note['credit'],
                    'is_optional' => $note['id_option'] !== null
                ];
            } else {
                // Garder la note maximale
                if ($note['note'] > $matieresTraitees[$matiereName]['note']) {
                    $matieresTraitees[$matiereName]['note'] = $note['note'];
                }
            }
        }

        // Règle 2: Pour les matières optionnelles, garder la meilleure note
        $optionalsByOption = [];
        foreach ($matieresTraitees as $matiereName => $data) {
            if ($data['is_optional']) {
                $optionId = null;
                foreach ($notes as $note) {
                    if ($note['matiere_nom'] === $matiereName) {
                        $optionId = $note['id_option'];
                        break;
                    }
                }

                if (!isset($optionalsByOption[$optionId])) {
                    $optionalsByOption[$optionId] = [
                        'matiere' => $matiereName,
                        'note' => $data['note'],
                        'credit' => $data['credit']
                    ];
                } else {
                    if ($data['note'] > $optionalsByOption[$optionId]['note']) {
                        $optionalsByOption[$optionId] = [
                            'matiere' => $matiereName,
                            'note' => $data['note'],
                            'credit' => $data['credit']
                        ];
                    }
                }
            }
        }

        // Calcul de la moyenne pondérée
        foreach ($matieresTraitees as $matiereName => $data) {
            if (!$data['is_optional']) {
                $totalNotes += $data['note'] * $data['credit'];
                $totalCredits += $data['credit'];
            }
        }

        foreach ($optionalsByOption as $best) {
            $totalNotes += $best['note'] * $best['credit'];
            $totalCredits += $best['credit'];
        }

        return $totalCredits > 0 ? round($totalNotes / $totalCredits, 2) : 0;
    }

    /**
     * Obtient les statistiques complètes d'un étudiant
     */
    public function getEtudiantStats($eleveId)
    {
        $notesS3 = $this->getNotesS3($eleveId);
        $notesS4 = $this->getNotesS4($eleveId);
        $allNotes = $this->getAllNotes($eleveId);

        return [
            'notes_s3' => $notesS3,
            'notes_s4' => $notesS4,
            'all_notes' => $allNotes,
            'moyenne_s3' => $this->calculerMoyenne($notesS3),
            'moyenne_s4' => $this->calculerMoyenne($notesS4),
            'moyenne_generale' => $this->calculerMoyenne($allNotes),
        ];
    }
}
