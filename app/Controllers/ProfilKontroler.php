<?php

namespace App\Controllers;

use App\Models\Korisnik;
use Framework\Http\Controller;

class ProfilKontroler extends Controller
{
    public function index()
    {
        $korisnik = Korisnik::query()->gdje('id', $this->get('id'))->prvi();

        if (!$korisnik) {
            $this->redirect('/');
        }

        $this->view('index', [
            'korisnik' => $korisnik,
            'poruke' => $korisnik->dajPoruke()
        ]);
    }
}