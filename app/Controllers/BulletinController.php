<?php

namespace App\Controllers;

use App\Models\EleveModel;
use App\Models\OptionModel;
use App\Models\MatiereModel;
use App\Models\BulletinModel;

class BulletinController extends BaseController
{
    public function create()
    {
        helper(['url', 'form']);

        return view('Bulletin/form', [
            'eleves' => (new EleveModel())
                ->select('eleve.id, eleve.nom, classe.nom AS classe')
                ->join('classe', 'classe.id = eleve.id_classe')
                ->findAll(),
            'options' => (new OptionModel())->findAll(),
            'matieres' => (new MatiereModel())->findAll(),
        ]);
    }

    public function store()
    {
        helper(['url', 'form']);

        $rules = [
            'id_eleve'   => 'required|is_not_unique[eleve.id]',
            'id_option'  => 'required|is_not_unique[option_etude.id]',
            'id_matiere' => 'required|is_not_unique[matiere.id]',
            'note'       => 'required|decimal',
            'resultat'   => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new BulletinModel())->save([
            'id_eleve' => $this->request->getPost('id_eleve'),
            'id_option' => $this->request->getPost('id_option'),
            'id_matiere' => $this->request->getPost('id_matiere'),
            'note' => $this->request->getPost('note'),
            'resultat' => $this->request->getPost('resultat'),
        ]);

        return redirect()->to(base_url('bulletin/create'))->with('success', 'Note enregistrée. Vous pouvez en saisir une autre.');
    }

    public function listeEleves()
    {
        $eleves = (new EleveModel())
            ->select('eleve.id, eleve.nom, classe.nom AS classe')
            ->join('classe', 'classe.id = eleve.id_classe')
            ->findAll();

        return view('Bulletin/eleves/list', ['eleves' => $eleves]);
    }
}