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
 * Provjerava da li je trenutni posjetitelj prijavljeni korisnik ili gost.
 * 
 * @return bool
 */
function prijavljen()
{
    return false;
}