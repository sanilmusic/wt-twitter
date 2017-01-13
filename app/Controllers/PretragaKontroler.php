<?php

namespace App\Controllers;

use App\Models\Korisnik;
use Framework\Http\Controller;

class PretragaKontroler extends Controller
{
    public function __construct()
    {
        if (!korisnik()) {
            $this->redirect('/');
        }
    }

    public function pretraga()
    {
        $this->view('index', [
            'rez' => array_chunk($this->trazi(), 2)
        ]);
    }

    public function ajax()
    {
        $rez = $this->trazi();

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
    private function formatiraj(array $rez)
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

    /**
     * Traži korisnike koji u imenu ili prezimenu imaju specifiricani podstring.
     * 
     * @return array
     */
    private function trazi()
    {
        $q = $this->get('q');

        if (empty($q)) {
            return [];
        }

        return Korisnik::query()->gdjeSadrzi('ime', $q)->gdjeSadrzi('prezime', $q)->operator('ILI')->sve();
    }
}