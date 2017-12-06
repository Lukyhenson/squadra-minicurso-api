<?php

namespace App\Exceptions;

use App\Util\Utils;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;

/**
 * Class Handler
 *
 * @package App\Exceptions
 * @author Squadra Tecnologia S/A.
 */
class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, \Exception $e)
    {
        $response = response()->make('');
        $response->header('Content-Type', 'application/json; charset=utf-8');

        if ($e instanceof NegocioException) {
            $content = $e->getErro()->__toString();
            $response->setContent($content);
            $response->setStatusCode(400);
        } else {
            $message = Utils::getMessageFormated(trans('messages.MSG_001'), $e->getMessage());
            $erro = Erro::newInstance('MSG_001', $message);
            $erro->setStackTrace($e->getTraceAsString());

            $content = $e->getErro()->__toString();
            $response->setContent($content);
            $response->setStatusCode(500);
        }

        return $response;
    }
}
