<?php

namespace App\Models;

use Framework\Model;

class Korisnik extends Model
{
    /**
     * 
     * 
     * @var string
     */
    protected static $datoteka = 'korisnici';

    /**
     * Da li korisnik ima admin privilegije?
     * 
     * @return bool
     */
    public function admin()
    {
        return ($this->admin == 1);
    }
}