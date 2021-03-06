<?php

namespace App;

require_once '../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;


$request = Request::createFromGlobals();
$routes = include './app.php';

function render_template(Request $request): Response
{
    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include sprintf('./pages/%s.php', $_route);

    return new Response(ob_get_clean());
}

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

$controllerResolver = new ControllerResolver();
$argumentResolver = new ArgumentResolver();

try {
    $request->attributes->add($matcher->match($request->getPathInfo()));

    $controller = $controllerResolver->getController($request);
//    $arguments = $argumentResolver->getArguments($request, $controller);

    $response = call_user_func($controller, $request);
} catch (ResourceNotFoundException $exception) {
    $response = new Response('Страница не существует', 404);
} catch (Exception $exception) {
    $response = new Response('Oшибка сервера', 500);
}


$response->send();