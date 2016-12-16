<?php

$router->get('/', 'PocetniKontroler@index');

$router->get('lozinka', 'LozinkaKontroler@forma');

$router->get('nalog', 'NalogKontroler@index');

$router->get('profil', 'ProfilKontroler@index');