<?php

namespace app\core;



/**
 *Class Application
 *
 *@author hp
 *@package app\core
 */

class Application
{
    public static string $ROOT_DIR;
    public static Application $app;
    public Response $response;
    public Router $router;
    protected Request $request;

    public function __construct($rootPath)
    {
        self::$ROOT_DIR=$rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request,$this->response);
    }


    public function run()
    {
       echo $this->router->resolve();
    }

}