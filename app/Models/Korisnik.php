<?php

namespace App\Models;

use PDO;
use App\Models\Poruka;
use Framework\Storage\Database\Model;
use Framework\Storage\Database\Connection;

class Korisnik extends Model
{
    /**
     * Naziv tabele u kojoj se nalaze podaci.
     * 
     * @var string
     */
    public static $tabela = 'korisnici';

    /**
     * Da li korisnik ima admin privilegije?
     * 
     * @return bool
     */
    public function admin()
    {
        return ($this->admin == 1);
    }

    /**
     * Vraća spojeno ime i prezime.
     * 
     * @return string
     */
    public function dajPunoIme()
    {
        return $this->ime . ' ' . $this->prezime;
    }

    /**
     * Vraća niz poruka koje je korisnik ostavio.
     * 
     * @return array
     */
    public function dajPoruke()
    {
        return Poruka::query()->gdje('korisnik_id', $this->id)->sve();
    }

    /**
     * Vraća niz korisnika koje trenutni korisnik prati.
     * 
     * @return array
     */
    public function dajKogaPrati()
    {
        $stmt = Connection::veza()->query('SELECT DISTINCT prati_id FROM pratitelji WHERE pratitelj_id = ' . $this->id, PDO::FETCH_ASSOC);

        return $this->dajKorisnike($stmt->fetchAll(), 'prati_id');
    }

    /**
     * Vraća niz korisnika koji prate trenutnog korisnika.
     * 
     * @return array
     */
    public function dajPratitelje()
    {
        $stmt = Connection::veza()->query('SELECT DISTINCT pratitelj_id FROM pratitelji WHERE prati_id = ' . $this->id, PDO::FETCH_ASSOC);

        return $this->dajKorisnike($stmt->fetchAll(), 'pratitelj_id');
    }

    /**
     * Posmatra niz redova i na osnovu definisane kolone pronalazi korisnike.
     * 
     * @param  array $redovi
     * @param  string $kolona
     * @return array
     */
    protected function dajKorisnike($redovi, $kolona)
    {
        if (empty($redovi)) {
            return [];
        }

        $query = static::query()->operator('ILI');
        foreach ($redovi as $r) {
            $query->gdje('id', $r[$kolona]);
        }

        return $query->sve();
    }

    /**
     * Vraća poruke korisnika koje trenutni korisnik prati.
     * 
     * @return array
     */
    public function dajPorukeOstalih()
    {
        $prati = $this->dajKogaPrati();

        if (empty($prati)) {
            return [];
        }

        $query = Poruka::query()->operator('ILI');
        foreach ($prati as $k) {
            $query->gdje('korisnik_id', $k->id);
        }

        return $query->sve();
    }

    /**
     * Provjeri da li korisnik prati drugog korisnika.
     * 
     * @param  int $id
     * @return bool
     */
    public function daLiPrati($id)
    {
        $stmt = Connection::veza()->query('SELECT COUNT(*) FROM pratitelji WHERE pratitelj_id = ' . $this->id . ' AND prati_id = ' . $id);

        return ($stmt->fetchColumn(0) == 1);
    }
}