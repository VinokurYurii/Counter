<?php

require_once(__DIR__.'/../framework/Loader.php');

Loader::addNamespacePath('Blog\\', __DIR__.'/../src/Blog');
Loader::addNamespacePath('Accounter\\', __DIR__.'/../src/Accounter');

$app = new \Framework\Application(__DIR__.'/../app/config/config.php');

$app->run();
