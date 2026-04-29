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
    return view('Bulletin/form', [
        'eleves' => (new \App\Models\EleveModel())->findAll(),
        'options' => (new \App\Models\OptionModel())->findAll(),
        'matieres' => (new \App\Models\MatiereModel())->findAll(),
    ]);
}

    public function store()
    {
        (new BulletinModel())->save([
            'id_eleve' => $this->request->getPost('id_eleve'),
            'id_option' => $this->request->getPost('id_option'),
            'id_matiere' => $this->request->getPost('id_matiere'),
            'note' => $this->request->getPost('note'),
            'resultat' => $this->request->getPost('resultat'),
        ]);

        return redirect()->to('/eleves');
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