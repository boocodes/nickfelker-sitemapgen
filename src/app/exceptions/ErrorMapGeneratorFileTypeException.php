<?php

    class ErrorMapGeneratorFileTypeException extends Exception{
        function __construct(){
            $this->message = "Error. File extension is error. Now allowed only: xml, csv, json. Change it\n";
        }
    }