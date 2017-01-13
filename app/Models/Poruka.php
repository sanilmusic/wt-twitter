<?php

namespace App\Models;

use Framework\Storage\Database\Model;

class Poruka extends Model
{
   /**
     * Naziv tabele u kojoj se nalaze podaci.
     * 
     * @var string
     */
    public static $tabela = 'poruke';

    /**
     * Pronalazi ime korisnika koji je postavio poruku.
     * 
     * @return string
     */
    public function dajImeKorisnika()
    {
        return Korisnik::query()->gdje('id', $this->korisnik_id)->prvi()->ime;
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