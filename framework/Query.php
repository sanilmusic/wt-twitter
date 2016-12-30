<?php

namespace Framework;

use SimpleXML;
use Framework\Model;

class Query
{
    /**
     * Niz svih modela koji se testiraju.
     * 
     * @var array
     */
    protected $svi = [];

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
     * Kreira novu instancu Query klase.
     * 
     * @param array $svi
     */
    public function __construct(array $svi)
    {
        $this->svi = $svi;
    }

    /**
     * Postavlja vrijednost operatora.
     * 
     * @param  string $operator
     * @return \Framework\Query
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
     * @return \Framework\Query
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
     * @return \Framework\Query
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
     * @return \Framework\Query
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
    public function sve()
    {
        if (count($this->uslovi) == 0) {
            return $this->svi;
        }

        $filtrirani = [];
        foreach ($this->svi as $model) {
            if ($this->ispunjavaUslove($model)) {
                $filtrirani[] = $model;
            }
        }

        return $filtrirani;
    }

    /**
     * Vraća prvi model koji ispunjava sve uslove.
     * 
     * @return \Framework\Model
     */
    public function prvi()
    {
        $filtrirani = $this->sve();

        if (count($filtrirani) == 0) {
            return null;
        }

        return $filtrirani[0];
    }

    /**
     * Vraća broj modela koji zadovoljavaju uslove.
     * 
     * @return int
     */
    public function broj()
    {
        return count($this->sve());
    }

    /**
     * Provjerava da li model ispunjava zadane uslove.
     * 
     * @param  \Framework\Model $model
     * @return bool
     */
    protected function ispunjavaUslove(Model $model)
    {
        $ispunjava = ($this->operator == 'I' ? true : false);

        foreach ($this->uslovi as $uslov) {
            if ($this->operator == 'I' && !$this->provjeriUslov($model, $uslov)) {
                $ispunjava = false;
                break;
            } elseif ($this->operator == 'ILI' && $this->provjeriUslov($model, $uslov)) {
                $ispunjava = true;
                break;
            }
        }

        return $ispunjava;
    }

    /**
     * Provjeri da li model ispunjava jedan uslov.
     * 
     * @param  \Framework\Model $model
     * @param  array $uslov
     * @return boool
     */
    protected function provjeriUslov(Model $model, array $uslov)
    {
        if ($uslov[1] == '=' && $model->{$uslov[0]} == $uslov[2]) {
            return true;
        } elseif ($uslov[1] == '%' && strpos($model->{$uslov[0]}, $uslov[2]) !== false) {
            return true;
        }

        return false;
    }
}