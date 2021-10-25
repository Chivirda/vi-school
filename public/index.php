<?php
require_once '../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$request = Request::createFromGlobals();
$response = new Response();

$context = new RequestContext();
$context->fromRequest($request);

$routes = new RouteCollection();
$routes->add('hello', new Route('/hello/{name}', ['name' => 'World']));
$routes->add('bye', new Route('/bye'));

$matcher = new UrlMatcher($routes, $context);

try {
    extract($matcher->match($request->getPathInfo()), EXTR_SKIP);
    ob_start();
    include sprintf('./pages/%s.php', $_route);
} catch (ResourceNotFoundException $exception) {
    $response = new Response('Страница не существует', 404);
} catch (Exception $exception) {
    $response = new Response('Oшибка сервера', 500);
}


$response->send();

