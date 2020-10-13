<?php

namespace DietcubeKyokotsu;

use Dietcube\RouteInterface;
use Pimple\Container;

class Route implements RouteInterface
{
    /**
     * {@inheritDoc}
     */
    public function definition(Container $container)
    {
        return [
            ['GET', $_ENV['ROOT_PATH'], 'Top::index'],
            ['POST', $_ENV['ROOT_PATH'] . 'icanfly/web', 'Flight::mirrorHTML'],
            ['GET', $_ENV['ROOT_PATH'] . 'icanfly/plain', 'Flight::mirrorText'],
            [['GET', 'POST', 'OPTIONS'], $_ENV['ROOT_PATH'] . 'icanfly/api', 'Flight::mirrorJson'],
        ];
    }
}
