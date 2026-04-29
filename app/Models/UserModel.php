<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'email', 'mdp'];
    protected $returnType = 'array';
    protected $useTimestamps = false;

    public function findByEmail(string $email): ?array
    {
        $user = $this->select('id, nom, email, mdp')
            ->where('email', $email)
            ->first();

        return $user ?: null;
    }

    public function verifyCredentials(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);

        if ($user === null) {
            return null;
        }

        $storedPassword = (string) $user['mdp'];

        $passwordIsValid = password_verify($password, $storedPassword)
            || hash_equals($storedPassword, $password);

        return $passwordIsValid ? $user : null;
    }
}