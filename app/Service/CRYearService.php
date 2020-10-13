<?php

namespace DietcubeKyokotsu\Service;

use Dietcube\Components\LoggerAwareTrait;

class CRYearService
{
    use LoggerAwareTrait;

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function year()
    {
        $nowyear = date('Y');
        if ((int)$nowyear > (int)$this->config['appconfig']['year']) {
            return $this->config['appconfig']['year'] . '-' . $nowyear;
        }

        return $nowyear;
    }
}
