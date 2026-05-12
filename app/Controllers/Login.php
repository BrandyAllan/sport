<?php

namespace App\Controllers;
use App\Models\UserModel;

class Login extends BaseController
{
    public function showLogin(): string {
        return view('auth/login');
    }

    public function doLogin()
    {
        $email = $this->request->getPost('email');
        $pwd   = $this->request->getPost('password');

        if (!$email || !$pwd) {

            return redirect()->back()->with('error', 
                'Veuillez remplir tous les champs.'
            );
        }

        $userModel = new UserModel();

        $user = $userModel
                    ->where('email', $email)
                    ->first();

        if (!$user) {

            return redirect()->back()->with('error',
                'Email ou mot de passe incorrect.'
            );
        }

        if (!password_verify($pwd, $user['password'])) {

            return redirect()->back()->with('error',
                'Email ou mot de passe incorrect.'
            );
        }

        if($user['role'] === 'admin') {
            session()->set([
                'user_id'    => $user['id'],
                'user_name'  => $user['nom'],
                'user_email' => $user['email'],
                'role'       => 'admin',
                'logged_in'  => true
            ]);

            return redirect()->to('/admin/dashboard');
        }

        session()->set([
            'user_id'    => $user['id'],
            'user_name'  => $user['nom'],
            'user_email' => $user['email'],
            'role'       => 'client',
            'logged_in'  => true
        ]);

        return redirect()->to('/creneau');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
