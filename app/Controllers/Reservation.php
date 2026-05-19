<?php

namespace App\Controllers;

class Reservation extends BaseController
{
    public function reserver($creneauId)
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/login')
                ->with(
                    'error',
                    'Veuillez vous connecter.'
                );
        }

        $userId = session()->get('user_id');

        $db = \Config\Database::connect();

        $creneau = $db->table('creneaux')
            ->where('id', $creneauId)
            ->get()
            ->getRowArray();

        if (!$creneau) {

            return redirect()->back()->with(
                'error',
                'Créneau introuvable.'
            );
        }

        if ($creneau['places_dispo'] <= 0) {

            return redirect()->back()->with(
                'error',
                'Ce créneau est complet.'
            );
        }

        $existing = $db->table('reservations')
                ->where('user_id', $userId)
                ->where('creneau_id', $creneauId)
                ->get()
                ->getRowArray();

        if ($existing) {

            return redirect()->back()->with(
                'error',
                'Vous avez déjà réservé ce créneau.'
            );
        }

        $db->table('reservations')->insert([

            'user_id' => $userId,

            'creneau_id' => $creneauId,

            'statut' => 'en_attente',

            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $db->table('creneaux')
            ->where('id', $creneauId)
            ->update([
                'places_dispo' =>
                    $creneau['places_dispo'] - 1
            ]);

        return redirect()->to('/dashboard')->with(
            'success',
            'Réservation effectuée avec succès.'
        );
    }

    public function confirmer($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')
                ->with('error', 'Accès refusé.');
        }

        $db = \Config\Database::connect();

        $reservation = $db->table('reservations')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$reservation) {
            return redirect()->to('/dashboard')
                ->with('error', 'Réservation introuvable.');
        }

        if ($reservation['statut'] !== 'en_attente') {
            return redirect()->to('/dashboard')
                ->with('error', 'Cette réservation a déjà été traitée.');
        }

        $db->table('reservations')
            ->where('id', $id)
            ->update([
                'statut' => 'confirmee'
            ]);

        return redirect()->to('/dashboard')
            ->with('success', 'Réservation confirmée avec succès.');
    }

    public function refuser($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')
                ->with('error', 'Accès refusé.');
        }

        $db = \Config\Database::connect();

        $reservation = $db->table('reservations')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$reservation) {
            return redirect()->to('/dashboard')
                ->with('error', 'Réservation introuvable.');
        }

        if ($reservation['statut'] !== 'en_attente') {
            return redirect()->to('/dashboard')
                ->with('error', 'Cette réservation a déjà été traitée.');
        }

        $db->table('reservations')
            ->where('id', $id)
            ->update([
                'statut' => 'annulee'
            ]);

        $creneau = $db->table('creneaux')
            ->where('id', $reservation['creneau_id'])
            ->get()
            ->getRowArray();

        if ($creneau) {
            $db->table('creneaux')
                ->where('id', $reservation['creneau_id'])
                ->update([
                    'places_dispo' => $creneau['places_dispo'] + 1
                ]);
        }

        return redirect()->to('/dashboard')
            ->with('success', 'Réservation refusée avec succès.');
    }

    public function annuler($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')
                ->with('error', 'Accès refusé.');
        }

        $db = \Config\Database::connect();

        $reservation = $db->table('reservations')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$reservation) {
            return redirect()->to('/admin/dashboard')
                ->with('error', 'Réservation introuvable.');
        }

        if ($reservation['statut'] === 'annulee') {
            return redirect()->to('/admin/dashboard')
                ->with('error', 'Cette réservation est déjà annulée.');
        }

        $db->table('reservations')
            ->where('id', $id)
            ->update([
                'statut' => 'annulee'
            ]);

        if ($reservation['statut'] !== 'annulee') {
            $creneau = $db->table('creneaux')
                ->where('id', $reservation['creneau_id'])
                ->get()
                ->getRowArray();

            if ($creneau) {
                $db->table('creneaux')
                    ->where('id', $reservation['creneau_id'])
                    ->update([
                        'places_dispo' => $creneau['places_dispo'] + 1
                    ]);
            }
        }

        return redirect()->to('/admin/dashboard')
            ->with('success', 'Réservation annulée avec succès.');
    }
}