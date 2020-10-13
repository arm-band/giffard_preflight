<?php

namespace DietcubeKyokotsu\Service;

use Pimple\Container;
use Dietcube\Components\LoggerAwareTrait;
use Valitron\Validator;

class ValidationService
{
    use LoggerAwareTrait;

    protected $container;
    protected $v;

    public function __construct(Container $container)
    {
        $this->container = $container;
        \Valitron\Validator::lang('ja');
    }

    public function validationData($post)
    {
        $FLIGHT_NAME = 'testFlight';
        $ACAO = 'ACAO';
        $ACAH = 'ACAH';
        $ACAM = 'ACAM';
        $v = new \Valitron\Validator($post);
        //required
        $v->rule('required',
            [
                $FLIGHT_NAME,
                $ACAO,
                $ACAH,
                $ACAM
            ]
        )->message('{field}は必須です');
        //boolean
        $v->rule('boolean', $ACAO);
        $v->rule('boolean', $ACAH);
        $v->rule('boolean', $ACAM);

        //label
        $v->labels([
            $FLIGHT_NAME => 'Test Flight',
            $ACAO        => 'Access-Control-Allow-Origin',
            $ACAH        => 'Access-Control-Allow-Headers',
            $ACAM        => 'Access-Control-Allow-Methods',
        ]);

        if($v->validate()) {
            return [];
        }
        else {
            $errors = [];
            foreach($v->errors() as $error) {
                foreach($error as $value) {
                    array_push($errors, $value);
                }
            }

            return $errors;
        }
    }
}
