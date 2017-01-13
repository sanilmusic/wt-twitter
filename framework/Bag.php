<?php

namespace Framework;

class Bag
{
    /**
     * Spremljeni sadržaj.
     * 
     * @var array
     */
    private $sadrzaj = [];

    /**
     * Kreira novu instancu Bag klase.
     * 
     * @param array $sadrzaj
     */
    public function __construct(array $sadrzaj)
    {
        $this->sadrzaj = $sadrzaj;
    }

    /**
     * Provjerava da li podatak postoji u sadržaju.
     * 
     * @param  string $sta
     * @return bool
     */
    public function ima($sta)
    {
        return array_key_exists($sta, $this->sadrzaj);
    }

    /**
     * Dobavlja spremljenu vrijednost ili vraća $default ukoliko vrijednost ne postoji.
     * 
     * @param  string $sta
     * @param  mixed $default
     * @return mixed
     */
    public function daj($sta, $default = null)
    {
        return ($this->ima($sta) ? $this->sadrzaj[$sta] : $default);
    }
}