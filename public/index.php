<?php
require_once '../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$response = new Response();

$name = $request->get("name", "World");

$map = [
    '/hello' => './pages/hello.php',
    '/bye' => './pages/bye.php'
];

$path = $request->getPathInfo();

if ($path == '/') {
    print '<h1>Добрый день!</h1>';
}

if (isset($map[$path])) {
    require_once $map[$path];
} elseif ($path != '/') {
    $response->setStatusCode(404);
    $response->setContent("Страница не найдена");
}

$response->send();

