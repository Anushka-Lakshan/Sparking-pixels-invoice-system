<?php

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$uri = str_replace(BASE_URL, '', $uri);


$routes = [
    '/' => 'controllers/index.php',
    '/invoice' => 'controllers/invoice.php',
    '/pdf' => 'controllers/pdf.php',
    '/Backup-now' => 'controllers/backup.php',
    '/restore' => 'controllers/restore.php',
    // '/invoice-download' => 'controllers/invoice-download.php',
    // '/invoice-test' => 'controllers/invoice-test.php'
];

function routeToController($uri, $routes)
{
    if (array_key_exists($uri, $routes)) {
        require $routes[$uri];
    } else {
        require 'controllers/404.php';
    }
}



routeToController($uri, $routes);
