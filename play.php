<?php

$container = require __DIR__ . '/app/bootstrap.php';
$crazyEights = $container->get('crazyEights');

$crazyEights->play();
