<?php

namespace Framework;

use Framework\Unosi;
use Framework\Greske;
use Framework\Validator;

abstract class Kontroler
{
    public function __construct()
    {
        // Zapamti ranije unesene vrijednosti
        $_SESSION['noveJednokratne']['fData'] = $_POST;
    }

    protected function view($ime, $data = [])
    {
        // Gdje se nalazi view?
        $lok = $this->dajImeKontrolera() . '/' . $ime;

        // Automatski uključi klasu za manipulaciju greškama
        $data['fGreske'] = new Greske(array_key_exists('fGreske', $_SESSION) ? $_SESSION['fGreske'] : []);

        // Automatski uključi ranije unesene vrijednosti u formu
        $data['fData'] = new Unosi(array_key_exists('fData', $_SESSION) ? $_SESSION['fData'] : []);

        view($lok, $data);
    }

    /**
     * Izdvaja ključeve iz niza ili ih zamijeni sa NULL ukoliko ne postoje u nizu.
     * 
     * @param  array $odakle
     * @param  array|string $sta
     * @param  mixed $default
     * @return array
     */
    protected function izdvoji(array $odakle, $sta, $default = null)
    {
        if (!is_array($sta)) {
            return (array_key_exists($sta, $odakle) ? $odakle[$sta] : $default);
        }

        $rez = [];
        foreach ($sta as $kljuc) {
            $rez[$kljuc] = (array_key_exists($kljuc, $odakle) ? $odakle[$kljuc] : $default);
        }

        return $rez;
    }

    /**
     * Vraća definisane informacije poslate GET metodom.
     * 
     * @param  array|string $keys
     * @param  mixed $default
     * @return array
     */
    protected function get($keys, $default = null)
    {
        return $this->izdvoji($_GET, $keys, $default);
    }

    /**
     * Vraća definisane informacije poslate POST metodom.
     *
     * @param  array|string $keys
     * @param  mixed $default
     * @return array
     */
    protected function post($keys, $default = null)
    {
        return $this->izdvoji($_POST, $keys, $default);
    }

    /**
     * Vraća definisane informacije iz sesije.
     * 
     * @param  array|string $keys
     * @param  mixed $default
     * @return array
     */
    protected function sesija($keys, $default = null)
    {
        return $this->izdvoji($_SESSION, $keys, $default);
    }

    /**
     * Preusmjeri korisnika na neku drugu rutu.
     * 
     * @param  string $ruta
     * @param  mixed $dodatno
     * @return void
     */
    protected function redirect($ruta, $dodatno = null)
    {
        if ($dodatno instanceof Validator) {
            $_SESSION['noveJednokratne']['fGreske'] = $dodatno->dajGreske();
        }

        if ($ruta == '/') {
            header('Location: index.php');
        } else {
            header('Location: index.php?sta=' . $ruta);
        }

        die;
    }

    /**
     * Parsira ime klase i izdvaja ime kontrolera.
     * 
     * @return string
     */
    private function dajImeKontrolera()
    {
        $segmenti = explode('\\', get_class($this));
        $kontroler = end($segmenti);

        if (substr($kontroler, -9) == 'Kontroler') {
            return substr($kontroler, 0, -9);
        }

        return $kontroler;
    }
}