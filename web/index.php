<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

ini_set('display_errors', 0);

$loader = require_once __DIR__.'/../vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$app = require __DIR__.'/../src/app.php';
require __DIR__.'/../config/prod.php';
require __DIR__.'/../src/controllers.php';
$app->run();
