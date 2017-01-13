<?php

namespace Framework\Http;

use Framework\Exceptions\InvalidRouteException;

class Router
{
    /**
     * Veza između ruta, vrste HTTP zahtjeva i akcije koju treba obaviti.
     * 
     * @var array
     */
    private $rute = [];

    /**
     * Registruj novu rutu ili izmjeni postojeću.
     * 
     * @param  string $ruta
     * @param  string $akcija
     * @param  string $vrsta
     * @return void
     */
    private function registruj($ruta, $akcija, $vrsta = 'GET')
    {
        if (array_key_exists($ruta, $this->rute)) {
            $this->rute[$ruta][$vrsta] = $akcija;
        } else {
            $this->rute[$ruta] = [
                $vrsta => $akcija
            ];
        }
    }

    /**
     * Kreira instancu kontrolera koji je zadužen za odgovor na zahtjev.
     * 
     * @param  string $kontroler
     * @return \Framework\Http\Controller
     */
    private function kreirajKontroler($kontroler)
    {
        $klasa = '\App\Controllers\\' . $kontroler;

        if (!class_exists($klasa)) {
            throw new InvalidRouteException('Kontroler nije pronađen.');
        }

        return new $klasa;
    }

    /**
     * Parsira definisanu akciju na primljenu rutu i pokreće odgovarajuću
     * akciju.
     * 
     * @param  string $akcija
     * @return void
     */
    private function odgovori($akcija)
    {
        if (!strpos($akcija, '@')) {
            throw new InvalidRouteException('Akcija nije u očekivanom formatu.');
        }

        list($kontroler, $metod) = explode('@', $akcija);

        $instancaKontrolera = $this->kreirajKontroler($kontroler);

        if (!method_exists($instancaKontrolera, $metod)) {
            throw new InvalidRouteException('Definisani metod nije pronađen u kontroleru.');
        }

        call_user_func([$instancaKontrolera, $metod]);
    }

    /**
     * Mapira GET zahtjev na određenu akciju.
     * 
     * @param  string $ruta
     * @param  string $akcija
     * @return void
     */
    public function get($ruta, $akcija)
    {
        $this->registruj($ruta, $akcija, 'GET');
    }

    /**
     * Mapira POST zahtjev na određenu akciju.
     * 
     * @param  string $ruta
     * @param  string $akcija
     * @return void
     */
    public function post($ruta, $akcija)
    {
        $this->registruj($ruta, $akcija, 'POST');
    }

    /**
     * Određuje rutu na osnovu URL-u i poziva definisanu akciju.
     * 
     * @return void
     */
    public function rutiraj()
    {
        $vrsta = $_SERVER['REQUEST_METHOD'];
        $sta = array_key_exists('sta', $_GET) ? $_GET['sta'] : '/';

        if (!array_key_exists($sta, $this->rute)) {
            throw new InvalidRouteException('Ruta nije registrovana.');
        } elseif (!array_key_exists($vrsta, $this->rute[$sta])) {
            throw new InvalidRouteException('Vrsta HTTP zahtjeva nije definisana za rutu.');
        }

        $this->odgovori($this->rute[$sta][$vrsta]);
    }
}