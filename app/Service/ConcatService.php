<?php

namespace DietcubeKyokotsu\Service;

use Dietcube\Components\LoggerAwareTrait;

class ConcatService
{
    use LoggerAwareTrait;

    public function concat($request, $response, $helper_service)
    {
        return $helper_service->jsonEncode([
            'request'  => $request,
            'response' => $response
        ]);
    }
}
