<?php

namespace Framework\Storage\Database;

use PDO;
use Framework\Storage\Query as BaseQuery;

class Query extends BaseQuery {
    /**
     * Model nad kojim se formira upit.
     * 
     * @var string
     */
    protected $model;

    /**
     * PDO veza preko koje se pristupa bazi.
     * 
     * @var \PDO
     */
    protected $veza;

    /**
     * Kreira novu instancu Query klase.
     * 
     * @param string $model
     */
    public function __construct($model)
    {
        $this->model = $model;
        $this->veza = Connection::veza();
    }

    /**
     * Vraća niz modela koji zadovoljavaju zadane uslove.
     * 
     * @return array
     */
    public function sve() {
        $stmt = $this->formirajStmt('*');

        return $this->kreirajIzNiza($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * Vraća prvi model koji ispunjava sve uslove.
     * 
     * @return \Framework\Storage\Model
     */
    public function prvi() {
        $stmt = $this->formirajStmt('*', 1);

        if ($stmt->rowCount() == 0) {
            return null;
        }

        return $this->kreirajIzNiza($stmt->fetchAll(PDO::FETCH_ASSOC))[0];
    }

    /**
     * Vraća broj modela koji zadovoljavaju uslove.
     * 
     * @return int
     */
    public function broj() {
        $stmt = $this->formirajStmt('COUNT(*)');

        return $stmt->fetchColumn(0);
    }

    /**
     * Formira ispravan upit za dobavljanje podataka iz baze.
     * 
     * @param  string $sta
     * @param  int $limit
     * @return \PDOStatement
     */
    protected function formirajStmt($sta, $limit = 0)
    {
        $query = 'SELECT ' . $sta . ' FROM ' . $this->model::$tabela;

        $values = [];
        for ($i = 0; $i < count($this->uslovi); $i++) {
            if ($i > 0) {
                $query .= ($this->operator == 'I' ? ' AND' : ' OR');
            } else {
                $query .= ' WHERE';
            }

            $query .= ' ' . $this->uslovi[$i][0];

            if ($this->uslovi[$i][1] == '=') {
                $query .= ' = ?';
                $values[$i] = $this->uslovi[$i][2];
            } else {
                $query .= ' LIKE ?';
                $values[$i] = '%' . $this->uslovi[$i][2] . '%';
            }
        }

        if ($limit > 0) {
            $query .= ' LIMIT ' . $limit;
        }

        $stmt = $this->veza->prepare($query);
        $stmt->execute($values);

        return $stmt;
    }

    /**
     * Kreira niz modela iz dvodimenzionalnog niza redova.
     * 
     * @param  array $niz
     * @return array
     */
    protected function kreirajIzNiza(array $niz)
    {
        $rezultat = [];
        foreach ($niz as $red) {
            $id = $red['id'];
            unset($red['id']);

            $model = new $this->model($red);
            $model->id = $id;

            $rezultat[] = $model;
        }

        return $rezultat;
    }
}