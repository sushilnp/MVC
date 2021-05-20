<?php

use app\core\Application;

require_once __DIR__ . "/../vendor/autoload.php";


    $app = new Application(dirname(__DIR__));

    $app->router->get('/home','home');

    $app->router->get('/contact','contact');
    $app->router->post('/contact',function (){ echo "form submitted";});


      $app->run();