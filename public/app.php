<?php
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

function is_leap_year($year = null)
{
  if ($year === null) {
    $year = date('Y');
  }

  return 0 === $year % 400 || (0 === $year % 4 && 0 !== $year % 100);
}

$routes = new RouteCollection();
$routes->add('hello', new Route('/hello/{name}', [
  'name' => 'World',
  '_controller' => 'render_template'
]));
$routes->add('bye', new Route('/bye'));
$routes->add('leap_year', new Route('/is_leap_year/{year}', [
  'year' => null,
  '_controller' => function (Request $request): Response
  {
    if (is_leap_year($request->attributes->get('year'))) {
      return new Response('Yep, this is a leap year!');
    }

    return new Response('Nope, this is not leap year.');
  }
]));

return $routes;