<?php

declare(strict_types=1);

namespace http;

class router
{
    public static function map(): void
    {
        $request = \http\request::get();
        if (!$request->api())
            $request->redirect('/docs');
        elseif ($request->empty())
            $request->redirect('/blank.html');

        $controller = '\api\controller';
        $controller::route();
    }
}
