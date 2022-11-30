<?php
    class Pages extends Controller{
        public function __construct(){

        }

        public function index(){
            $data = [
                "title" => "SharePosts",
            ];

            $this->view('pages/index', $data);
        }

    }