<?php

namespace Framework;

class Validator
{
    /**
     * Niz grešaka koje su povezane sa pravilima.
     * 
     * @var array
     */
    private $poruke = [
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

            foreach ($nizPravila as $pravilo) {
                if (!$this->validirajPolje($polje, $pravilo)) {
                    $valid = false;
                    $this->greske[$polje] = $this->poruke[$pravilo];
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
     * Validiraj jedno polje po osnovu jednog pravila.
     * 
     * @param  string $polje
     * @param  string $pravilo
     * @return bool
     */
    private function validirajPolje($polje, $pravilo)
    {
        switch ($pravilo) {
            case 'potrebno':
                return $this->validirajPotrebno($polje);
                break;

            case 'email':
                return $this->validirajEmail($polje);
                break;
        }
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