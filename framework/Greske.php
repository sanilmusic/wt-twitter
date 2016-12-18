<?php

namespace Framework;

class Greske
{
    /**
     * Niz svih grešaka, raspoređenih po poljima.
     * 
     * @var array
     */
    private $sve = [];

    /**
     * Kreiraj novu instancu Greske klase.
     * 
     * @param array $sve
     */
    public function __construct(array $sve = [])
    {
        $this->sve = $sve;
    }

    /**
     * Spasi niz grešaka unutar klase.
     * 
     * @param  array $sve
     * @return void
     */
    public function postaviGreske(array $sve)
    {
        $this->sve = $sve;
    }

    /**
     * Provjeri da li je uočena greška vezana za neko polje.
     * 
     * @param  string $sta
     * @return bool
     */
    public function ima($sta)
    {
        return array_key_exists($sta, $this->sve);
    }

    /**
     * Daj grešku vezanu za neko polje.
     * 
     * @param  string $sta
     * @param  mixed $default
     * @return mixed
     */
    public function daj($sta, $default = null)
    {
        if ($this->ima($sta)) {
            return $this->sve[$sta];
        }

        return $default;
    }
}