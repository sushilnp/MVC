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

        public function resolve()
        {

            $path = $this->request->getPath();
            $method = $this->request->getMethod();
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
             return call_user_func($callback);
        }

        public function renderView($view)
        {
            $layoutContent = $this->layoutContent();
            $viewOnly = $this->renderViewOnly($view);

           return str_replace('{{content}}',$viewOnly,$layoutContent);
        }

         protected function layoutContent()
        {
            ob_start()  ;
            include_once Application::$ROOT_DIR.'/views/layouts/main.php';
            return  ob_get_clean();
            
        }

        protected function renderViewOnly($view)
        {
            ob_start();
            include_once Application::$ROOT_DIR."/views/$view.php";
            return ob_get_clean();


        }


    }
