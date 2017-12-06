<?php

namespace App\Repository;

use Doctrine\ORM\NoResultException;

/**
 * Repositório responsável por encapsular as implementações de persistência da entidade Contato.
 *
 * @package App\Repository
 * @author Squadra Tecnologia S/A.
 */
class ContatoRepository extends AbstractRepository
{

    /**
     * Finds all entities in the repository.
     *
     * @return array
     */
    public function findAll()
    {
        $query = $this->createQueryBuilder("contato");
        $query->leftJoin("contato.tipoContato", "tipoContato")->addSelect("tipoContato");
        $query->orderBy("contato.nome");

        return $query->getQuery()->getResult();
    }

    /**
     * Retorna a instância do 'Contato' conforme o 'id' informado.
     *
     * @param $id
     * @return \App\Entities\Contato|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findFetch($id)
    {
        try {
            $query = $this->createQueryBuilder("contato");
            $query->innerJoin("contato.tipoContato", "tipoContato")->addSelect("tipoContato");

            $query->where("contato.id = :id");
            $query->setParameter("id", $id);

            return $query->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }
}