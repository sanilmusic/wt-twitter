<?php

namespace App\Controllers;

use App\Models\Korisnik;
use Framework\Kontroler;
use Framework\Validator;

class AuthKontroler extends Kontroler
{
    public function __construct()
    {
        // Isključivo gosti mogu pristupiti metodama ovog kontrolera
        if (korisnik()) {
            $this->redirect('/');
        }
    }

    public function prijavaForma()
    {
        $this->view('prijava');
    }

    public function prijava()
    {
        $input = $this->post(['email', 'lozinka']);

        // Validiraj ulaz
        $validator = new Validator($input, [
            'email' => 'potrebno|email',
            'lozinka' => 'potrebno'
        ]);

        if (!$validator->validiraj()) {
            $this->redirect('prijava', $validator);
        }

        // Provjeri da li korisnik postoji
        $korisnik = Korisnik::dajPrvog([
            'email' => $input['email']
        ]);

        if (!$korisnik) {
            $validator->registrujGresku('email', 'Korisnik nije pronađen.');
            $this->redirect('prijava', $validator);
        }

        // Provjeri da li je lozinka ispravna
        if (!password_verify($input['lozinka'], $korisnik->lozinka)) {
            $validator->registrujGresku('lozinka', 'Pogrešna lozinka za navedenog korisnika.');
            $this->redirect('prijava', $validator);
        }

        $_SESSION['userId'] = $korisnik->id;
        $this->redirect('/');
    }

    public function odjava()
    {
        unset($_SESSION['userId']);
        $this->redirect('/');
    }

    public function registracija()
    {
        $input = $this->post(['ime', 'prezime', 'email', 'lozinka', 'potvrda_lozinke']);

        $validator = new Validator($input, [
            'ime' => 'potrebno',
            'prezime' => 'potrebno',
            'email' => 'potrebno|email|jedinstveno:Korisnik',
            'lozinka' => 'potrebno|min:6|potvrdjeno:potvrda_lozinke',
        ]);

        if (!$validator->validiraj()) {
            $this->redirect('/', $validator);
        }

        unset($input['potvrda_lozinke']);

        // Napravi hash password-a prije spremanja u bazu
        $input['lozinka'] = password_hash($input['lozinka'], PASSWORD_DEFAULT);

        // Kreiraj novog korisnika
        $korisnik = new Korisnik($input);
        $korisnik->sacuvaj();

        // Prijavi korisnika nakon registracije
        $_SESSION['userId'] = $korisnik->id;
        $this->redirect('/');
    }
}