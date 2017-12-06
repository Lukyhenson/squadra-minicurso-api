<?php

namespace App\Business;

use App\Entities\TipoContato;

/**
 * Classe responsável por encapsular as implementações de negócio referente a entidade TipoContato.
 *
 * @package App\Business
 * @author Squadra Tecnologia S/A.
 */
class TipoContatoBO extends AbstractBO
{

    /**
     * Retorna o array de 'TipoContato'.
     *
     * @return array
     */
    public function getTiposContato()
    {
        return $this->getTipoContatoRepository()->findAll();
    }

    /**
     * @return \App\Repository\TipoContatoRepository
     */
    private function getTipoContatoRepository()
    {
        return $this->getRepository(TipoContato::class);
    }

}
