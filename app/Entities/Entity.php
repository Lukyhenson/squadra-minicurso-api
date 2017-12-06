<?php

namespace App\Entities;

use App\Util\JsonUtils;

/**
 * Classe abstrata Entity.
 *
 * @package App\Entities
 * @author Squadra Tecnologia S/A.
 */
abstract class Entity
{

    /**
     * Retorna o 'id' da 'Entidade'.
     *
     * @return integer
     */
    abstract public function getId();

    /**
     *
     * @return string
     */
    public function __toString()
    {
        return JsonUtils::toJson($this);
    }
}
