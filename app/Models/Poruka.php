<?php

namespace App\Models;

use Framework\Model;

class Poruka extends Model
{
    /**
     * 
     * 
     * @var string
     */
    protected static $datoteka = 'poruke';

    /**
     * Pronalazi ime korisnika koji je postavio poruku.
     * 
     * @return string
     */
    public function dajImeKorisnika()
    {
        return Korisnik::query()->gdje('id', $this->korisnik)->prvi()->ime;
    }

    /**
     * Vraća skraćenu verziju teksta.
     * 
     * @return string
     */
    public function dajSkracenTekst()
    {
        if (strlen($this->tekst) <= 100) {
            return $this->tekst;
        }

        $razmakPos = strpos($this->tekst, ' ', 100);

        if ($razmakPos !== false) {
            return substr($this->tekst, 0, $razmakPos) . '...';
        }

        return substr($this->tekst, 0, 100) . '...';
    }
}