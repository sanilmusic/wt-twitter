<?php

namespace App\Controllers\Admin;

use Framework\Storage\Model;
use Framework\Http\Controller;
use App\Models\Poruka as PorukaDb;
use App\Models\Korisnik as KorisnikDb;
use App\Models\Xml\Poruka as PorukaXml;
use App\Models\Xml\Korisnik as KorisnikXml;

class TransferKontroler extends Controller
{
    public function transfer()
    {
        $this->transferKorisnika();
        $this->transferPoruka();

        echo 'Transfer uspješno izvršen.';
    }

    /**
     * Traži korisnike u XML-u koji ne postoje u bazi i dodaje ih u bazu.
     * 
     * @return void
     */
    protected function transferKorisnika()
    {
        $uBazi = KorisnikDb::sve();
        $uXml = KorisnikXml::sve();

        foreach ($uXml as $korisnikXml) {
            if (!$this->sadrzi($uBazi, $korisnikXml, 'email')) {
                $this->dodajKorisnika($korisnikXml);
            }
        }
    }

    /**
     * Traži poruke u XML-u koje ne postoje u bazi i dodaje ih u bazu.
     * 
     * @return void
     */
    protected function transferPoruka()
    {
        $uBazi = PorukaDb::sve();
        $uXml = PorukaXml::sve();

        foreach ($uXml as $porukaXml) {
            if (!$this->sadrzi($uBazi, $porukaXml, ['korisnik_id', 'tekst'])) {
                $this->dodajPoruku($porukaXml);
            }
        }
    }

    /**
     * Kreira novog korisnika na osnovu postojećeg korisinika.
     * 
     * @param  \App\Models\Xml\Korisnik $korisnik
     * @return void
     */
    protected function dodajKorisnika(KorisnikXml $korisnik)
    {
        $model = new KorisnikDb($this->odstraniId($korisnik->atributi()));
        $model->sacuvaj();
    }

    /**
     * Kreira novu poruku na osnovu postojeće poruke.
     * 
     * @param  \App\Models\Xml\Poruka $poruka
     * @return void
     */
    protected function dodajPoruku(PorukaXml $poruka)
    {
        $model = new PorukaDb($this->odstraniId($poruka->atributi()));

        // Pronađi korisnika sa odgovarajućom email adresom
        $korisnik = KorisnikDb::query()->gdje('email', $poruka->korisnik()->email)->prvi();

        $model->korisnik_id = $korisnik->id;

        $model->sacuvaj();
    }

    /**
     * Provjerava da li niz sadrži model sa istim vrijednostima kolona definisanim u atributu.
     * 
     * @param  array $niz
     * @param  \Framework\Storage\Model $model
     * @param  string|array $kolone
     * @return void
     */
    protected function sadrzi(array $niz, Model $model, $kolone)
    {
        foreach ($niz as $m) {
            if ($this->daLiSuIsti($m, $model, $kolone)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Provjerava da li se atributi u definisanim kolona kod dva modela slažu.
     * 
     * @param  \Framework\Storage\Model $m1
     * @param  \Framework\Storage\Model $m2
     * @param  string|array $kolone
     * @return bool
     */
    protected function daLiSuIsti(Model $m1, Model $m2, $kolone)
    {
        if (!is_array($kolone)) {
            $kolone = [$kolone];
        }

        foreach ($kolone as $kolona) {
            if ($m1->$kolona === $m2->$kolona) {
                continue;
            }

            return false;
        }

        return true;
    }

    /**
     * Odstranjuje kolonu sa ID-om ukoliko postoji u nizu atributa.
     * 
     * @param  array $atributi
     * @return array
     */
    protected function odstraniId(array $atributi)
    {
        if (array_key_exists('id', $atributi)) {
            unset($atributi['id']);
        }

        return $atributi;
    }
}