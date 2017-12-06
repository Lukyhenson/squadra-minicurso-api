<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () {
    $application = app()->version();

    $pathLog = storage_path('logs/lumen.log');
    $dataLog = file_get_contents($pathLog);

    $application .= '<br/><br/>Lumen:<br/><br/><pre>';
    $application .= $dataLog;

    return $application;
});

/*
 * |--------------------------------------------------------------------------
 * | Cors options
 * |--------------------------------------------------------------------------
 */

$router->options('{all}',
    function () {
        $response = response()->make('');
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->header('Access-Control-Allow-Headers',
            'Access-Control-Allow-Headers, Authorization, X-Token, X-Requested-With, Content-type');
        $response->header('Access-Control-Max-Age', '3600');

        return $response;
    });

/*
 * |--------------------------------------------------------------------------
 * | TipoContato
 * |--------------------------------------------------------------------------
 */

$router->get('tiposContato', 'TipoContatoController@getTiposContato');

/*
 * |--------------------------------------------------------------------------
 * | Contato
 * |--------------------------------------------------------------------------
 */

$router->post('contatos', 'ContatoController@salvar');

$router->get('contatos', 'ContatoController@getContatos');

$router->get('contatos/{id}', 'ContatoController@getContato');

$router->delete('contatos/{id}', 'ContatoController@excluir');

/*
 * |--------------------------------------------------------------------------
 * | Cliente
 * |--------------------------------------------------------------------------
 */

$router->post('clientes', 'ClienteController@salvar');

$router->get('clientes', 'ClienteController@getClientes');

$router->get('clientes/{id}', 'ClienteController@getCliente');

$router->delete('clientes/{id}', 'ClienteController@excluir');