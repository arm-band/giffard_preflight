<?php
/**
 *
 */

namespace DietcubeKyokotsu;

use Dietcube\Application as DCApplication;
use Pimple\Container;
use DietcubeKyokotsu\Service\CRYearService;
use DietcubeKyokotsu\Service\SetArrayService;
use DietcubeKyokotsu\Service\ValidationService;
use DietcubeKyokotsu\Service\HelperService;
use DietcubeKyokotsu\Service\RequestPackagingService;
use DietcubeKyokotsu\Service\ResponsePackagingService;
use DietcubeKyokotsu\Service\ConcatService;
use DietcubeKyokotsu\Service\HeaderService;

class Application extends DCApplication
{
    public function init(Container $container)
    {
        // do something before boot
    }

    public function config(Container $container)
    {
        $configPath = __DIR__ . '/config/config.php';
        if(file_exists($configPath)) {
            $config = include($configPath);
        }
        else {
            throw new \Dietcube\Exception\HttpNotFoundException();
        }

        // setup container or services here
        $container['service.cryear'] = function () use ($container, $config) {
            $cryear_service = new CRYearService($config);
            $cryear_service->setLogger($container['logger']);
            return $cryear_service;
        };
        $container['service.setarray'] = function () use ($container) {
            $setarray_service = new SetArrayService();
            $setarray_service->setLogger($container['logger']);
            return $setarray_service;
        };
        $container['service.validation'] = function () use ($container) {
            $validation_service = new ValidationService($container);
            $validation_service->setLogger($container['logger']);
            return $validation_service;
        };
        $container['service.helper'] = function () use ($container, $config) {
            $helper_service = new HelperService($config);
            $helper_service->setLogger($container['logger']);
            return $helper_service;
        };
        $container['service.requestpackaging'] = function () use ($container) {
            $requestpackaging_service = new RequestPackagingService();
            $requestpackaging_service->setLogger($container['logger']);
            return $requestpackaging_service;
        };
        $container['service.responsepackaging'] = function () use ($container) {
            $responsepackaging_service = new ResponsePackagingService();
            $responsepackaging_service->setLogger($container['logger']);
            return $responsepackaging_service;
        };
        $container['service.concat'] = function () use ($container) {
            $concat_service = new ConcatService($container);
            $concat_service->setLogger($container['logger']);
            return $concat_service;
        };
        $container['service.header'] = function () use ($container, $config) {
            $header_service = new HeaderService($config);
            $header_service->setLogger($container['logger']);
            return $header_service;
        };
    }
}
