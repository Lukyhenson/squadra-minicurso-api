<?php

namespace App\Http\Controllers;

use App\Business\TipoContatoBO;
use App\Entities\TipoContato;

/**
 * Classe de controle referente a entidade 'TipoContato'.
 *
 * @package App\Http\Controllers
 * @author Squadra Tecnologia S/A.
 */
class TipoContatoController extends Controller
{
    /**
     * @var TipoContato
     */
    private $tipoContatoBO;

    /**
     * Construtor da classe.
     *
     * @param TipoContatoBO $tipoContatoBO
     */
    public function __construct(TipoContatoBO $tipoContatoBO)
    {
        $this->tipoContatoBO = $tipoContatoBO;
    }

    /**
     * Retorna o array de 'TipoContato'.
     *
     * @return string
     */
    public function getTiposContato()
    {
        $tiposContato = $this->tipoContatoBO->getTiposContato();

        return $this->toJson($tiposContato);
    }
}
