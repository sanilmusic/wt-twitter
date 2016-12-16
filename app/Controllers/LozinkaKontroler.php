<?php

namespace App\Controllers;

use Framework\Kontroler;

class LozinkaKontroler extends Kontroler
{
    public function forma()
    {
        $this->view('forma');
    }
}