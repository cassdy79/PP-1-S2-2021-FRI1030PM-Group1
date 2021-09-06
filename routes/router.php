
<?php
    $routes = [];

    function route($action, $callback){
        global $routes;
        $action = trim($action, '/');
        
        $routes[$action] = $callback;

    }

    function dispatch($action){
        global $routes;
        $callback = null;
        $action = trim($action, '/');
        $params = [];
    
        foreach($routes as $route => $value) {

            if(preg_match("%^{$route}$%", $action, $match) === 1) {
                $callback = $value;
                unset($match[0]);
                $params = $match;
                break;
            }
            
        }


        call_user_func($callback, ...$params);

    }
