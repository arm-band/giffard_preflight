<?php

namespace DietcubeKyokotsu\Service;

use Dietcube\Components\LoggerAwareTrait;

class ResponsePackagingService
{
    use LoggerAwareTrait;

    public function header($code, $message)
    {
        return [
            'Code'           => $code,
            'Status-Message' => $message,
            'Protocol'       => $_SERVER['SERVER_PROTOCOL'],
            'HTTP-Status'    => $_SERVER['SERVER_PROTOCOL'] . ' ' . $code . ' ' . $message,
            'Host'           => $_SERVER['HTTP_HOST'],
            'Date'           => date('D, d M Y H:i:s T'),
            'Connection'     => isset($_SERVER['HTTP_CONNECTION']) && !empty($_SERVER['HTTP_CONNECTION']) ? $_SERVER['HTTP_CONNECTION'] : 'Close',
            'X-Powered-By'   => explode(' ', $_SERVER['SERVER_SOFTWARE'])[0] . '/' . explode(' ', $_SERVER['SERVER_SOFTWARE'])[1],
            'Content-Type'   => isset($_SERVER['CONTENT_TYPE']) && !empty($_SERVER['CONTENT_TYPE']) ? $_SERVER['CONTENT_TYPE'] : ''
        ];
    }
    public function generate($code, $message)
    {
        return [
            'header' => self::header($code, $message)
        ];
    }
    public function error($code, $message)
    {
        return [
            'Code'           => $code,
            'Status-Message' => $message,
            'Protocol'       => $_SERVER['SERVER_PROTOCOL'],
            'HTTP-Status'    => $_SERVER['SERVER_PROTOCOL'] . ' ' . $code . ' ' . $message
        ];
    }
}
