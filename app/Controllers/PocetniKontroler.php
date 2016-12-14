<?php

namespace App\Controllers;

use App\Models\Poruka;
use Framework\Kontroler;

class PocetniKontroler extends Kontroler
{
    public function index()
    {
        $this->view('index');
    }
}