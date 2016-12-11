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