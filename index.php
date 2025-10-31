#! /usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use TaskCli\Controller;
use TaskCli\View;

try {
    $controller = new Controller($argv, $argc);
    $controller->execute();
} catch (Exception $e) {
    $view = new View();
    $view->exception($e);
}
