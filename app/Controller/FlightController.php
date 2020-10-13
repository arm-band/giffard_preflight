<?php
/**
 *
 */

namespace DietcubeKyokotsu\Controller;

use Pimple\Container;
use Dietcube\Controller;
use Valitron\Validator;
use DietcubeKyokotsu\Helper as Helper;

class FlightController extends Controller
{
    const OK = 200;
    const BAD_REQUEST = 400;
    const METHOD_NOT_ALLOWED = 405;

    protected $container;
    protected $cryear_service;
    protected $setarray_service;
    protected $validation_service;
    protected $helper_service;
    protected $requestpackaging_service;
    protected $responsepackaging_service;
    protected $concat_service;
    protected $header_service;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->cryear_service = $this->get('service.cryear');
        $this->setarray_service = $this->get('service.setarray');
        $this->validation_service = $this->get('service.validation');
        $this->helper_service = $this->get('service.helper');
        $this->requestpackaging_service = $this->get('service.requestpackaging');$this->responsepackaging_service = $this->get('service.responsepackaging');
        $this->concat_service = $this->get('service.concat');
        $this->header_service = $this->get('service.header');
    }

    public function mirrorText()
    {
        $response = $this->getResponse();
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            //validation
                $response->setStatusCode(self::OK);
                $requestContents = $this->requestpackaging_service->generate([]);
                $responseContents = $this->responsepackaging_service->generate(self::OK, $response->getReasonPhrase());
                $headerParams = $this->header_service->setPlainHeader();
                foreach ($headerParams as $key => $value) {
                    header($key . ': ' . $value);
                    $responseContents['header'] = array_merge($responseContents['header'], $headerParams);
                }
                $jsonData = $this->concat_service->concat($requestContents, $responseContents, $this->helper_service);
                return $jsonData;
        }
        else {
            $response->setStatusCode(self::METHOD_NOT_ALLOWED);
            $responseContents = $this->responsepackaging_service->generate(self::METHOD_NOT_ALLOWED, $response->getReasonPhrase());
            $headerParams = $this->header_service->setPlainHeader();
            foreach ($headerParams as $key => $value) {
                header($key . ': ' . $value);
                $responseContents['header'] = array_merge($responseContents['header'], $headerParams);
            }
            return $this->helper_service->jsonEncode($responseContents);
        }
    }
    public function mirrorJson()
    {
        $response = $this->getResponse();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //validation
            $inputPost = $this->helper_service->jsonDecode(file_get_contents('php://input'));
            $inputPost = $this->helper_service->escape($inputPost);
            $inputPost = $this->helper_service->setFlag($inputPost, 'ACAO');
            $inputPost = $this->helper_service->setFlag($inputPost, 'ACAH');
            $inputPost = $this->helper_service->setFlag($inputPost, 'ACAM');
            $errors = $this->validation_service->validationData($inputPost);
            if(count($errors)) {
                $response->setStatusCode(self::BAD_REQUEST);
                $responseContents = $this->responsepackaging_service->generate(self::BAD_REQUEST, $response->getReasonPhrase());
                $headerParams = $this->header_service->setHeader($inputPost);
                foreach ($headerParams as $key => $value) {
                    header($key . ': ' . $value);
                    $responseContents['header'] = array_merge($responseContents['header'], $headerParams);
                }
                return $this->helper_service->jsonEncode($responseContents);
            }
            else {
                $response->setStatusCode(self::OK);
                $requestContents = $this->requestpackaging_service->generate($inputPost);
                $responseContents = $this->responsepackaging_service->generate(self::OK, $response->getReasonPhrase());
                $headerParams = $this->header_service->setHeader($inputPost);
                foreach ($headerParams as $key => $value) {
                    header($key . ': ' . $value);
                    $responseContents['header'] = array_merge($responseContents['header'], $headerParams);
                }
                $jsonData = $this->concat_service->concat($requestContents, $responseContents, $this->helper_service);
                return $jsonData;
            }
        }
        else if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            $response->setStatusCode(self::OK);
            $requestContents = $this->requestpackaging_service->generate([ 'preflightRequest' => true ]);
            $responseContents = $this->responsepackaging_service->generate(self::OK, $response->getReasonPhrase());
            $headerParams = $this->header_service->setPreflightHeader();
            foreach ($headerParams as $key => $value) {
                header($key . ': ' . $value);
                $responseContents['header'] = array_merge($responseContents['header'], $headerParams);
            }
            $jsonData = $this->concat_service->concat($requestContents, $responseContents, $this->helper_service);
            return $jsonData;
        }
        else {
            $response->setStatusCode(self::METHOD_NOT_ALLOWED);
            $responseContents = $this->responsepackaging_service->generate(self::METHOD_NOT_ALLOWED, $response->getReasonPhrase());
            $headerParams = $this->header_service->setHeader($inputPost);
            foreach ($headerParams as $key => $value) {
                header($key . ': ' . $value);
                $responseContents['header'] = array_merge($responseContents['header'], $headerParams);
            }
            return $this->helper_service->jsonEncode($responseContents);
        }
    }
    public function mirrorHTML()
    {
        $response = $this->getResponse();
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputPost = $this->helper_service->escape($_POST);
            $inputPost = $this->helper_service->setFlag($inputPost, 'ACAO');
            $inputPost = $this->helper_service->setFlag($inputPost, 'ACAH');
            $inputPost = $this->helper_service->setFlag($inputPost, 'ACAM');
            //validation
            $errors = $this->validation_service->validationData($inputPost);
            if(count($errors)) {
                $response->setStatusCode(self::BAD_REQUEST);
                return $this->render('error', $this->setarray_service->setErrorArray(self::BAD_REQUEST, $response->getReasonPhrase(), $errors, $this->cryear_service));
            }
            else {
                $response->setStatusCode(self::OK);
                $requestContents = $this->requestpackaging_service->generate($inputPost);
                $responseContents = $this->responsepackaging_service->generate(self::OK, $response->getReasonPhrase());
                $jsonData = $this->concat_service->concat($requestContents, $responseContents, $this->helper_service);
                return $this->render('results', [
                    'cryear'          => $this->cryear_service->year(),
                    'rootpath'        => $_ENV['ROOT_PATH'],
                    'jsondata'        => $jsonData
                ]);
            }
        }
        else {
            $response->setStatusCode(self::METHOD_NOT_ALLOWED);
            return $this->render('error', $this->setarray_service->setErrorArray(self::METHOD_NOT_ALLOWED, $response->getReasonPhrase(), ['許可されていないメソッドです。'], $this->cryear_service));
        }
    }
}
