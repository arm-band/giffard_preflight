<?php
/**
 *
 */

namespace DietcubeKyokotsu\Controller;

use Pimple\Container;
use Dietcube\Controller;

class TopController extends Controller
{
    const OK = 200;
    const FORBIDDEN = 403;

    protected $container;
    protected $cryear_service;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->cryear_service = $this->get('service.cryear');
    }

    public function index()
    {
        $response = $this->getResponse();
        $response->setStatusCode(self::OK);
        return $this->render('index', [
            'cryear'          => $this->cryear_service->year(),
            'rootpath'        => $_ENV['ROOT_PATH'],
        ]);
    }
}
