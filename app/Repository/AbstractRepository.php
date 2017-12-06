<?php

namespace App\Repository;

use App\Entities\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * Class AbstractRepository
 *
 * @package App\Repository
 * @author Squadra Tecnologia S/A.
 */
abstract class AbstractRepository extends EntityRepository
{

    /**
     * Salva a 'Entity' na base de dados.
     *
     * @param Entity $entity
     * @param string $flush
     * @return \App\Entities\Entity|object|array|\Doctrine\Common\Persistence\ObjectManagerAware|boolean
     */
    public function persist(Entity $entity, $flush = true)
    {
        if ($entity->getId() == null) {

            $this->findDetach($entity);
            $this->_em->persist($entity);
        } else {
            $entity = $this->_em->merge($entity);
        }

        if ($flush) {
            $this->_em->flush($entity);
        }

        return $entity;
    }

    /**
     * Salva as 'Entities' em lote na base de dados.
     *
     * @param array $entities
     * @return \App\Entities\Entity[]
     */
    public function persistEmLote($entities)
    {
        $result = array();

        foreach ($entities as $entity) {
            $result[] = $this->persist($entity);
        }

        return $result;
    }

    /**
     * Deleta a 'Entity' da base de dados.
     *
     * @param Entity $entity
     */
    public function delete(Entity $entity)
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }

    /**
     * Deleta as 'Entities' em lote na base de dados.
     *
     * @param array $entities
     */
    public function deleteEmLote($entities)
    {
        foreach ($entities as $entity) {
            $this->delete($entity);
        }
    }

    /**
     * Remove a 'entity' do contexto persistênte.
     *
     * @param Entity $entity
     */
    public function detach(Entity $entity)
    {
        $this->_em->detach($entity);
    }

    /**
     * Recupera as associações 'Detached' para evitar falhas na persistência.
     *
     * @param Entity $entity
     */
    private function findDetach(Entity $entity)
    {
        $class = $this->_em->getClassMetadata(get_class($entity));
        $associationMappings = $class->associationMappings;

        foreach ($associationMappings as $assoc) {

            $relatedEntities = $class->reflFields[$assoc['fieldName']]->getValue($entity);
            $cascade = $assoc['cascade'];

            if ($relatedEntities instanceof \App\Entities\Entity) {

                if ($relatedEntities->getId() != null) {
                    $targetEntity = $assoc['targetEntity'];
                    $newInstance = $this->_em->find($targetEntity, $relatedEntities->getId());

                    $fieldName = $assoc['fieldName'];
                    $class->reflFields[$fieldName]->setValue($entity, $newInstance);
                } elseif (!empty($cascade)) {
                    $this->findDetach($relatedEntities);
                }
            } elseif ($relatedEntities instanceof \Doctrine\Common\Collections\ArrayCollection && !empty($cascade)) {

                foreach ($relatedEntities as $instance) {
                    $this->findDetach($instance);
                }
            }
        }
    }

    /**
     * Retorna o objeto de conexão de banco de dados usado pelo EntityManager.
     *
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection()
    {
        return $this->getEntityManager()->getConnection();
    }
}
