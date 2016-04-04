<?php

namespace App\Services;

class URL
{

    protected $routes;

    public function __construct(array $data)
    {
        $this->routes = $data;
    }

    function redirect($route)
    {
        if(strpos($route, 'http') || strpos($route, 'www')){
            header('Location: '.$route);
        }
        else
        {
            header('Location: '.$this->getUrl($route));
        }

        die();
    }


    function getUrl($route)
    {
        $protocol = !empty($_SERVER['HTTPS']) ? 'https' : 'http';
        return $protocol.'://'.$_SERVER['HTTP_HOST'].'/'.$this->routes[$route];
    }

}








