<?php

namespace App\Controllers;

use Framework\Http\Controller;

class NalogKontroler extends Controller
{
    public function index()
    {
        $this->view('index');
    }
}