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
        return Poruka::query()->gdje('korisnik', $this->id)->sve();
    }

    /**
     * Vraća niz korisnika koje trenutni korisnik prati.
     * 
     * @return array
     */
    public function dajKogaPrati()
    {
        $stmt = Connection::veza()->query('SELECT DISTINCT prati_id FROM pratitelji WHERE pratitelj_id = ' . $this->id, PDO::FETCH_ASSOC
        );

        if ($stmt->rowCount() == 0) {
            return [];
        }

        $rezultat = $stmt->fetchAll();

        $query = static::query()->operator('ILI');
        foreach ($rezultat as $r) {
            $query->gdje('id', $r['prati_id']);
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
}