<?php

namespace Framework\Storage\Xml;

use SimpleXML;
use Framework\Storage\Xml\Model;
use Framework\Storage\Query as BaseQuery;

class Query extends BaseQuery
{
    /**
     * Niz svih modela koji se testiraju.
     * 
     * @var array
     */
    protected $svi = [];

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
     * @return \Framework\Storage\Model
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
     * @param  \Framework\Storage\Xml\Model $model
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
     * @param  \Framework\Storage\Xml\Model $model
     * @param  array $uslov
     * @return bool
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