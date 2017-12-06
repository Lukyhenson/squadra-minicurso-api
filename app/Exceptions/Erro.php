<?php

namespace App\Exceptions;


use App\Util\JsonUtils;

/**
 * Classe de representação de 'Erro'.
 *
 * @package App\Exceptions
 * @author Squadra Tecnologia S/A.
 */
class Erro
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $mensagem;

    /**
     * @var array
     */
    private $parametros;

    /**
     * @var string
     */
    private $stackTrace;

    /**
     * Construtor da classe.
     *
     * @param string $id
     * @param string $mensagem
     * @param array $parametros
     */
    private function __construct($id, $mensagem, array $parametros = null)
    {
        $this->id = $id;
        $this->mensagem = $mensagem;
        $this->parametros = $parametros;
    }

    /**
     * Fábrica de instância de Erro.
     *
     * @param $id
     * @param $mensagem
     * @param mixed $parametros
     */
    public static function newInstance($id, $mensagem, $parametros = null)
    {
        $erro = new Erro($id, $mensagem);

        if ($parametros != null) {
            if (is_array($parametros)) {
                $erro->setParametros($parametros);
            } else {
                $erro->addParametro($parametros);
            }
        }

        return $erro;
    }

    /**
     * @param mixed $parametro
     */
    public function addParametro($parametro)
    {
        if (empty($this->parametros)) {
            $this->parametros = [];
        }

        $this->parametros[] = $parametro;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getMensagem()
    {
        return $this->mensagem;
    }

    /**
     * @param string $mensagem
     */
    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
    }

    /**
     * @return array
     */
    public function getParametros()
    {
        return $this->parametros;
    }

    /**
     * @param array $parametros
     */
    public function setParametros($parametros)
    {
        $this->parametros = $parametros;
    }

    /**
     * @param string $stackTrace
     */
    public function setStackTrace($stackTrace)
    {
        $this->stackTrace = $stackTrace;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return JsonUtils::toJson($this);
    }

}