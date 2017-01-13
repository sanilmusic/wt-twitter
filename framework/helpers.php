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

/**
 * Omogućava adresiranje niza uz pomoć "dot" notacije.
 * 
 * @param  array $niz
 * @param  string $sta
 * @param  mixed $default
 * @return mixed
 */
function dot(array $niz, $sta = null, $default = null)
{
    if ($sta === null) {
        return $niz;
    }

    $trenutno = $niz;
    $segmenti = explode('.', $sta);

    foreach ($segmenti as $segment) {
        if (is_array($trenutno) && array_key_exists($segment, $trenutno)) {
            $trenutno = $trenutno[$segment];
        } else {
            return $default;
        }
    }

    return $trenutno;
}

/**
 * Vraća vrijednost konfiguracijske postavke ili $default ukoliko takva ne postoji.
 * 
 * @param  string $sta
 * @param  mixed $default
 * @return mixed
 */
function config($sta, $default = null)
{
    static $config = [];

    if (empty($config)) {
        $config = require PATH . '/app/config.php';
    }

    return dot($config, $sta, $default);
}