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

    // Omogući pristup prijavljenom korisniku
    $korisnik = korisnik();

    require $lok;
}

/**
 * Počisti tekst koji se ispisuje tako da se spriječe XSS napadi.
 * 
 * @param  string $tekst
 * @return string
 */
function e($tekst)
{
    return htmlspecialchars($tekst);
}