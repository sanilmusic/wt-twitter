<?php

namespace App\Controllers\Admin;

use Framework\Http\Controller;

abstract class AdminKontroler extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!korisnik() || !korisnik()->admin()) {
            $this->redirect('/');
        }
    }
}