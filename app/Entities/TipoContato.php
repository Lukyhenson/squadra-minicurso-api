<?php

namespace App\Entities;

use App\Util\Utils;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe de representação de Tipo de Contato.
 *
 * @ORM\Entity(repositoryClass="App\Repository\TipoContatoRepository")
 * @ORM\Table(name="tipo_contato")
 *
 * @package App\Entities
 * @author Squadra Tecnologia S/A.
 */
class TipoContato extends Entity
{

    /**
     * @ORM\Id
     * @ORM\Column(name="id_tipo_contato", type="integer")
     *
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(name="descricao", type="string", length=150, nullable=false)
     *
     * @var string
     */
    private $descricao;

    /**
     * Fábrica de instância de TipoContato.
     *
     * @param array $data
     * @return TipoContato
     */
    public static function newInstance(array $data = null)
    {
        $tipoContato = new TipoContato();

        if ($data != null) {
            $id = Utils::getValue('id', $data);
            $tipoContato->setId($id);

            $descricao = Utils::getValue('descricao', $data);
            $tipoContato->setDescricao($descricao);
        }

        return $tipoContato;
    }

    /**
     * {@inheritdoc}
     *
     * @see \App\Entities\::getId()
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

}
