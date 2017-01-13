<?php

namespace App\Controllers;

use App\Models\Poruka;
use Framework\Http\Controller;

class PocetniKontroler extends Controller
{
    public function index()
    {
        $this->view('index');
    }
}