<?php

namespace App\Controllers;

use App\Models\UserModel;

class RegisterController extends BaseController
{
    public function create(): string
    {
        return view('register');
    }

    public function store()
    {
        helper(['url', 'form']);

        if (! $this->request->is('post')) {
            return redirect()->to(base_url('register'));
        }

        $rules = [
            'nom'            => 'required|min_length[2]|max_length[255]',
            'email'          => 'required|valid_email|is_unique[utilisateur.email]',
            'password'       => 'required|min_length[6]',
            'pass_confirm'   => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nom = trim((string) $this->request->getPost('nom'));
        $email = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        $userModel = new UserModel();

        $data = [
            'nom'   => $nom,
            'email' => $email,
            'mdp'   => password_hash($password, PASSWORD_DEFAULT),
        ];

        try {
            $userModel->insert($data);
        } catch (\Exception $e) {
            // fallback: return with error
            return redirect()->back()->withInput()->with('errors', ['db' => $e->getMessage()]);
        }

        // success — redirect to login with flash message
        session()->setFlashdata('success', 'Compte créé avec succès. Vous pouvez vous connecter.');
        return redirect()->to(base_url('/'));
    }
}
