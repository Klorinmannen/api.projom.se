<?php

declare(strict_types=1);

namespace http;

class router
{
    public static function map(
        object $http
    ): void {
        
        $request = $http->request();

        if (!$request->api())
            $request->redirect('/docs');
        elseif ($request->empty())
            $request->redirect('/blank.html');

        $controller = '\api\controller';
        $controller::route();
    }
}
