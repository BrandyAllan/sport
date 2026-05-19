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
            ->first();

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
}