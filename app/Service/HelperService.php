<?php

namespace DietcubeKyokotsu\Service;

use Dietcube\Components\LoggerAwareTrait;

class HelperService
{
    use LoggerAwareTrait;

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    function jsonEncode($data)
    {
        return json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
    }
    function jsonDecode($data)
    {
        return json_decode($data, true);
    }
    public function h($str)
    {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
    public function escape($inputData)
    {
        foreach ($inputData as $key => $value) {
            $inputData[$key] = self::h($value);
        }
        return $inputData;
    }
    public function setFlag($inputData, $key)
    {
        if (array_key_exists($key, $inputData)) {
            if (!is_bool($inputData[$key])) {
                $inputData[$key] = (boolean)$inputData[$key];
            }
        }
        else {
            $inputData[$key] = false;
        }
        return $inputData;
    }
}
