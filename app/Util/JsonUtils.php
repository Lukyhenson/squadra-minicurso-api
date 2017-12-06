<?php

namespace App\Util;

use App\Util\Json\CustomCamelCaseNamingStrategy;
use App\Util\Json\CustomDateTimeHandler;
use App\Util\Json\ExclusionProxyStrategy;
use JMS\Serializer\Handler\ArrayCollectionHandler;
use JMS\Serializer\Handler\DateHandler;
use JMS\Serializer\Handler\HandlerRegistry;
use JMS\Serializer\Handler\StdClassHandler;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;

/**
 * Classe utilitária da aplicação para facilitar a manipulação de dados no formato JSON.
 *
 * @package App\Util
 * @author Squadra Tecnologia S/A.
 */
class JsonUtils
{

    /**
     * Construtor privado para garantir o Singleton.
     */
    private function __construct()
    {
    }

    /**
     * Retorna o 'Objeto' serializado em 'json'.
     *
     * @param unknown $object
     * @return string
     */
    public static function toJson($object)
    {
        $context = new SerializationContext();
        $context->addExclusionStrategy(new ExclusionProxyStrategy());

        $builder = SerializerBuilder::create()->setPropertyNamingStrategy(new CustomCamelCaseNamingStrategy());

        $builder->configureHandlers(
            function (HandlerRegistry $registry) {
                $registry->registerSubscribingHandler(new DateHandler());
                $registry->registerSubscribingHandler(new StdClassHandler());
                $registry->registerSubscribingHandler(new ArrayCollectionHandler());
            });

        return $builder->build()->serialize($object, 'json', $context);
    }
}
