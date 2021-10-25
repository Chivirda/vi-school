<?php
require_once __DIR__ . '../vendor/autoload.php';

$name = $request->get("name", "World");
$response->setContent(sprintf("Hello, %s", htmlspecialchars($name, ENT_QUOTES, 'UTF-8')));