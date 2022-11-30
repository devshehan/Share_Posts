<?php
    // load config files
    require_once('config/config.php');
    echo APPROOT;

    // require libraries to the bootstrap
    // it can do that using require_once but there is method to import all of them at the once
    spl_autoload_register(function($className){
        require_once('libraries/' . $className . '.php');
    });