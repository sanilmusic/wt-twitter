<?php

namespace Framework\Storage\Database;

use PDO;

class Connection
{
    /**
     * Vraća PDO preko kojeg se pristupa bazi.
     * @return \PDO
     */
    public static function veza()
    {
        static $veza = null;

        if ($veza === null) {
            $database = config('database');

            $dsn = 'mysql:dbname=' . $database['database'] . ';host=' . $database['host'] . ';charset=' . $database['charset'];

            $veza = new PDO($dsn, $database['username'], $database['password']);

            $veza->exec('SET NAMES ' . $database['charset']);
        }

        return $veza;
    }
}