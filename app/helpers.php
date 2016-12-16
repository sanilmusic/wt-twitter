<?php

use Framework\Exceptions\InvalidViewException;

/**
 * Učitaj pogled i prikaži ga korisniku.
 * 
 * @param  string $ime
 * @param  array $data
 * @return void
 */
function view($ime, $data = [])
{
    $lok = PATH . '/app/Views/' . $ime . '.php';

    if (!file_exists($lok)) {
        throw new InvalidViewException;
    }

    extract($data);

    require $lok;
}

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

    $korisnik = Korisnik::traziId($_SESSION['userId']);

    return $korisnik;
}