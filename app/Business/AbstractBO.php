<?php

namespace App\Business;

use App\Entities\Processo;
use App\Util\Email;

/**
 * Class AbstractBO
 *
 * @package App\Business
 * @author Squadra Tecnologia S/A.
 */
abstract class AbstractBO
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Retorna a instância do 'Repository' conforme o nome da 'entity'.
     *
     * @param string $entityName
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepository($entityName)
    {
        return $this->getEntityManager()->getRepository($entityName);
    }

    /**
     * Inicia uma transação suspendendo o modo de confirmação automática.
     */
    protected function beginTransaction()
    {
        $this->getEntityManager()->beginTransaction();
    }

    /**
     * Confirma a transação atual.
     */
    protected function commitTransaction()
    {
        $this->getEntityManager()->commit();
    }

    /**
     * Clears the EntityManager.
     */
    protected function clearEntityTransaction()
    {
        $this->getEntityManager()->clear();
    }

    /**
     * Cancela quaisquer alterações de banco de dados feitas durante a transação atual.
     */
    protected function rollbackTransaction()
    {
        $this->getEntityManager()->rollback();
    }

    /**
     * Retorna a instância de EntityManager.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    private function getEntityManager()
    {
        if (empty($this->entityManager)) {
            $this->entityManager = app()->make('em');
        }

        return $this->entityManager;
    }
}
