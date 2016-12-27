<?php

$router->get('/', 'PocetniKontroler@index');

$router->get('lozinka', 'LozinkaKontroler@forma');

$router->get('nalog', 'NalogKontroler@index');

$router->get('profil', 'ProfilKontroler@index');

$router->get('prijava', 'AuthKontroler@prijavaForma');
$router->post('prijava', 'AuthKontroler@prijava');

$router->get('odjava', 'AuthKontroler@odjava');

$router->post('registracija', 'AuthKontroler@registracija');

$router->get('admin/korisnici', 'AdminKontroler@korisnici');
$router->get('admin/korisnici/export/csv', 'AdminKontroler@csv');
$router->get('admin/korisnici/export/pdf', 'AdminKontroler@pdf');
$router->get('admin/korisnici/novi', 'AdminKontroler@noviKorisnik');
$router->get('admin/korisnici/izmjena', 'AdminKontroler@izmjenaKorisnika');
$router->post('admin/korisnici/sacuvaj', 'AdminKontroler@sacuvajKorisnika');
$router->get('admin/korisnici/obrisi', 'AdminKontroler@obrisiKorisnika');