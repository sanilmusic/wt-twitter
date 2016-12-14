<?php

$router->get('/', 'PocetniKontroler@index');

$router->get('partials/index', 'PartialsKontroler@index');
$router->get('partials/izgubljenaLozinka', 'PartialsKontroler@izgubljenaLozinka');
$router->get('partials/nalog', 'PartialsKontroler@nalog');
$router->get('partials/prati', 'PartialsKontroler@prati');
$router->get('partials/pratitelji', 'PartialsKontroler@pratitelji');
$router->get('partials/prijavljen', 'PartialsKontroler@prijavljen');
$router->get('partials/profil', 'PartialsKontroler@profil');