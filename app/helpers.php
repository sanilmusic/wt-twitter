<?php

use App\Models\Korisnik;

/**
 * Vraća model trenutnog korisnika ili NULL ukoliko korisnik nije prijavljen.
 * 
 * @return \App\Models\Korisnik
 */
function korisnik()
{
    static $korisnik, $provjeren = false;

    if ($provjeren) {
        return $korisnik;
    }

    // Kasnije provjere nisu potrebne
    $provjeren = true;

    if (!array_key_exists('userId', $_SESSION)) {
        return null;
    }

    $korisnik = Korisnik::query()->gdje('id', $_SESSION['userId'])->prvi();

    return $korisnik;
}