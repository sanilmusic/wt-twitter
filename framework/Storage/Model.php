<?php

namespace Framework\Storage;

abstract class Model
{
    /**
     * Atributi koji opisuju trenutni entitet.
     * 
     * @var array
     */
    protected $atributi = [];

    /**
     * Kreiraj novi model entiteta.
     * 
     * @param array $atributi
     */
    public function __construct($atributi = [])
    {
        $this->atributi = $atributi;
    }

    /**
     * Obezbijeđuje mehanizam za direktnu promjenu atributa.
     * 
     * @param string $ime
     * @param string $vrijednost
     */
    public function __set($ime, $vrijednost)
    {
        $this->atributi[$ime] = $vrijednost;
    }

    /**
     * Obezbijeđuje direktan pristup vrijednostima atributa.
     * 
     * @param  string $ime
     * @return mix
     */
    public function __get($ime)
    {
        if (!array_key_exists($ime, $this->atributi)) {
            return null;
        }

        return $this->atributi[$ime];
    }

    /**
     * Vraća niz svih atributa postavljenih nad modelom.
     * 
     * @return array
     */
    public function atributi()
    {
        return $this->atributi;
    }

    /**
     * Ažuriraj atribute na osnovu niza.
     * 
     * @param  array $atributi
     * @return void
     */
    public function azurirajAtribute(array $atributi)
    {
        $this->atributi = array_merge($this->atributi, $atributi);
    }

    /**
     * Sačuvaj trenutni model.
     * 
     * @return void
     */
    public abstract function sacuvaj();

    /**
     * Briše trenutni model iz baze.
     * 
     * @return void
     */
    public abstract function obrisi();
}