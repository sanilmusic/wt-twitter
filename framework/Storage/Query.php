<?php

namespace Framework\Storage;

abstract class Query {
    /**
     * Niz uslova koje rezultat treba zadovoljavati.
     * 
     * @var array
     */
    protected $uslovi = [];

    /**
     * Operator koji se primjenjuje na sve uslove.
     * 
     * @var string
     */
    protected $operator = 'I';

    /**
     * Postavlja vrijednost operatora.
     * 
     * @param  string $operator
     * @return \Framework\Storage\Query
     */
    public function operator($operator)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * Dodaje novi uslov u niz uslova.
     * 
     * @param  string $polje
     * @param  string $operator
     * @param  string $vrijednost
     * @return \Framework\Storage\Query
     */
    protected function dodajUslov($polje, $operator, $vrijednost)
    {
        $this->uslovi[] = [$polje, $operator, $vrijednost];

        return $this;
    }

    /**
     * Dodaje novi uslov kod kojeg polje mora imati određenu vrijednost.
     *
     * @param  string $tip
     * @param  string $vrijednost
     * @return \Framework\Storage\Query
     */
    public function gdje($polje, $vrijednost)
    {
        return $this->dodajUslov($polje, '=', $vrijednost);
    }

    /**
     * Dodaje novi uslov kod kojeg polje mora sadržavati određenu vrijednost.
     * 
     * @param  string $polje
     * @param  string $vrijednost
     * @return \Framework\Storage\Query
     */
    public function gdjeSadrzi($polje, $vrijednost)
    {
        return $this->dodajUslov($polje, '%', $vrijednost);
    }

    /**
     * Vraća niz modela koji zadovoljavaju zadane uslove.
     * 
     * @return array
     */
    abstract public function sve();

    /**
     * Vraća prvi model koji ispunjava sve uslove.
     * 
     * @return \Framework\Storage\Model
     */
    abstract public function prvi();

    /**
     * Vraća broj modela koji zadovoljavaju uslove.
     * 
     * @return int
     */
    abstract public function broj();
}