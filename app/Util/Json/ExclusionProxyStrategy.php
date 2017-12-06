<?php

namespace App\Util\Json;

use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Proxy\Proxy;
use JMS\Serializer\Context;
use JMS\Serializer\Exclusion\ExclusionStrategyInterface;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\Metadata\PropertyMetadata;
use JMS\Serializer\SerializationContext;

/**
 * Implementação para Serialização de Entidades ignorando atributos 'Lazy'.
 *
 * @package App\Util\Json
 * @author Squadra Tecnologia S/A.
 */
class ExclusionProxyStrategy implements ExclusionStrategyInterface
{

    /**
     * {@inheritdoc}
     *
     * @see \JMS\Serializer\Exclusion\ExclusionStrategyInterface::shouldSkipClass()
     */
    public function shouldSkipClass(ClassMetadata $metadata, Context $context)
    {
    }

    /**
     * {@inheritdoc}
     *
     * @see \JMS\Serializer\Exclusion\ExclusionStrategyInterface::shouldSkipProperty()
     */
    public function shouldSkipProperty(PropertyMetadata $property, Context $context)
    {
        if ($context instanceof SerializationContext) {
            $vistingSet = $context->getVisitingSet();

            // iterate over object to get last object
            foreach ($vistingSet as $visting) {
                $currentObject = $visting;
            }

            $propertyValue = $property->getValue($currentObject);

            // skip not loaded one association
            if ($propertyValue instanceof Proxy && !$propertyValue->__isInitialized__) {
                return true;
            }

            // skip not loaded many association
            if ($propertyValue instanceof PersistentCollection && !$propertyValue->isInitialized()) {
                return true;
            }
        }

        return false;
    }
}
