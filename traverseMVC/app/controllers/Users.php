<?php
    class Users extends Controller{

        public function __construct(){
            
        }

        public function register(){
            $this->view('pages/register');

        }


    }