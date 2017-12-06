<?php

namespace App\Repository;

/**
 * Repositório responsável por encapsular as implementações de persistência da entidade TipoContato.
 *
 * @package App\Repository
 * @author Squadra Tecnologia S/A.
 */
class TipoContatoRepository extends AbstractRepository
{
    /**
     * Finds all entities in the repository.
     *
     * @return array The entities.
     */
    public function findAll()
    {
        $query = $this->createQueryBuilder("tipoContato");
        $query->orderBy("tipoContato.descricao");

        return $query->getQuery()->getResult();
    }
}
