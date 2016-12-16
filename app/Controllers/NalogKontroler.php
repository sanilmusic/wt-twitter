<?php

namespace App\Controllers;

use Framework\Kontroler;

class NalogKontroler extends Kontroler
{
    public function index()
    {
        $this->view('index');
    }
}