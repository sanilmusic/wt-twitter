<?php

namespace App\Controllers;

use App\Models\Korisnik;
use Framework\Kontroler;
use Framework\Validator;

class AuthKontroler extends Kontroler
{
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
            'email' => $input['email'],
            'lozinka' => $input['lozinka']
        ]);

        if (!$korisnik) {
            $validator->registrujGresku('email', 'Korisnik nije pronađen.');
            $this->redirect('prijava', $validator);
        }

        $_SESSION['userId'] = $korisnik->id;
        $this->redirect('/');
    }
}