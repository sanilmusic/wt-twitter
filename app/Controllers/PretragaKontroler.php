<?php

namespace App\Controllers;

use App\Models\Korisnik;
use Framework\Kontroler;

class PretragaKontroler extends Kontroler
{
    public function __construct()
    {
        if (!korisnik()) {
            $this->redirect('/');
        }
    }

    public function pretraga()
    {
        $q = $this->get('q');

        if (empty($q)) {
            echo '[]';
            return;
        }

        $rez = Korisnik::query()->gdjeSadrzi('ime', $q)->gdjeSadrzi('prezime', $q)->operator('ILI')->sve();

        if (count($rez) > 10) {
            // Uzmi 10 rezultata
            $rez = array_slice($rez, 0, 10);
        }

        echo $this->formatiraj($rez);
    }

    /**
     * Pretvara modele u JSON koji se može poslati na front-end.
     * 
     * @param  array $rez
     * @return string
     */
    protected function formatiraj(array $rez)
    {
        $niz = [];

        foreach ($rez as $korisnik) {
            $niz[] = [
                'id' => $korisnik->id,
                'tekst' => e($korisnik->dajPunoIme())
            ];
        }

        return json_encode($niz);
    }
}