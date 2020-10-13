<?php

namespace DietcubeKyokotsu\Service;

use Dietcube\Components\LoggerAwareTrait;

class HeaderService
{
    use LoggerAwareTrait;

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function setHeader($inputPost)
    {
        $headersArray = [
            'Access-Control-Allow-Origin'  => explode(':', $this->config['appconfig']['url'])[0] . ':' . explode(':', $this->config['appconfig']['url'])[1] . ':3000',
            'Access-Control-Allow-Methods' => 'GET, POST, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Accept',
            'Content-Type'                 => 'application/json',
            'X-Identified-Header'          => $_SERVER['REQUEST_METHOD'] . ', ' . file_get_contents('php://input')
        ];
        if (!$inputPost['ACAO']) {
            unset($headersArray['Access-Control-Allow-Origin']);
        }
        if (!$inputPost['ACAH']) {
            unset($headersArray['Access-Control-Allow-Headers']);
        }
        if (!$inputPost['ACAM']) {
            unset($headersArray['Access-Control-Allow-Methods']);
        }
        return $headersArray;
    }
    public function setPreflightHeader()
    {
        $headersArray = [
            'Access-Control-Allow-Origin'  => explode(':', $this->config['appconfig']['url'])[0] . ':' . explode(':', $this->config['appconfig']['url'])[1] . ':3000',
            'Access-Control-Allow-Methods' => 'GET, POST, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Accept',
            'Content-Type'                 => 'application/json',
            'X-Identified-Header'          => $_SERVER['REQUEST_METHOD']
        ];
        return $headersArray;
    }
    public function setPlainHeader()
    {
        return [
            'Access-Control-Allow-Origin'  => explode(':', $this->config['appconfig']['url'])[0] . ':' . explode(':', $this->config['appconfig']['url'])[1] . ':3000',
            'Access-Control-Allow-Methods' => 'GET, POST, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Accept',
            'Content-Type'                 => 'plain/text',
            'X-Identified-Header'          => $_SERVER['REQUEST_METHOD']
        ];
    }
}
