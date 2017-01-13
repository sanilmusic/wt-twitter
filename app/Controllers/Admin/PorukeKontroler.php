<?php

namespace App\Controllers\Admin;

use App\Models\Poruka;
use App\Models\Korisnik;
use \Framework\Validation\Validator;
use App\Controllers\Admin\AdminKontroler;

class PorukeKontroler extends AdminKontroler
{
    public function index()
    {
        $this->view('index', [
            'poruke' => Poruka::sve(),
            'dodatnaPoruka' => $this->sesija('porukePoruka')
        ]);
    }

    public function nova()
    {
        $this->view('forma', [
            'korisnici' => Korisnik::sve()
        ]);
    }

    public function izmjena()
    {
        $poruka = $this->traziPoruku();

        if (!$poruka) {
            $this->redirect('admin/poruke');
        }

        $this->view('forma', [
            'korisnici' => Korisnik::sve(),
            'sacuvano' => $poruka->atributi()
        ]);
    }

    public function sacuvaj()
    {
        $id = $this->post('id');
        $poruka = Poruka::query()->gdje('id', $id)->prvi();

        if ($id && !$poruka) {
            $this->redirect('/admin/poruke');
        }

        $input = $this->post(['korisnik_id', 'tekst']);

        $validator = new Validator($input, [
            'korisnik_id' => 'potrebno|postoji:Korisnik',
            'tekst' => 'potrebno'
        ]);

        $back = 'admin/poruke/' . ($id ? 'izmjena&id=' . $id : 'nova');

        if (!$validator->validiraj()) {
            $this->redirect($back, $validator);
        }

        if ($poruka) {
            $poruka->azurirajAtribute($input);
            $rez = 'Promjene su sačuvane.';
        } else {
            $poruka = new Poruka($input);
            $poruka->kad = time();
            $rez = 'Nova poruka je kreirana.';
        }
        $poruka->sacuvaj();

        $_SESSION['noveJednokratne']['porukePoruka'] = $rez;
        $this->redirect('admin/poruke');
    }

    public function obrisi()
    {
        $poruka = $this->traziPoruku();

        if ($poruka) {
            $poruka->obrisi();
        }

        $_SESSION['noveJednokratne']['porukePoruka'] = 'Poruka je pobrisana.';
        $this->redirect('admin/poruke');
    }

    private function traziPoruku()
    {
        return Poruka::query()->gdje('id', $this->get('id'))->prvi();
    }
}