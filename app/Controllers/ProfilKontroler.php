<?php

namespace App\Controllers;

use App\Models\Korisnik;
use Framework\Http\Controller;

class ProfilKontroler extends Controller
{
    public function index()
    {
        $trenutni = Korisnik::query()->gdje('id', $this->get('id'))->prvi();

        if (!$trenutni) {
            $this->redirect('/');
        }

        $this->view('index', [
            'trenutni' => $trenutni,
            'poruke' => $trenutni->dajPoruke(),
            'prati' => $trenutni->dajKogaPrati(),
            'pratitelji' => $trenutni->dajPratitelje()
        ]);
    }
}