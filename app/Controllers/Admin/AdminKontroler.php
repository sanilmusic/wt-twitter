<?php

namespace App\Controllers\Admin;

use Framework\Kontroler;

abstract class AdminKontroler extends Kontroler
{
    public function __construct()
    {
        parent::__construct();

        if (!korisnik() || !korisnik()->admin()) {
            $this->redirect('/');
        }
    }
}