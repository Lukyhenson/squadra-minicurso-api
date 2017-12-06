<?php

namespace App\Util\Json;

use JMS\Serializer\Metadata\PropertyMetadata;
use JMS\Serializer\Naming\PropertyNamingStrategyInterface;

/**
 * Implementação para Serialização de Entidades no formato CamelCase.
 *
 * @package App\Util\Json
 * @author Squadra Tecnologia S/A.
 */
class CustomCamelCaseNamingStrategy implements PropertyNamingStrategyInterface
{

    /**
     * {@inheritdoc}
     *
     * @see \JMS\Serializer\Naming\PropertyNamingStrategyInterface::translateName()
     */
    public function translateName(PropertyMetadata $property)
    {
        return $property->name;
    }
}
