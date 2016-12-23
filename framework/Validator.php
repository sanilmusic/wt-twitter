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
        'email' => 'Unos nije ispravna email adresa.'
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
        switch ($kljuc) {
            case 'potrebno':
                return $this->validirajPotrebno($polje);
                break;

            case 'email':
                return $this->validirajEmail($polje);
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
            $smjene['atribut-' . $i] = $atributi[$i];
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
     * @param  string $polje
     * @return bool
     */
    private function validirajPotrebno($polje)
    {
        $unos = $this->input($polje);

        return (($unos !== null) && ($unos !== ''));
    }

    /**
     * Potvrdi da unos ispravna email adresa.
     * 
     * @param  string $polje
     * @return bool
     */
    private function validirajEmail($polje)
    {
        return filter_var($this->input($polje), FILTER_VALIDATE_EMAIL);
    }
}