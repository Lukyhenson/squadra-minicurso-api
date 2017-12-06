<?php

namespace App\Entities;

use App\Util\Util;
use App\Util\Utils;
use Doctrine\ORM\Mapping as ORM;

/**
 * Representa um determinado 'Cliente'.
 *
 * @ORM\Entity(repositoryClass="App\Repository\ClienteRepository")
 * @ORM\Table(name="cliente")
 *
 * @package App\Entities
 * @author Squadra Tecnologia S/A.
 */
class Cliente extends Entity
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\Column(name="id_cliente", type="integer")
     * @ORM\SequenceGenerator(sequenceName="cliente_seq", initialValue=1, allocationSize=1)
     *
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="nome", length=120)
     *
     * @var string
     */
    private $nome;

    /**
     * @ORM\Column(type="string", name="email", length=100)
     *
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="string", name="cpf", length=11)
     *
     * @var string
     */
    private $cpf;

    /**
     * @ORM\Column(name="dt_inclusao", type="datetime", nullable=false)
     *
     * @var \DateTime
     */
    private $dataInclusao;

    /**
     * @ORM\Column(name="dt_alteracao", type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $dataAlteracao;

    /**
     * Retorna um novo cliente conforme os valores fornecidos.
     *
     * @param array $data
     * @return \App\Entities\Cliente
     */
    public static function newInstance($data = null)
    {
        $cliente = new Cliente();

        if ($data != null) {
            $id = Utils::getValue('id', $data);
            $cliente->setId($id);

            $nome = Utils::getValue("nome", $data);
            $cliente->setNome($nome);

            $email = Utils::getValue("email", $data);
            $cliente->setEmail($email);

            $cpf = Utils::getValue("cpf", $data);
            $cliente->setCpf($cpf);
        }

        return $cliente;
    }

    /**
     * Verifica se o email informado é válido.
     *
     * @return boolean
     */
    public function isEmailValido()
    {
        return Utils::isEmailValido($this->email);
    }

    /**
     * Verifica se o cpf informado é válido.
     *
     * @return boolean
     */
    public function isCpfValido()
    {
        return Utils::isCpfValido($this->cpf);
    }

    /**
     * {@inheritdoc}
     *
     * @see \App\Entities\Entity::getId()
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
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @return \DateTime
     */
    public function getDataInclusao()
    {
        return $this->dataInclusao;
    }

    /**
     * @param \DateTime $dataInclusao
     */
    public function setDataInclusao($dataInclusao)
    {
        $this->dataInclusao = $dataInclusao;
    }

    /**
     * @return \DateTime
     */
    public function getDataAlteracao()
    {
        return $this->dataAlteracao;
    }

    /**
     * @param \DateTime $dataAlteracao
     */
    public function setDataAlteracao($dataAlteracao)
    {
        $this->dataAlteracao = $dataAlteracao;
    }

}
