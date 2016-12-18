<?php

namespace Framework;

abstract class Kontroler
{
    protected function view($ime, $data = [])
    {
        // Gdje se nalazi view?
        $lok = $this->dajImeKontrolera() . '/' . $ime;

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
     * @return void
     */
    protected function redirect($ruta)
    {
        if ($ruta == '/') {
            header('Location: index.php');
        } else {
            header('Location: index.php?sta=' . $ruta);
        }
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