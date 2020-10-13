<?php

namespace DietcubeKyokotsu\Service;

use Dietcube\Components\LoggerAwareTrait;

class SetArrayService
{
    use LoggerAwareTrait;

    public function setFinishArray($cryear_service)
    {
        return [
            'pagetitle'   => '処理完了',
            'description' => 'Process Finished',
            'cryear'      => $cryear_service->year(),
            'rootpath'    => $_ENV['ROOT_PATH'],
        ];
    }
    public function setErrorArray($code, $phrase, $errors, $cryear_service)
    {
        return [
            'pagetitle'   => $code,
            'description' => $phrase,
            'errors'      => $errors,
            'cryear'      => $cryear_service->year(),
            'rootpath'    => $_ENV['ROOT_PATH'],
        ];
    }
}
