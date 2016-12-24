<?php

$router->get('/', 'PocetniKontroler@index');

$router->get('lozinka', 'LozinkaKontroler@forma');

$router->get('nalog', 'NalogKontroler@index');

$router->get('profil', 'ProfilKontroler@index');

$router->get('prijava', 'AuthKontroler@prijavaForma');
$router->post('prijava', 'AuthKontroler@prijava');

$router->post('registracija', 'AuthKontroler@registracija');