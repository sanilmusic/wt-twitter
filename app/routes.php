<?php

$router->get('/', 'PocetniKontroler@index');

$router->get('lozinka', 'LozinkaKontroler@forma');

$router->get('nalog', 'NalogKontroler@index');

$router->get('profil', 'ProfilKontroler@index');
$router->get('profil/toggle', 'ProfilKontroler@toggle');
$router->post('profil/postavi', 'ProfilKontroler@postavi');

$router->get('prijava', 'AuthKontroler@prijavaForma');
$router->post('prijava', 'AuthKontroler@prijava');

$router->get('odjava', 'AuthKontroler@odjava');

$router->post('registracija', 'AuthKontroler@registracija');

$router->get('pretraga', 'PretragaKontroler@pretraga');
$router->get('pretraga/ajax', 'PretragaKontroler@ajax');

$router->get('admin/korisnici', 'Admin\KorisniciKontroler@index');
$router->get('admin/korisnici/export/csv', 'Admin\KorisniciKontroler@csv');
$router->get('admin/korisnici/export/pdf', 'Admin\KorisniciKontroler@pdf');
$router->get('admin/korisnici/novi', 'Admin\KorisniciKontroler@novi');
$router->get('admin/korisnici/izmjena', 'Admin\KorisniciKontroler@izmjena');
$router->post('admin/korisnici/sacuvaj', 'Admin\KorisniciKontroler@sacuvaj');
$router->get('admin/korisnici/obrisi', 'Admin\KorisniciKontroler@obrisi');

$router->get('admin/poruke', 'Admin\PorukeKontroler@index');
$router->get('admin/poruke/nova', 'Admin\PorukeKontroler@nova');
$router->get('admin/poruke/izmjena', 'Admin\PorukeKontroler@izmjena');
$router->post('admin/poruke/sacuvaj', 'Admin\PorukeKontroler@sacuvaj');
$router->get('admin/poruke/obrisi', 'Admin\PorukeKontroler@obrisi');

$router->get('admin/transfer', 'Admin\TransferKontroler@transfer');

$router->get('api/korisnici', 'ApiKontroler@korisnici');