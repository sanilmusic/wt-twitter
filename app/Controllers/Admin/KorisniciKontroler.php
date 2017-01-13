<?php

namespace App\Controllers\Admin;

use App\Report;
use App\Models\Poruka;
use App\Models\Korisnik;
use Framework\Validation\Validator;
use App\Controllers\Admin\AdminKontroler;

class KorisniciKontroler extends AdminKontroler
{
    public function index()
    {
        $this->view('index', [
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
    {
        (new Report)->Generate()->Output();
    }

    public function novi()
    {
        $this->view('forma');
    }

    public function izmjena()
    {
        $korisnik = $this->traziKorisnika();

        if (!$korisnik) {
            $this->redirect('admin/korisnici');
        }

        $this->view('forma', [
            'sacuvano' => $korisnik->atributi()
        ]);
    }

    public function sacuvaj()
    {
        $id = $this->post('id');
        $korisnik = Korisnik::query()->gdje('id', $id)->prvi();

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
            $korisnik->azurirajAtribute($input);
            $poruka = 'Promjene su sačuvane.';
        } else {
            $korisnik = new Korisnik($input);
            $poruka = 'Novi korisnik je kreiran.';
        }
        $korisnik->sacuvaj();

        $_SESSION['noveJednokratne']['korisniciPoruka'] = $poruka;
        $this->redirect('admin/korisnici');
    }

    public function obrisi()
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
        return Korisnik::query()->gdje('id', $this->get('id'))->prvi();
    }
}