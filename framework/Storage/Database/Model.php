<?php

namespace Framework\Storage\Database;

use PDO;
use Framework\Storage\Model as BaseModel;
use Framework\Storage\Database\Connection;

class Model extends BaseModel
{
    /**
     * Naziv tabele u kojoj se nalaze podaci.
     * 
     * @var string
     */
    public static $tabela;

    /**
     * Vraća novu Query instancu preko koje se mogu ispitivati uslovi.
     * 
     * @return \Framework\Storage\Query
     */
    public static function query() {
        return new Query(static::class);
    }

    /**
     * Vraća niz svih spremljenih stavki.
     * 
     * @return array
     */
    public static function sve()
    {
        return static::query()->sve();
    }

    /**
     * Sačuvaj trenutni model.
     * 
     * @return void
     */
    public function sacuvaj()
    {
        $veza = Connection::veza();

        if ($this->id) {
            $this->azuriraj();
        } else {
            $this->kreiraj();
        }
    }

    /**
     * Ažurira red u bazi.
     * 
     * @return void
     */
    protected function azuriraj()
    {
        $queryStr = 'UPDATE ' . static::$tabela . ' SET ';

        $values = [];
        foreach ($this->atributi as $key => $value) {
            $queryStr .= $key . ' = ?, ';
            $values[] = $value;
        }

        $queryStr = substr($queryStr, 0, -2) . ' WHERE id = ' . $this->id;

        Connection::veza()->prepare($queryStr)->execute($values);
    }

    /**
     * Sprema model u bazu.
     * 
     * @return void
     */
    protected function kreiraj()
    {
        $keysStr = $valuesStr = '';
        $values = [];
        foreach ($this->atributi as $key => $value) {
            $keysStr .= $key . ', ';
            $valuesStr .= '?, ';
            $values[] = $value;
        }

        $queryStr = 'INSERT INTO ' . static::$tabela . ' (' . substr($keysStr, 0, -2) . ') VALUES (' . substr($valuesStr, 0, -2) . ')';

        $veza = Connection::veza();

        $veza->prepare($queryStr)->execute($values);

        $this->id = $veza->lastInsertId();
    }

    /**
     * Briše trenutni model iz baze.
     * 
     * @return void
     */
    public function obrisi()
    {
        if (!$this->id) {
            return;
        }

        Connection::veza()->exec('DELETE FROM ' . static::$tabela . ' WHERE id = ' . $this->id);
    }
}