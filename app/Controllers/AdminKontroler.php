<?php

namespace App\Controllers;

use App\Models\Korisnik;
use Framework\Kontroler;
use Framework\Validator;

class AdminKontroler extends Kontroler
{
    public function __construct()
    {
        if (!korisnik() || !korisnik()->admin()) {
            $this->redirect('/');
        }
    }

    public function korisnici()
    {
        $this->view('korisnici', [
            'korisnici' => Korisnik::sve(),
            'dodatnaPoruka' => $this->sesija('korisniciPoruka')
        ]);
    }

    public function csv()
    {
        $korisnici = Korisnik::sve();
        $csv = '';

        foreach ($korisnici as $korisnik) {
            $csv .= implode(',', $korisnik->atributi()) . "\n";;
        }

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=korisnici.csv');

        echo $csv;
    }

    public function pdf()
    {}

    public function noviKorisnik()
    {
        $this->view('korisnikForma');
    }

    public function izmjenaKorisnika()
    {
        $korisnik = $this->traziKorisnika();

        if (!$korisnik) {
            $this->redirect('admin/korisnici');
        }

        $this->view('korisnikForma', [
            'sacuvano' => $korisnik->atributi()
        ]);
    }

    public function sacuvajKorisnika()
    {
        $id = $this->post('id');
        $korisnik = Korisnik::dajPrvog([
            'id' => $id
        ]);

        if ($id && !$korisnik) {
            $this->redirect('/');
        }

        $input = $this->post(['ime', 'prezime', 'email', 'lozinka']);

        $validator = new Validator($input, [
            'ime' => 'potrebno',
            'prezime' => 'potrebno',
            'email' => 'potrebno|email|jedinstveno:Korisnik,' . $id,
            'lozinka' => 'potrebno|min:6'
        ]);

        $back = 'admin/korisnici/' . ($id ? 'izmjena&id=' . $id : 'novi');

        if (!$validator->validiraj()) {
            $this->redirect($back, $validator);
        }

        $input['lozinka'] = password_hash($input['lozinka'], PASSWORD_DEFAULT);

        if ($korisnik) {
            $korisnik->popuni($input);
            $poruka = 'Promjene su sačuvane.';
        } else {
            $korisnik = new Korisnik($input);
            $poruka = 'Novi korisnik je kreiran.';
        }
        $korisnik->sacuvaj();

        $_SESSION['noveJednokratne']['korisniciPoruka'] = $poruka;
        $this->redirect('admin/korisnici');
    }

    public function obrisiKorisnika()
    {
        $korisnik = $this->traziKorisnika();

        if ($korisnik) {
            $korisnik->obrisi();
        }

        $_SESSION['noveJednokratne']['korisniciPoruka'] = 'Korisnik je pobrisan.';
        $this->redirect('admin/korisnici');
    }

    private function traziKorisnika()
    {
        return Korisnik::dajPrvog([
            'id' => $this->get('id')
        ]);
    }
}