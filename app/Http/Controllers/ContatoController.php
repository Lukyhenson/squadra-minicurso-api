<?php

namespace App\Http\Controllers;

use App\Business\ContatoBO;
use App\Entities\Contato;
use Illuminate\Support\Facades\Input;

/**
 * Classe de controle referente a entidade 'Contato'.
 *
 * @package App\Http\Controllers
 * @author Squadra Tecnologia S/A.
 */
class ContatoController extends Controller
{
    /**
     * @var ContatoBO
     */
    private $contatoBO;

    /**
     * Construtor da classe.
     *
     * @param ContatoBO $contatoBO
     */
    public function __construct(ContatoBO $contatoBO)
    {
        $this->contatoBO = $contatoBO;
    }

    /**
     * Salva o 'Contato' na base de dados.
     *
     * @param Contato $contato
     */
    public function salvar()
    {
        $data = Input::all();
        $contato = Contato::newInstance($data);
        $contato = $this->contatoBO->salvar($contato);

        return $this->toJson($contato);
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
        $contato = $this->contatoBO->excluir($id);

        return $this->toJson($contato);
    }

    /**
     * Retorna o 'Contato' conforme o 'id' informado.
     *
     * @param $id
     * @return string
     * @throws \App\Exceptions\NegocioException
     */
    public function getContato($id)
    {
        $contato = $this->contatoBO->getContato($id);

        return $this->toJson($contato);
    }

    /**
     * Retorna o array de 'Contato'.
     *
     * @return string
     */
    public function getContatos()
    {
        $contatos = $this->contatoBO->getContatos();

        return $this->toJson($contatos);
    }

}
