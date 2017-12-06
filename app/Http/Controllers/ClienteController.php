<?php

namespace App\Http\Controllers;

use App\Business\ClienteBO;
use App\Entities\Cliente;
use Illuminate\Support\Facades\Input;


/**
 * Classe de controle referente a entidade 'Cliente'.
 *
 * @package App\Http\Controllers
 * @author Squadra Tecnologia S/A.
 */
class ClienteController extends Controller
{

    /**
     *
     * @var ClienteBO
     */
    private $clienteBO;

    /**
     * Construtor da classe.
     *
     * @param ClienteBO $clienteBO
     */
    public function __construct(ClienteBO $clienteBO)
    {
        $this->clienteBO = $clienteBO;
    }


    /**
     * Salva o Cliente na base de dados.
     *
     * @return string
     * @throws \App\Exceptions\NegocioException
     */
    public function salvar()
    {
        $data = Input::all();
        $cliente = Cliente::newInstance($data);
        $cliente = $this->clienteBO->salvar($cliente);

        return $this->toJson($cliente);
    }

    /**
     * Exclui o 'Contato' conforme o 'id' informado.
     *
     * @param $id
     * @return string
     * @throws \App\Exceptions\NegocioException
     */
    public function excluir($id)
    {
        $cliente = $this->clienteBO->excluir($id);

        return $this->toJson($cliente);
    }

    /**
     * Retorna o 'Cliente' conforme o 'id' informado.
     *
     * @param $id
     * @return string
     * @throws \App\Exceptions\NegocioException
     */
    public function getCliente($id)
    {
        $cliente = $this->clienteBO->getCliente($id);

        return $this->toJson($cliente);
    }

    /**
     * Retorna o array de 'Cliente'.
     *
     * @return string
     */
    public function getClientes()
    {
        $clientes = $this->clienteBO->getClientes();

        return $this->toJson($clientes);
    }

}
