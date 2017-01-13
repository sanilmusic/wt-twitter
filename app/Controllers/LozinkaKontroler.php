<?php

namespace App\Controllers;

use Framework\Http\Controller;

class LozinkaKontroler extends Controller
{
    public function forma()
    {
        $this->view('forma');
    }
}