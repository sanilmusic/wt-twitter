<?php

namespace Framework;

class Validator
{
    /**
     * Niz šablona na osnovu kojih se generišu greške.
     * 
     * @var array
     */
    private $sabloni = [
        'potrebno' => 'Polje ne smije biti izostavljeno.',
        'email' => 'Unos nije ispravna email adresa.',
        'min' => 'Unos mora biti dug barem :atribut-0 znakova.',
        'jedinstveno' => 'Unos već postoji.',
        'potvrdjeno' => 'Unesena vrijednost se ne poklapa sa potvrdom.',
        'postoji' => 'Odabrani unos ne postoji.'
    ];

    /**
     * Ulaz koji se validira.
     * 
     * @var array
     */
    private $input;

    /**
     * Pravila po kojima se ulaz validira.
     * 
     * @var array
     */
    private $pravila;

    /**
     * Niz grešaka koje su uočene tokom validacije.
     * 
     * @var array
     */
    private $greske = [];

    /**
     * Kreira novu instancu Validator klase.
     * 
     * @param array $input
     * @param array $pravila
     */
    public function __construct(array $input, array $pravila)
    {
        $this->input = $input;
        $this->pravila = $pravila;
    }

    /**
     * Validiraj ulaz na osnovu definisanih pravila.
     * 
     * @return bool
     */
    public function validiraj()
    {
        $valid = true;

        foreach ($this->pravila as $polje => $pravila) {
            $nizPravila = explode('|', $pravila);

            foreach ($nizPravila as $strPravila) {
                list($kljuc, $atributi) = $this->rasclani($strPravila);

                if (!$this->validirajPolje($polje, $kljuc, $atributi)) {
                    $valid = false;
                    $this->greske[$polje] = $this->sastaviGresku($kljuc, $atributi);
                    break;
                }
            }
        }

        return $valid;
    }

    /**
     * Vraća niz sa greškama.
     * 
     * @return array
     */
    public function dajGreske()
    {
        return $this->greske;
    }

    /**
     * Omogućava i ručnu registraciju grešaka.
     * 
     * @param  string $polje
     * @param  string $tekst
     * @return void
     */
    public function registrujGresku($polje, $tekst)
    {
        $this->greske[$polje] = $tekst;
    }

    /**
     * Raščlanjuje pravilo na ključ i proslijeđene atribute.
     * 
     * @param  string $strPravila
     * @return array
     */
    private function rasclani($strPravila)
    {
        $dijelovi = explode(':', $strPravila);

        // Izdvoji ključ i ostavi atribute u istom nizu
        $kljuc = array_shift($dijelovi);

        return [$kljuc, $dijelovi];
    }

    /**
     * Validiraj jedno polje po osnovu jednog pravila.
     * 
     * @param  string $polje
     * @param  string $kljuc
     * @param  array $atributi
     * @return bool
     */
    private function validirajPolje($polje, $kljuc, array $atributi)
    {
        $unos = $this->input($polje);

        switch ($kljuc) {
            case 'potrebno':
                return $this->validirajPotrebno($unos);
                break;

            case 'email':
                return $this->validirajEmail($unos);
                break;

            case 'min':
                return $this->validirajMin($unos, $atributi[0]);
                break;

            case 'jedinstveno':
                return $this->validirajJedinstveno($polje, $unos, $atributi);
                break;

            case 'potvrdjeno':
                return $this->validirajPotvrdjeno($unos, $atributi[0]);
                break;

            case 'postoji':
                return $this->validirajPostoji($unos, $atributi[0]);
                break;
        }
    }

    /**
     * Sastavlja grešku na osnovu ključa i atributa pravila.
     * 
     * @param  string $kljuc
     * @param  array $atributi
     * @return string
     */
    private function sastaviGresku($kljuc, array $atributi)
    {
        $smjene = [];

        for ($i = 0; $i < count($atributi); $i++) {
            $smjene[':atribut-' . $i] = $atributi[$i];
        }

        return strtr($this->sabloni[$kljuc], $smjene);
    }

    /**
     * Vraća vrijednost polja na ulazu.
     * 
     * @param  string $polje
     * @return string
     */
    private function input($polje)
    {
        return (array_key_exists($polje, $this->input) ? $this->input[$polje] : null);
    }

    /**
     * Potvrdi da je polje proslijeđeno na ulaz.
     * 
     * @param  string $unos
     * @return bool
     */
    private function validirajPotrebno($unos)
    {
        return (($unos !== null) && ($unos !== ''));
    }

    /**
     * Potvrdi da unos ispravna email adresa.
     * 
     * @param  string $unos
     * @return bool
     */
    private function validirajEmail($unos)
    {
        return filter_var($unos, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Potvrdi da je unos duži od minimalne dužine.
     * 
     * @param  string $unos
     * @param  int $min
     * @return bool
     */
    private function validirajMin($unos, $min)
    {
        return (strlen($unos) >= $min);
    }

    /**
     * Potvrdi da je unos jedinstven u bazi.
     *
     * @param  string $polje
     * @param  string $unos
     * @param  array $model
     * @return bool
     */
    private function validirajJedinstveno($polje, $unos, array $atributi)
    {
        $modeli = $this->traziModele($atributi[0], $polje, $unos);
        
        if (isset($atributi[1])) {
            foreach ($modeli as $model) {
                if ($model->id != $atributi[1]) {
                    return false;
                }
            }
            return true;
        }

        return (count($modeli) == 0);
    }

    /**
     * Potvrdi da je unos ispravno potvrđen.
     * 
     * @param  string $unos
     * @param  string $poljePotvrde
     * @return bool
     */
    private function validirajPotvrdjeno($unos, $poljePotvrde)
    {
        return ($unos == $this->input($poljePotvrde));
    }

    /**
     * Validiraj da model sa odgovarajućim ID-om postoji.
     * 
     * @param  string $unos
     * @param  string $model
     * @return bool
     */
    private function validirajPostoji($unos, $model)
    {
        $modeli = $this->traziModele($model, 'id', $unos);

        return (count($modeli) == 1);
    }

    /**
     * Vraća sve modele nekog tipa kod kojeg neko polje ima neku vrijednost.
     * 
     * @param  string $model
     * @param  string $polje
     * @param  string $vrijednost
     * @return \Framework\Model
     */
    private function traziModele($model, $polje, $vrijednost)
    {
        $klasa = '\\App\\Models\\' . $model;
        $uslovi = [
            $polje => $vrijednost
        ];

        return call_user_func_array([$klasa, 'trazi'], [$uslovi]);
    }
}