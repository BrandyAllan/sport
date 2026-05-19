<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profil extends BaseController
{
    // Afficher la page du profil
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // On récupère les données de session actuelles à envoyer à la vue
        $data = [
            'name' => session()->get('user_name'),
            'role' => session()->get('role'),
        ];

        return view('auth/profil', $data); // Ajuste le chemin de ta vue si nécessaire (ex: 'client/profil')
    }

    // Traiter la mise à jour du profil
    public function update()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $newName = $this->request->getPost('name');
        
        $currentPassword = $this->request->getPost('current_password');
        $newPassword     = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        if (!$newName) {
            return redirect()->back()->with('error', 'Le nom complet est obligatoire.');
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur introuvable.');
        }

        // Tableau des données à mettre à jour
        $updateData = [
            'nom' => $newName
        ];

        // Vérifier si l'utilisateur souhaite modifier son mot de passe
        if (!empty($newPassword) || !empty($currentPassword) || !empty($confirmPassword)) {
            
            // 1. Vérifier si tous les champs de mot de passe sont remplis
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                return redirect()->back()->with('error', 'Pour changer de mot de passe, veuillez remplir tous les champs correspondants.');
            }

            // 2. Vérifier si le mot de passe actuel saisi est correct
            if (!password_verify($currentPassword, $user['password'])) {
                return redirect()->back()->with('error', 'Le mot de passe actuel est incorrect.');
            }

            // 3. Vérifier si le nouveau mot de passe et sa confirmation correspondent
            if ($newPassword !== $confirmPassword) {
                return redirect()->back()->with('error', 'Le nouveau mot de passe et sa confirmation ne correspondent pas.');
            }

            // 4. Validation optionnelle de longueur (ex: minimum 4 caractères)
            if (strlen($newPassword) < 4) {
                return redirect()->back()->with('error', 'Le nouveau mot de passe doit contenir au moins 4 caractères.');
            }

            // Ajouter le mot de passe hashé aux données à modifier
            $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        // Sauvegarde en base de données via le UserModel
        if ($userModel->update($userId, $updateData)) {
            
            // CRUCIAL : Mettre à jour immédiatement les variables de session pour refléter le nouveau nom sur l'interface
            session()->set('user_name', $newName);

            return redirect()->back()->with('succes', 'Votre profil a été mis à jour avec succès.');
        } else {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour.');
        }
    }
}