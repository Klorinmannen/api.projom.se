<?php

declare(strict_types=1);

namespace http;

class router
{

    public static function map(): void
    {
        $request = \http\request::get();

        if ($request->get_type() == request::API_REQ) {
            $controller = '\api\controller';
            $controller::route();
        } else {
            header('Location: /docs', true, 301);
        }
        
    }
}
