<?php

namespace DietcubeKyokotsu\Service;

use Dietcube\Components\LoggerAwareTrait;

class RequestPackagingService
{
    use LoggerAwareTrait;

    public function header()
    {
        $requestHeaders = apache_request_headers();
        unset($requestHeaders['Cookie']);
        $requestHeaders['Method'] = $_SERVER['REQUEST_METHOD'];
        return $requestHeaders;
    }
    public function generate($inputPost)
    {
        return [
            'header' => self::header(),
            'body'   => $inputPost
        ];
    }
}
