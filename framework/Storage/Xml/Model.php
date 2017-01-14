<?php

namespace Framework\Storage\Xml;

use Framework\Storage\Model as BaseModel;
use Framework\Storage\Xml\Query;
use SimpleXMLElement;

abstract class Model extends BaseModel
{
    /**
     * Naziv datoteke u kojoj se nalazi podaci.
     * 
     * @var string
     */
    protected static $datoteka;

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
     * Vraća novu Query instancu preko koje se mogu ispitivati uslovi.
     * 
     * @return \Framework\Storage\Query
     */
    public static function query() {
        return new Query(static::sve());
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
     * Kreira novi model na osnovu čvora koji je već spremeljen u bazu.
     * 
     * @param  \SimpleXMLElement $cvor
     * @return \Framework\Storage\Xml\Model
     */
    protected static function kreirajIzCvora(SimpleXMLElement $cvor)
    {
        $atributi = [];
        foreach ($cvor->children() as $child) {
            $atributi[$child->getName()] = (string) $child;
        }

        $model = new static($atributi);

        return $model;
    }

    /**
     * Traži čvorove u XML dokumentu koji zadovoljavaju definisane uslove.
     * 
     * @param  array $uslovi
     * @return array
     */
    protected static function traziCvorove($uslovi)
    {
        $xml = static::dajXml();

        $rezultati = [];
        foreach ($xml->sadrzaj->children() as $child) {
            $podudara = true;

            foreach ($uslovi as $atribut => $ocekivano) {
                if ($child->$atribut != $ocekivano) {
                    $podudara = false;
                }
            }

            if ($podudara) {
                $rezultati[] = $child;
            }
        }

        return $rezultati;
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
            $cvor = static::traziCvorove([
                'id' => $this->id
            ])[0];

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
     * Briše trenutni model iz baze.
     * 
     * @return void
     */
    public function obrisi()
    {
        if (!$this->id) {
            return;
        }

        $children = static::dajXml()->sadrzaj->children();
        for ($i = 0; $i < count($children); $i++) {
            if ($children[$i]->id == $this->id) {
                unset($children[$i]);
                break;
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