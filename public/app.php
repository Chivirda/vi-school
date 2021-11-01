<?php

namespace App;

require_once '../vendor/autoload.php';
require_once 'LeapYearController.php';

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;


function is_leap_year($year = null): bool
{
  if ($year === null) {
    $year = date('Y');
  }

  return ($year % 400 === 0) || ($year % 4 === 0 && $year % 100 !== 0);
}

$routes = new RouteCollection();
$routes->add('hello', new Route('/hello/{name}', [
  'name' => 'World',
  '_controller' => 'render_template'
]));
$routes->add('bye', new Route('/bye'));
$routes->add('leap_year', new Route('/is_leap_year/{year}', [
    'year' => null,
    '_controller' => [new LeapYearController(), 'index']
]));


return $routes;