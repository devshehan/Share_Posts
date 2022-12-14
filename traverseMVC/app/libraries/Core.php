<?php
    /*
        App Core class
        Create URL and Loads Core controller
        URL format /controller/method/params    
    */

    class Core{
        protected $currentController = "Pages";
        protected $currentMethod = 'index';
        protected $params = [];

        //create a constructor
        public function __construct(){
            //in this url dic include PageName/METHOD/params
            $url = $this->getUrl();

            //check url pages exist
            if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
                $this->currentController = ucwords($url[0]);
                unset($url[0]);     // unset the first value from the url array
            }

            //require the control
            require_once('../app/controllers/' . $this->currentController . '.php');

            //instatiate the class
            $this->currentController = new $this->currentController;


            
            //check method in the url
            if(isset($url[1])){
                if(method_exists($this->currentController, $url[1])){
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }
            }


            //get the parameters in the url
            $this->params = $url ? array_values($url) : [];

            // this line call the functions in that page ex:- index() function calls
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
            
        }

        //get url
        public function getUrl(){
            if(isset($_GET['url'])){
              $url = rtrim($_GET['url'], '/');
              $url = filter_var($url, FILTER_SANITIZE_URL);
              $url = explode('/', $url);
              return $url;
            }
        }
        
    }