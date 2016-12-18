<?php

// Debugging
ini_set('display_errors', 'on');

session_start();

define('PATH', dirname(__FILE__));

require PATH . '/bootstrap/autoload.php';

$loader = new \Psr4AutoloaderClass;

// Registrujemo PSR-4 autoloader za klase
$loader->register();

// Mapiraj imenike i mjesta gdje su smješteni
$loader->addNamespace('Framework', PATH . '/framework');
$loader->addNamespace('App', PATH . '/app');

$router = new \Framework\Router;

// Registruj rute
require PATH . '/app/routes.php';

// Učitaj pomoćne funkcije
require PATH . '/app/helpers.php';

// Podesi jednokratne sesije
$_SESSION = array_merge($_SESSION, $_SESSION['noveJednokratne']);
$stareJednokratne = array_keys($_SESSION['noveJednokratne']);
$_SESSION['noveJednokratne'] = [];

// Preostale aktivnosti obavlja router
$router->rutiraj();

// Počisti jednokratne sesije
foreach ($stareJednokratne as $stari) {
    unset($_SESSION[$stari]);
}