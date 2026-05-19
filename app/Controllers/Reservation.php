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
            return redirect()->to('/dashboard')
                ->with('error', 'Réservation introuvable.');
        }

        if ($reservation['statut'] === 'annulee') {
            return redirect()->to('/dashboard')
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

        return redirect()->to('/dashboard')
            ->with('success', 'Réservation annulée avec succès.');
    }

    public function client_reservations()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $name = session()->get('user_name');
        $db = \Config\Database::connect();

        $reservations = $db->table('reservations r')
            ->select('
                r.id,
                r.statut,
                c.date_debut,
                c.date_fin,
                ressources.nom AS ressource_nom,
                ressources.type AS ressource_type
            ')
            ->join('creneaux c', 'c.id = r.creneau_id')
            ->join('ressources', 'ressources.id = c.ressource_id')
            ->where('r.user_id', $userId)
            ->where('r.statut !=', 'annulee')
            ->orderBy('c.date_debut', 'ASC')
            ->get()
            ->getResultArray();

        return view('client/reservations', [
            'reservations' => $reservations,
            'name' => $name
        ]);
    }

    public function admin_reservations()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')
                ->with('error', 'Accès refusé.');
        }
        $name = session()->get('user_name');
        $db = \Config\Database::connect();

        $reservations = $db->table('reservations r')
                ->select('
                    r.id,
                    r.statut,
                    r.created_at,
                    u.nom AS user_name,
                    u.email AS user_email,
                    c.date_debut,
                    c.date_fin,
                    ressources.nom AS ressource_nom,
                    ressources.type AS ressource_type
                ')
                ->join('users u', 'u.id = r.user_id')
                ->join('creneaux c', 'c.id = r.creneau_id')
                ->join('ressources', 'ressources.id = c.ressource_id')
                ->orderBy('c.date_debut', 'ASC')
                ->get()
                ->getResultArray();

        return view('admin/reservations', [
            'reservations' => $reservations,
            'name' => $name
        ]);
    }

    public function reservation() {
        if(!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        if(session()->get('role') !== 'admin') {
            return $this->client_reservations();
        } else {
            return $this->admin_reservations();
        }
    }
}