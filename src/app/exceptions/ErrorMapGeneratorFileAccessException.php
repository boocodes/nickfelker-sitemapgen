<?php
    class ErrorMapGeneratorFileAccessException extends Exception{
        function __construct(){
            $this->message = "Error. Programm can`t get access to result file\n";
        }
    }