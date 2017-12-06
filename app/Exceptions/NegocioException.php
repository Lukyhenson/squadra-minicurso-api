<?php

namespace App\Exceptions;

use App\Util\Utils;
use Exception;

/**
 * Classe padrão para exceções de negócio da aplicação.
 *
 * @package App\Exceptions
 * @author Squadra Tecnologia S/A.
 */
class NegocioException extends Exception
{

    /**
     * @var \App\Exceptions\Erro
     */
    private $erro;

    /**
     * Construtor da classe.
     *
     * @param $message
     * @param null $params
     * @param bool $concatParams
     */
    public function __construct($message = null, $params = null, $concatParams = false)
    {
        if ($message != null) {
            $this->message = trans('messages.'.$message);
            $paramsValue = null;

            if (!is_array($params)) {
                $paramsValue = static::getLabelParam($params);
            } else {
                $paramsValue = array_map(function ($param) {
                    return static::getLabelParam($param);
                }, $params);
            }

            $this->message = Utils::getMessageFormated($this->message, $paramsValue, $concatParams);
            $this->erro = Erro::newInstance($message, $this->message, $params);
        }
    }

    /**
     * Fábrica de instância de 'NegocioException'.
     *
     * @return NegocioException
     */
    public static function newInstance()
    {
        return new NegocioException();
    }

    /**
     * Retorna o valor recuperado do repositório caso o parâmetro seja um 'Label'.
     *
     * @param $param
     * @return \Illuminate\Contracts\Translation\Translator|string
     */
    private static function getLabelParam($param)
    {
        $key = 'labels.'.$param;
        $value = trans($key);

        return $value == $key ? $param : $value;
    }

    /**
     * @return Erro
     */
    public function getErro()
    {
        return $this->erro;
    }

}
