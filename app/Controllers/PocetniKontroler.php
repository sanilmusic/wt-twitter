<?php

namespace App\Controllers;

use App\Models\Poruka;
use Framework\Http\Controller;

class PocetniKontroler extends Controller
{
    public function index()
    {
        $this->view('index', [
            'porukeOstalih' => $this->porukeOstalih()
        ]);
    }

    protected function porukeOstalih() {
        if (!($korisnik = korisnik())) {
            return [];
        }

        return $korisnik->dajPorukeOstalih();
    }
}