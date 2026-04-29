<?php

namespace App\Controllers;

use App\Models\EleveModel;
use App\Models\NoteModel;

class StudentController extends BaseController
{
    protected $eleveModel;
    protected $noteModel;

    public function __construct()
    {
        $this->eleveModel = new EleveModel();
        $this->noteModel = new NoteModel();
    }

    /**
     * Affiche la liste de tous les étudiants
     */
    public function index()
    {
        $etudiants = $this->eleveModel->getAllEtudiants();

        $data = [
            'title' => 'Liste des Étudiants',
            'etudiants' => $etudiants
        ];

        return view('student/list', $data);
    }

    /**
     * Affiche les notes d'un étudiant
     * Paramètres: 
     *   - id: ID de l'étudiant
     *   - type: 's3', 's4', ou 'l2' (par défaut 'all')
     *   - option: ID de l'option (pour S4)
     */
    public function details($id = null, $type = 'all', $optionId = null)
    {
        if (!$id) {
            return redirect()->to('/student');
        }

        $etudiant = $this->eleveModel->getEtudiantWithOptions($id);

        if (!$etudiant) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $stats = $this->eleveModel->getEtudiantStats($id);
        $notes = [];
        $moyenne = 0;
        $titre = '';

        switch ($type) {
            case 's3':
                $notes = $stats['notes_s3'];
                $moyenne = $stats['moyenne_s3'];
                $titre = 'Semestre 3 (S3)';
                break;

            case 's4':
                if ($optionId) {
                    $notes = $this->eleveModel->getNotesS4ByOption($id, $optionId);
                } else {
                    $notes = $stats['notes_s4'];
                }
                $moyenne = $stats['moyenne_s4'];
                $titre = 'Semestre 4 (S4)';
                break;

            case 'l2':
                $notes = $stats['all_notes'];
                $moyenne = $stats['moyenne_generale'];
                $titre = 'Licence 2 (L2) - Tous les semestres';
                break;

            default:
                $notes = $stats['all_notes'];
                $moyenne = $stats['moyenne_generale'];
                $titre = 'Toutes les notes';
        }

        $data = [
            'title' => 'Détail des notes',
            'etudiant' => $etudiant,
            'notes' => $notes,
            'moyenne' => $moyenne,
            'type' => $type,
            'titre' => $titre,
            'stats' => $stats,
            'optionId' => $optionId
        ];

        return view('student/details', $data);
    }

    /**
     * Formulaire de modification de notes
     */
    public function editNotes($eleveId = null)
    {
        if (!$eleveId) {
            return redirect()->to('/student');
        }

        $etudiant = $this->eleveModel->getEtudiantWithOptions($eleveId);

        if (!$etudiant) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $allNotes = $this->eleveModel->getAllNotes($eleveId);

        $data = [
            'title' => 'Modifier les notes',
            'etudiant' => $etudiant,
            'notes' => $allNotes
        ];

        return view('student/edit_notes', $data);
    }

    /**
     * Sauvegarde une note modifiée (API)
     */
    public function updateNote()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Requête invalide']);
        }

        $eleveId = $this->request->getPost('eleve_id');
        $matiereId = $this->request->getPost('matiere_id');
        $noteValue = $this->request->getPost('note');

        // Validation
        if (empty($eleveId) || empty($matiereId) || $noteValue === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Données incomplètes'
            ]);
        }

        if (!is_numeric($noteValue) || $noteValue < 0 || $noteValue > 20) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'La note doit être entre 0 et 20'
            ]);
        }

        $updated = $this->noteModel->updateNote($eleveId, $matiereId, $noteValue);

        if ($updated) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Note mise à jour avec succès'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour'
            ]);
        }
    }
}
