<?php

namespace App\Business;

use App\Entities\Contato;
use App\Exceptions\NegocioException;
use App\Util\Utils;

/**
 * Classe responsável por encapsular as implementações de negócio referente a entidade Contato.
 *
 * @package App\Business
 * @author Squadra Tecnologia S/A.
 */
class ContatoBO extends AbstractBO
{

    const NUMERO_MAXIMO = 11;

    const NUMERO_MINIMO = 10;

    /**
     * Salva o 'Contato' na base de dados.
     *
     * @param Contato $contato
     */
    public function salvar(Contato $contato)
    {
        $this->validarCamposObrigatorios($contato);
        $this->validarLimiteMaximoCaracteresCampos($contato);

        if (!empty($contato->getEmail()) && !Utils::isEmailValido($contato->getEmail())) {
            throw new NegocioException('MSG_004');
        }

        $this->validarNumeroTelefone($contato);

        $dataAtual = Utils::getData();

        if (empty($contato->getId())) {
            $contato->setAtivo(true);
            $contato->setDataInclusao($dataAtual);
        } else {
            $id = Utils::getOnlyNumbers($contato->getId());

            if ($id != $contato->getId()) {
                throw new NegocioException('MSG_006');
            }

            $vigente = $this->getContatoRepository()->find($id);

            if (empty($vigente)) {
                throw  new NegocioException('MSG_003');
            }

            $contato->setDataAlteracao($dataAtual);
            $contato->setAtivo($vigente->isAtivo());
            $contato->setDataInclusao($vigente->getDataInclusao());
        }

        return $this->getContatoRepository()->persist($contato);
    }

    /**
     * Exclui o 'Contato' conforme o 'id' informado.
     *
     * @param $id
     * @return Contato|null
     * @throws NegocioException
     */
    public function excluir($id)
    {
        $contato = $this->getContato($id);

        if (empty($contato)) {
            throw  new NegocioException('MSG_003');
        }

        $this->getContatoRepository()->delete($contato);

        return $contato;
    }

    /**
     * Retorna o 'Contato' conforme o 'id' informado.
     *
     * @param $id
     * @return null|\App\Entities\Contato
     */
    public function getContato($id)
    {
        if (empty($id)) {
            throw  new NegocioException('MSG_002', 'id');
        }

        return $this->getContatoRepository()->findFetch($id);
    }

    /**
     * Retorna o array de 'Contatos'.
     *
     * @return array
     */
    public function getContatos()
    {
        return $this->getContatoRepository()->findAll();
    }

    /**
     * Verifica se o Número informado é válido.
     *
     * @param Contato $contato
     * @throws NegocioException
     */
    public function validarNumeroTelefone(Contato $contato)
    {
        $length = strlen((string)$contato->getNumero());

        if ($length > static::NUMERO_MAXIMO || $length < static::NUMERO_MINIMO) {
            throw new NegocioException('MSG_007');
        }
    }

    /**
     * Verifica se os campos obrigatórios do 'Contato' foram preechidos.
     *
     * @param Contato $contato
     * @throws NegocioException
     */
    private function validarCamposObrigatorios(Contato $contato)
    {
        $campos = [];

        if (empty($contato->getNome())) {
            $campos[] = 'nome';
        }

        if (empty($contato->getNumero())) {
            $campos[] = 'numero';
        }

        if (!empty($campos)) {
            throw new NegocioException('MSG_002', $campos, true);
        }
    }

    /**
     * Verifica se algum campo do Contato excedeu o limite máximo de caracteres permitidos.
     *
     * @param Contato $contato
     * @throws NegocioException
     */
    private function validarLimiteMaximoCaracteresCampos(Contato $contato)
    {
        $campos = [];

        if (Utils::isMaxlength(Contato::class, 'nome', $contato)) {
            $campos[] = 'nome';
        }

        if (Utils::isMaxlength(Contato::class, 'email', $contato)) {
            $campos[] = 'email';
        }

        if (Utils::isMaxlength(Contato::class, 'apelido', $contato)) {
            $campos[] = 'apelido';
        }

        if (Utils::isMaxlength(Contato::class, 'site', $contato)) {
            $campos[] = 'site';
        }

        if (!empty($campos)) {
            throw new NegocioException('MSG_005', $campos, true);
        }
    }

    /**
     * @return \App\Repository\ContatoRepository
     */
    private function getContatoRepository()
    {
        return $this->getRepository(Contato::class);
    }

}