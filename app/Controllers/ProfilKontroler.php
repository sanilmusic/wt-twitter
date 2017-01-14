<?php

namespace App\Controllers;

use App\Models\Korisnik;
use Framework\Http\Controller;
use Framework\Storage\Database\Connection;

class ProfilKontroler extends Controller
{
    public function index()
    {
        $trenutni = $this->trenutniKorisnik();

        $this->view('index', [
            'trenutni' => $trenutni,
            'poruke' => $trenutni->dajPoruke(),
            'prati' => $trenutni->dajKogaPrati(),
            'pratitelji' => $trenutni->dajPratitelje()
        ]);
    }

    public function toggle()
    {
        $trenutni = $this->trenutniKorisnik();
        $korisnik = korisnik();

        if (!$korisnik || $trenutni->id == $korisnik->id) {
            return;
        }

        $veza = Connection::veza();

        // Provjeri da li već prati
        $stmt = $veza->query('SELECT COUNT(*) FROM pratitelji WHERE pratitelj_id = ' . $korisnik->id . ' AND prati_id = ' . $trenutni->id);

        if ($stmt->fetchColumn(0) == 0) {
            $veza->exec('INSERT INTO pratitelji VALUES (' . $korisnik->id . ', ' . $trenutni->id . ')');
        } else {
            $veza->exec('DELETE FROM pratitelji WHERE pratitelj_id = ' . $korisnik->id . ' AND prati_id = ' . $trenutni->id);
        }

        echo '';
    }

    /**
     * Pronalazi korisnika koji je definisan u URL-u.
     * 
     * @return \App\Models\Korisnik
     */
    protected function trenutniKorisnik()
    {
        $trenutni = Korisnik::query()->gdje('id', $this->get('id'))->prvi();

        if (!$trenutni) {
            $this->redirect('/');
        }

        return $trenutni;
    }
}