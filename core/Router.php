<?php

namespace app\core ;

/**
 *Class Application
 *
 *@author hp
 *@package app\core
 */

    class Router
    {


        protected  array $routes =[];
        public Request  $request;
        public Response $response;

        public function __construct($request,$response)
        {

            $this->request = $request;
            $this->response = $response;
        }

        public function get($path,$callback)
        {
            $this->routes['get'][$path] = $callback;
        }
        public function post($path,$callback)
        {
            $this->routes['post'][$path] = $callback;
        }

         public function resolve()
        {

            $path = $this->request->getPath();
            $method = $this->request->method();
            $callback = $this->routes[$method][$path] ?? false;
             if ($callback === false)
             {
                 $this->response->setstatuscode(404);
                 return  $this->renderView('_404');

             }
             if(is_string($callback))
             {
                 return  $this->renderView($callback);
             }
             if (is_array($callback))
             {
                 Application::$app->controller = new $callback[0]();
                 $callback[0] = Application::$app->controller;
             }
            

             return call_user_func($callback, $this->request);
        }

        public function renderView($view ,$params = [])
        {
            $layoutContent = $this->layoutContent();
            $viewOnly = $this->renderViewOnly($view,$params);

           return str_replace('{{content}}',$viewOnly,$layoutContent);
        }

         protected function layoutContent()
        {
            $layout = Application::$app->controller->layout;
            ob_start()  ;
            include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
            return  ob_get_clean();
            
        }

        protected function renderViewOnly($view ,$params)
        {
             foreach ($params as $key => $value)
             {
                 $$key =$value;
             }

            ob_start();
            include_once Application::$ROOT_DIR."/views/$view.php";
            return ob_get_clean();


        }


    }
