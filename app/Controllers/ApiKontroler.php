<?php

namespace App\Controllers;

use App\Models\Korisnik;
use Framework\Http\Controller;

class ApiKontroler extends Controller
{
    public function __construct()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
    }

    public function korisnici()
    {
        $id = $this->get('id');

        if ($id === null) {
            echo json_encode([
                'korisnici' => $this->formatiraj(Korisnik::sve())
            ]);
        } else {
            $korisnik = Korisnik::query()->gdje('id', $id)->prvi();

            if ($korisnik === null) {
                header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
                echo json_encode([]);
            } else {
                echo json_encode([
                    'korisnik' => $this->formatiraj([$korisnik])[0]
                ]);
            }
        }
    }

    /**
     * Izdvaja iz modela polja za prikaz na web servisu.
     * 
     * @param  array $modeli
     * @return string
     */
    protected function formatiraj(array $modeli)
    {
        $podaci = [];
        foreach ($modeli as $model) {
            $atributi = $model->atributi();

            // Uklonimo elemente koje ne želimo prikazati
            unset($atributi['lozinka']);
            unset($atributi['admin']);

            $podaci[] = $atributi;
        }

        return $podaci;
    }
}