<?php

namespace App\Models;

use Framework\Storage\Database\Model;
use App\Models\Poruka;

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
}