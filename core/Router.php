<?php

namespace core;

class Router
{
    public static function proccess($route)
    {
        try{
           $routeParts =  explode('/',$route);
           $controller = '\\core\\'.ucfirst($routeParts[0]);
           $action = explode('.',$routeParts[1]);
           $controller = new $controller;
           $controller->{$action[0]}();

        }catch (Exceptions $e){
            echo 'Error: ',  $e->getMessage(), "\n";
        }
    }
    
}
