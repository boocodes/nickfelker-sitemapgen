<?php
    spl_autoload_register(function ($class){
        $filename = "src/app/{$class}.php";
        require_once $filename;
    });
