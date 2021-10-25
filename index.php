<?php
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$response = new Response();

$name = $request->get("name", "World");

$map = [
    '/' => './pages/hello.php',
    '/hello' => './pages/hello.php',
    '/bye' => './pages/bye.php'
];

$path = $request->getPathInfo();

if (isset($map[$path])) {
    require_once $map[$path];
} else {
    $response->setStatusCode(404);
    $response->setContent("Страница не найдена");
}

$response->send();

