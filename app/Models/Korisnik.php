<?php

namespace App\Models;

use Framework\Model;
use App\Models\Poruka;

class Korisnik extends Model
{
    /**
     * 
     * 
     * @var string
     */
    protected static $datoteka = 'korisnici';

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