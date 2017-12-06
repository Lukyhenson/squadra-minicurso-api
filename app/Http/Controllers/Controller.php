<?php

namespace App\Http\Controllers;

use App\Util\JsonUtils;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class Controller
 *
 * @package App\Http\Controllers
 * @author Squadra Tecnologia S/A.
 */
class Controller extends BaseController
{
    /**
     * Retorna o 'Objeto' serializado em 'json'.
     *
     * @param $object
     * @return string
     */
    protected function toJson($object)
    {
        header('Content-Type: application/json; charset=utf-8');

        return JsonUtils::toJson($object);
    }
}
