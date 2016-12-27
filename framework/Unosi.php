<?php

namespace Framework;

class Unosi
{
    /**
     * Lista ranijih unosa u formu.
     * 
     * @var array
     */
    private $unosi = [];

    /**
     * Kreiraj novu instancu Unosi klase.
     * @param array $sve
     */
    public function __construct(array $sve = [])
    {
        $this->unosi = $sve;
    }

    /**
     * Provjeri da li neki ključ postoji u ranijim unosima.
     * 
     * @param  string $kljuc
     * @return bool
     */
    public function ima($kljuc)
    {
        return array_key_exists($kljuc, $this->unosi);
    }

    /**
     * Vrati vrijednost iz liste ranijih unosa.
     * 
     * @param  string $kljuc
     * @param  mixed $default
     * @return mixed
     */
    public function daj($kljuc, $default = null)
    {
        return (array_key_exists($kljuc, $this->unosi) ? $this->unosi[$kljuc] : $default);
    }
}