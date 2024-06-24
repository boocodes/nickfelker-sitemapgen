<?php
    class ErrorMapGeneratorDataException extends Exception{
        function __construct(){
            $this -> message = "Error, incorrect data when created site`s map \n";
        }
    }