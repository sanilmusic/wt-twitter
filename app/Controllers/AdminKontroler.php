<?php

namespace App\Controllers;

use App\Models\Poruka;
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

    public function poruke()
    {
        $this->view('poruke', [
            'poruke' => Poruka::sve(),
            'dodatnaPoruka' => $this->sesija('porukePoruka')
        ]);
    }

    public function novaPoruka()
    {
        $this->view('porukaForma', [
            'korisnici' => Korisnik::sve()
        ]);
    }

    public function izmjenaPoruke()
    {
        $poruka = $this->traziPoruku();

        if (!$poruka) {
            $this->redirect('admin/poruke');
        }

        $this->view('porukaForma', [
            'korisnici' => Korisnik::sve(),
            'sacuvano' => $poruka->atributi()
        ]);
    }

    public function sacuvajPoruku()
    {
        $id = $this->post('id');
        $poruka = Poruka::dajPrvog([
            'id' => $id
        ]);

        if ($id && !$poruka) {
            $this->redirect('/admin/poruke');
        }

        $input = $this->post(['korisnik', 'tekst']);

        $validator = new Validator($input, [
            'korisnik' => 'potrebno|postoji:Korisnik',
            'tekst' => 'potrebno'
        ]);

        $back = 'admin/poruke/' . ($id ? 'izmjena&id=' . $id : 'novi');

        if (!$validator->validiraj()) {
            $this->redirect($back, $validator);
        }

        if ($poruka) {
            $poruka->popuni($input);
            $rez = 'Promjene su sačuvane.';
        } else {
            $poruka = new Poruka($input);
            $rez = 'Nova poruka je kreirana.';
        }
        $poruka->sacuvaj();

        $_SESSION['noveJednokratne']['porukePoruka'] = $rez;
        $this->redirect('admin/poruke');
    }

    public function obrisiPoruku()
    {
        $poruka = $this->traziPoruku();

        if ($poruka) {
            $poruka->obrisi();
        }

        $_SESSION['noveJednokratne']['porukePoruka'] = 'Poruka je pobrisana.';
        $this->redirect('admin/poruke');
    }

    private function traziKorisnika()
    {
        return Korisnik::dajPrvog([
            'id' => $this->get('id')
        ]);
    }

    private function traziPoruku()
    {
        return Poruka::dajPrvog([
            'id' => $this->get('id')
        ]);
    }
}