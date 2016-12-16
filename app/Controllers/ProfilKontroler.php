<?php

namespace App\Controllers;

use Framework\Kontroler;

class ProfilKontroler extends Kontroler
{
    public function index()
    {
        $this->view('index');
    }
}