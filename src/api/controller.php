<?php

declare(strict_types=1);

namespace api;

class controller
{
    public static function route(): void
    {
        ob_clean();

        $request = new \http\request();
        
        // Route new request
        $router = new router($request);
        $router->map();
        $router_data = $router->data();

        $api_config = \system::config()->api();
        $route = new route($router_data, $request, $api_config);
        $route->validate();

        // Make endpoint call
        $response = $route->call();

        header('Content-Type: application/json; charset=utf-8');
        echo $response;
        exit;
    }
}
