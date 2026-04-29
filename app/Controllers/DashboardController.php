<?php

namespace App\Controllers;

use App\Models\EleveModel;

class DashboardController extends BaseController
{
    public function index(): string
    {
        helper('url');

        $eleves = (new EleveModel())
            ->select('eleve.id, eleve.nom, classe.nom AS classe')
            ->join('classe', 'classe.id = eleve.id_classe')
            ->findAll();

        return view('dashboard', ['eleves' => $eleves]);
    }
}