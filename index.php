<?php

// Obtén la URI del navegador
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$vistas = '/views/';

switch ($uri) {
    case '/':
    case '/index.php':
    case '/renzomotors':
        require __DIR__ . $vistas . 'public/index.php';
        break;
    case '/renzomotors/login':
        require __DIR__ . $vistas . 'public/login.php';
        break;
    case '/renzomotors/dashboard':
        require __DIR__ . $vistas . 'private/dashboard.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . $vistas . 'public/404.php';
        break;
}

?>
