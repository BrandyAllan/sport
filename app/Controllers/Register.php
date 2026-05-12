<?php

namespace App\Controllers;

use App\Models\UserModel;

class Register extends BaseController
{
    public function showRegister(): string
    {
        return view('auth/register');
    }

    public function doRegister()
    {
        $name     = $this->request->getPost('nom');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$name || !$email || !$password) {

            return redirect()->back()->with(
                'error',
                'Veuillez remplir tous les champs.'
            );
        }

        if (strlen($password) < 8) {

            return redirect()->back()->with(
                'error',
                'Le mot de passe doit contenir au moins 8 caractères.'
            );
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            return redirect()->back()->with(
                'error',
                'Veuillez entrer un email valide.'
            );
        }

        $userModel = new UserModel();

        $existingUser = $userModel
                            ->where('email', $email)
                            ->first();

        if ($existingUser) {

            return redirect()->back()->with(
                'error',
                'Cet email est déjà utilisé.'
            );
        }

        $userData = [

            'nom' => $name,

            'email' => $email,

            'password' => password_hash(
                $password,
                PASSWORD_DEFAULT
            ),

            'role' => 'client',

            'created_at' => date('Y-m-d H:i:s')
        ];

        $userId = $userModel->insert($userData);

        if (!$userId) {

            return redirect()->back()->with(
                'error',
                'Erreur lors de la création du compte.'
            );
        }

        session()->set([

            'user_id' => $userId,

            'user_name' => $name,

            'user_email' => $email,

            'logged_in' => true
        ]);

        return redirect()->to('/creneau')->with(
            'success',
            'Compte créé avec succès.'
        );
    }
}