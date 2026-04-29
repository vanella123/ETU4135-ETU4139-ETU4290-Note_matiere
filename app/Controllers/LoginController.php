<?php

namespace App\Controllers;

use App\Models\UserModel;

class LoginController extends BaseController
{
    public function index(): string
    {
        return view('login');
    }

    public function authenticate()
    {
        helper('url');

        if (! $this->request->is('post')) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Méthode non autorisée.',
            ])->setStatusCode(405);
        }

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[1]',
        ];

        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Veuillez saisir un email valide et un mot de passe.',
                'errors'  => $this->validator->getErrors(),
            ])->setStatusCode(422);
        }

        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->verifyCredentials($email, $password);

        if ($user === null) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Identifiants invalides.',
            ])->setStatusCode(401);
        }

        $session = session();
        $session->regenerate(true);
        $session->set([
            'user_id'    => $user['id'],
            'user_name'  => $user['nom'],
            'user_email' => $user['email'],
            'logged_in'  => true,
        ]);

        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Connexion réussie.',
            'redirect' => base_url('dashboard'),
        ]);
    }
}
