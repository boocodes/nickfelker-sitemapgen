<?php

    class ErrorMapGeneratorDirectoryAccessException extends Exception{
        function __construct(){
            $this->message = "Error. Programm can`t get access to result folder\n";
        }
    }