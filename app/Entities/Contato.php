<?php

namespace App\Entities;

use App\Util\Utils;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe de representação de Contato.
 *
 * @ORM\Entity(repositoryClass="App\Repository\ContatoRepository")
 * @ORM\Table(name="contato")
 *
 * @package App\Entities
 * @author Squadra Tecnologia S/A.
 */
class Contato extends Entity
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\Column(name="id_contato", type="integer")
     * @ORM\SequenceGenerator(sequenceName="contato_seq", initialValue=1, allocationSize=1)
     *
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(name="nome", type="string", length=120, nullable=false)
     *
     * @var string
     */
    private $nome;

    /**
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     *
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(name="apelido", type="string", length=100, nullable=true)
     *
     * @var string
     */
    private $apelido;

    /**
     * @ORM\Column(name="site", type="string", length=150, nullable=true)
     *
     * @var string
     */
    private $site;

    /**
     * @ORM\Column(name="numero", type="string", length=11, nullable=false)
     *
     * @var string
     */
    private $numero;

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
     * @ORM\ManyToOne(targetEntity="App\Entities\TipoContato")
     * @ORM\JoinColumn(name="id_tipo_contato", referencedColumnName="id_tipo_contato", nullable=false)
     *
     * @var \App\Entities\TipoContato
     */
    private $tipoContato;

    /**
     * @ORM\Column(name="st_ativo", type="boolean", nullable=false)
     *
     * @var boolean
     */
    private $ativo;

    /**
     * Fábrica de instância de Contato.
     *
     * @param array $data
     * @return Contato
     */
    public static function newInstance(array $data = null)
    {
        $contato = new Contato();

        if ($data != null) {
            $id = Utils::getValue('id', $data);
            $contato->setId($id);

            $nome = Utils::getValue('nome', $data);
            $contato->setNome($nome);

            $email = Utils::getValue('email', $data);
            $contato->setEmail($email);

            $apelido = Utils::getValue('apelido', $data);
            $contato->setApelido($apelido);

            $site = Utils::getValue('site', $data);
            $contato->setSite($site);

            $numero = Utils::getValue('numero', $data);
            $numero = Utils::getOnlyNumbers($numero);
            $contato->setNumero($numero);

            $tipoContato = Utils::getValue('tipoContato', $data);
            $tipoContato = TipoContato::newInstance($tipoContato);

            if (!empty($tipoContato->getId())) {
                $contato->setTipoContato($tipoContato);
            }
        }

        return $contato;
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
    public function getApelido()
    {
        return $this->apelido;
    }

    /**
     * @param string $apelido
     */
    public function setApelido($apelido)
    {
        $this->apelido = $apelido;
    }

    /**
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * @param string $site
     */
    public function setSite($site)
    {
        $this->site = $site;
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

    /**
     * @return TipoContato
     */
    public function getTipoContato()
    {
        return $this->tipoContato;
    }

    /**
     * @param TipoContato $tipoContato
     */
    public function setTipoContato(TipoContato $tipoContato)
    {
        $this->tipoContato = $tipoContato;
    }

    /**
     * @return bool
     */
    public function isAtivo()
    {
        return $this->ativo;
    }

    /**
     * @param bool $ativo
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    /**
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

}