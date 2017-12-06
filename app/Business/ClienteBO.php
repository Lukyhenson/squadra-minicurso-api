<?php

namespace App\Business;

use App\Entities\Cliente;
use App\Exceptions\NegocioException;
use App\Util\Utils;

/**
 * CClasse responsável por encapsular as implementações de negócio referente a entidade Cliente.
 *
 * @package App\Service
 * @author Squadra Tecnologia S/A.
 */
class ClienteBO extends AbstractBO
{

    /**
     * Salva o 'Cliente' conforme as regras especificadas na aplicação.
     *
     * @param Cliente $cliente
     * @return \App\Entities\Cliente
     * @throws NegocioException
     */
    public function salvar(Cliente $cliente)
    {
        $this->validarCamposObrigatorios($cliente);
        $this->validarLimiteMaximoCaracteresCampos($cliente);

        $this->validarEmail($cliente);
        $this->validarCpf($cliente);

        $dataAtual = Utils::getData();

        if (empty($cliente->getId())) {
            $cliente->setDataInclusao($dataAtual);
        } else {
            $id = Utils::getOnlyNumbers($cliente->getId());

            if ($id != $cliente->getId()) {
                throw new NegocioException('MSG_006');
            }

            $vigente = $this->getClienteRepository()->find($id);

            if (empty($vigente)) {
                throw  new NegocioException('MSG_003');
            }

            $cliente->setDataAlteracao($dataAtual);
            $cliente->setDataInclusao($vigente->getDataInclusao());
        }

        return $this->getClienteRepository()->persist($cliente);
    }

    /**
     * Exclui o 'Cliente' conforme o 'id' informado.
     *
     * @param $id
     * @return Cliente|null
     * @throws NegocioException
     */
    public function excluir($id)
    {
        $cliente = $this->getCliente($id);

        if (empty($cliente)) {
            throw  new NegocioException('MSG_009');
        }

        $this->getClienteRepository()->delete($cliente);

        return $cliente;
    }

    /**
     * Retorna o cliente conforme o id informado.
     *
     * @param $id
     * @return null|\App\Entities\Cliente
     */
    public function getCliente($id)
    {
        if (empty($id)) {
            throw  new NegocioException('MSG_002', 'id');
        }

        return $this->getClienteRepository()->find($id);
    }

    /**
     * Retorna o array de 'Clientes'.
     *
     * @return Cliente[]
     */
    public function getClientes()
    {
        return $this->getClienteRepository()->getClientes();
    }

    /**
     * Verifica se o e-mail do cliente é válido.
     *
     * @param Cliente $cliente
     * @throws NegocioException
     */
    private function validarEmail(Cliente $cliente)
    {
        if (!$cliente->isEmailValido()) {
            throw new NegocioException("MSG_004");
        }
    }

    /**
     * Verifica o cpf do cliente é válido.
     *
     * @param Cliente $cliente
     * @throws NegocioException
     */
    private function validarCpf(Cliente $cliente)
    {
        if (!empty($cliente->getCpf())) {
            $cpf = Utils::getOnlyNumbers($cliente->getCpf());

            if (empty($cpf) || $cliente->getCpf() != $cpf || !$cliente->isCpfValido()) {
                throw new NegocioException("MSG_008");
            }
        }
    }

    /**
     * Verifica se os campos de preenchimento 'Obrigatório' foram informados.
     *
     * @param Cliente $cliente
     * @throws NegocioException
     */
    private function validarCamposObrigatorios(Cliente $cliente)
    {
        $campos = [];

        if (empty($cliente->getNome())) {
            $campos[] = 'nome';
        }

        if (empty($cliente->getEmail())) {
            $campos[] = 'email';
        }

        if (!empty($campos)) {
            throw new NegocioException('MSG_002', $campos, true);
        }
    }

    /**
     * Verifica se algum campo do 'Cliente' excedeu o limite máximo de caracteres permitidos.
     *
     * @param Cliente $cliente
     * @throws NegocioException
     */
    private function validarLimiteMaximoCaracteresCampos(Cliente $cliente)
    {
        $campos = [];

        if (Utils::isMaxlength(Cliente::class, 'nome', $cliente)) {
            $campos[] = 'nome';
        }

        if (Utils::isMaxlength(Cliente::class, 'email', $cliente)) {
            $campos[] = 'email';
        }

        if (Utils::isMaxlength(Cliente::class, 'cpf', $cliente)) {
            $campos[] = 'cpf';
        }

        if (!empty($campos)) {
            throw new NegocioException('MSG_005', $campos, true);
        }
    }

    /**
     * Retorna a instância de 'ClienteRepository'.
     *
     * @return \App\Repository\ClienteRepository
     */
    private function getClienteRepository()
    {
        return $this->getRepository(Cliente::class);
    }
}
