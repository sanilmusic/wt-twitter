<?php

namespace Framework\Storage;

abstract class Model
{
     /**
     * Jedinstveni ID trenutnog entiteta.
     * 
     * @var int
     */
    protected $id;

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
        if ($ime == 'id') {
            return $this->id;
        } elseif (!array_key_exists($ime, $this->atributi)) {
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
        return array_merge([
            'id' => $this->id,
        ], $this->atributi);
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
     * Vraća novu Query instancu preko koje se mogu ispitivati uslovi.
     * 
     * @return \Framework\Storage\Query
     */
    public static function query()
    {
        return new Query(static::sve());
    }

    /**
     * Vraća niz svih spremljenih stavki.
     * 
     * @return array
     */
    public static abstract function sve();

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