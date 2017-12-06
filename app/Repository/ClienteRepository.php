<?php

namespace App\Repository;

/**
 * Implementação de 'Repository' referente a entidade 'Cliente'.
 *
 * @package App\Repository
 * @author Squadra Tecnologia S/A.
 */
class ClienteRepository extends AbstractRepository
{

    /**
     * Retorna o array de 'Cliente'.
     *
     * @return array
     */
    public function getClientes()
    {
        $query = $this->createQueryBuilder('cliente');
        $query->orderBy('cliente.nome');

        return $query->getQuery()->getResult();
    }
}