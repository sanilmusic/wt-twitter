<?php

namespace App\Models\Xml;

use Framework\Storage\Xml\Model;

class Poruka extends Model
{
   /**
     * Naziv datoteke u kojoj se nalazi podaci.
     * 
     * @var string
     */
    protected static $datoteka = 'poruke';

    /**
     * Pronalazi korisnika koji je postavio poruku.
     * 
     * @return \App\Models\Xml\Korisnik
     */
    public function korisnik()
    {
        return Korisnik::query()->gdje('id', $this->korisnik_id)->prvi();
    }

    /**
     * Pronalazi ime korisnika koji je postavio poruku.
     * 
     * @return string
     */
    public function dajImeKorisnika()
    {
        return $this->korisnik()->ime;
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