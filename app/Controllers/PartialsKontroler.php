<?php

namespace App\Controllers;

use Framework\Kontroler;

class PartialsKontroler extends Kontroler
{
    public function index()
    {
        $this->view('index');
    }

    public function izgubljenaLozinka()
    {
        $this->view('izgubljenaLozinka');
    }

    public function nalog()
    {
        $this->view('nalog');
    }

    public function prati()
    {
        $this->view('prati');
    }

    public function pratitelji()
    {
        $this->view('pratitelji');
    }

    public function prijavljen()
    {
        $this->view('prijavljen');
    }

    public function profil()
    {
        $this->view('profil');
    }
}