<?php

declare(strict_types=1);

namespace http;

class router
{

    public static function map(): void
    {
        $request = \http\request::get();

        if ($request->type() != request::API_REQ)
            header('Location: /docs', true, 301);

        $controller = '\api\controller';
        $controller::route();
    }
}
