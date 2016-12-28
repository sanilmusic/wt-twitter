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
        if ($ime == 'id') {
            return $this->id;
        } elseif (!array_key_exists($ime, $this->atributi)) {
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
     * Vraća modele koji zadovoljavaju definisane uslove.
     * 
     * @param  array $uslovi
     * @return void
     */
    public static function trazi($uslovi)
    {
        $rezultati = [];

        $cvorovi = static::traziCvorove($uslovi);
        foreach ($cvorovi as $cvor) {
            $rezultati[] = static::kreirajIzCvora($cvor);
        }

        return $rezultati;
    }

    /**
     * Vraća model sa definisanim ID-om.
     * 
     * @param  int $id
     * @return \App\Model
     */
    public static function traziId($id)
    {
        $rezultati = static::trazi([
            'id' => $id
        ]);

        if (empty($rezultati)) {
            return null;
        }

        return $rezultati[0];
    }

    /**
     * Vraća prvog korisnika koji zadovoljava uslove.
     * 
     * @param  array $uslovi
     * @param  mixed $default
     * @return mixed
     */
    public static function dajPrvog($uslovi, $default = null)
    {
        $rezultati = static::trazi($uslovi);

        if (empty($rezultati)) {
            return $default;
        }

        return $rezultati[0];
    }

    /**
     * Vraća broj modela sačuvanih u bazi.
     * 
     * @return int
     */
    public static function broj()
    {
        return count(static::dajXml()->sadrzaj->children());
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
     * Traži čvorove u XML dokumentu koji zadovoljavaju definisane uslove.
     * 
     * @param  array $uslovi
     * @return array
     */
    protected function traziCvorove($uslovi)
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
     * Vraća niz svih atributa postavljenih nad modelom.
     * 
     * @return array
     */
    public function atributi()
    {
        return array_merge([
            'id' => $this->id,
        ], $this->atributi);
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
     * Popuni atribute na osnovu niza.
     * 
     * @param  array $atributi
     * @return void
     */
    public function popuni(array $atributi)
    {
        $this->atributi = array_merge($this->atributi, $atributi);
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