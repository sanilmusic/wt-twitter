<?php

namespace Framework;

use SimpleXMLElement;

abstract class Model
{
    /**
     * Naziv datoteke u kojoj se nalazi podaci.
     * 
     * @var string
     */
    protected static $datoteka;

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
        if (!array_key_exists($ime, $this->atributi)) {
            return null;
        }

        return $this->atributi[$ime];
    }

    /**
     * Vraća SimpleXML objekat za interakciju sa XML datotekom. Datoteka se učitava
     * i parsira ukoliko to ranije nije obavljeno.
     * 
     * @return \SimpleXML
     */
    protected static function dajXml()
    {
        static $xml;

        if (!$xml) {
            $xml = simplexml_load_file(static::dajPutDatoteke());
        }

        return $xml;
    }

    /**
     * Vraća niz svih spremljenih stavki.
     * 
     * @return array
     */
    public static function sve()
    {
        $xml = static::dajXml();

        $stavke = [];
        foreach ($xml->sadrzaj->children() as $cvor) {
            $stavke[] = static::kreirajIzCvora($cvor);
        }

        return $stavke;
    }

    /**
     * Vraća model kod kojeg definisani atribut ima definisanu vrijednost.
     * 
     * @param  string $atribut
     * @param  string $ocekivano
     * @return array
     */
    public static function trazi($atribut, $ocekivano)
    {
        $rezultati = [];

        $cvorovi = static::traziCvorove($atribut, $ocekivano);
        foreach ($cvorovi as $cvor) {
            $rezultati[] = static::kreirajIzCvora($cvor);
        }

        return $rezultati;
    }

    /**
     * Kreira novi model na osnovu čvora koji je već spremeljen u bazu.
     * 
     * @param  \SimpleXMLElement $cvor
     * @return \Framework\Model
     */
    protected static function kreirajIzCvora(SimpleXMLElement $cvor)
    {
        $atributi = [];
        foreach ($cvor->children() as $child) {
            if (($ime = $child->getName()) != 'id') {
                $atributi[$ime] = (string) $child;
            }
        }

        $model = new static($atributi);
        $model->id = (int) $cvor->id;

        return $model;
    }

    /**
     * Traži čvor u XML dokumentu kod kojeg definisani ključ sadrži
     * definisanu vrijednost.
     * 
     * @param  string $atribut
     * @param  string $ocekivano
     * @return array
     */
    protected function traziCvorove($atribut, $ocekivano)
    {
        $xml = static::dajXml();

        $rezultati = [];
        foreach ($xml->sadrzaj->children() as $child) {
            $vrijednost = (string) $child->$atribut;

            if ($vrijednost == $ocekivano) {
                $rezultati[] = $child;
            }
        }

        return $rezultati;
    }

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
     * Sačuvaj trenutni model.
     * 
     * @return void
     */
    public function sacuvaj()
    {
        $xml = static::dajXml();

        if ($this->id) {
            $cvor = static::traziCvorove('id', $this->id)[0];

            foreach ($this->atributi as $atribut => $vrijednost) {
                $cvor->$atribut = $vrijednost;
            }
        } else {
            $this->id = $this->dajSljedeciId();

            $cvor = $xml->sadrzaj->addChild('stavka');
            $cvor->addChild('id', $this->id);

            foreach ($this->atributi as $atribut => $vrijednost) {
                $cvor->addChild($atribut, $vrijednost);
            }
        }

        $this->azurirajDatoteku();
    }

    /**
     * Generiše apsolutni put to datoteke u kojoj su podaci.
     * 
     * @return string
     */
    protected static function dajPutDatoteke()
    {
        return PATH . '/storage/' . static::$datoteka . '.xml';
    }

    /**
     * Spašava izmjene u XML datoteku.
     * 
     * @return void
     */
    protected function azurirajDatoteku()
    {
        file_put_contents(static::dajPutDatoteke(), static::dajXml()->asXML());
    }

    /**
     * Provjerava metapodatke smještene u XML datoteci i na osnovu njih određuje
     * idući jedinstveni ID broj.
     * 
     * @return int
     */
    protected function dajSljedeciId()
    {
        $xml = static::dajXml();

        $id = $xml->meta->id++;

        $this->azurirajDatoteku();

        return $id;
    }
}