<?php

namespace App\Util;

use App\Config\Constants;

/**
 * Classe utilitária da aplicação.
 *
 * @package App\Util
 * @author Squadra Tecnologia S/A.
 */
class Utils
{
    const TIMEZONE_PADRAO = "America/Sao_Paulo";

    /**
     * Construtor privado para garantir o Singleton.
     */
    private function __construct()
    {
    }

    /**
     * Retorna a mensagem ($message) formatada considerando os parâmetros ($params).
     * Caso o atributo '$concatParams' seja verdadeiro os parâmetros ($params), serão
     * concatenados com virgula ','.
     *
     * @param string $message
     * @param mixed $params
     * @param boolean $concatParams
     */
    public static function getMessageFormated($message, $params = null, $concatParams = false)
    {
        if ($params == null) {
            return $message;
        }

        $value = null;
        $formatter = new \MessageFormatter('pt_br', $message);

        if (!is_array($params)) {
            $value = $params;
        } elseif ($concatParams) {
            $value = implode(", ", $params);
        }

        if ($value != null) {
            $params = array();
            $params[] = $value;
        }

        return $formatter->format($params);
    }

    /**
     * Retorna o valor existente no array ($data) conforme o índice ($index).
     * Obs: Caso o índice não exista o retorno será 'nulo'.
     *
     * @param string $index
     * @param array $data
     * @param mixed $return
     * @return mixed
     */
    public static function getValue($index, $data, $return = null)
    {
        return isset($index) && isset($data) && array_key_exists($index, $data) ? $data[$index] : $return;
    }

    /**
     * Retorna os números conforme o valor informado.
     *
     * @param string $value
     * @return mixed
     */
    public static function getOnlyNumbers($value)
    {
        $numbers = null;

        if (!empty($value)) {
            $numbers = preg_replace('/[^0-9]/', '', $value);
            $numbers = count($numbers) == 0 ? null : $numbers;
        }

        return $numbers;
    }

    /**
     * Retorna a instãncia de DateTime com a data corrente.
     *
     * @return \DateTime
     */
    public static function getData()
    {
        $data = new \DateTime();
        $data->setTimezone(new \DateTimeZone(static::TIMEZONE_PADRAO));

        return $data;
    }

    /**
     * Retorna a instância de DateTime considerando hora zero.
     * Obs: Caso o parâmetro informado seja null, o retorno será a data atual.
     *
     * @param \DateTime $value
     * @return \\DateTime|DateTime
     */
    public static function getDataHoraZero(\DateTime $value = null)
    {
        if ($value == null) {
            $data = static::getData();
        } else {
            $data = clone $value;
        }
        date_time_set($data, 0, 0, 0);

        return $data;
    }

    /**
     * Retorna a instância de DateTime considerando o 'valor' informado.
     *
     * @param string $value
     * @param string $format
     * @param string $timezone
     * @throws \InvalidArgumentException
     * @return null
     */
    public static function getDataToString($value, $format = "Y-m-d\TH:i:s+", $timezone = 'UTC')
    {
        $data = null;

        if (!empty($value)) {
            $data = \DateTime::createFromFormat($format, $value, new \DateTimeZone($timezone));

            if (!$data) {
                $msg = 'Não foi possível converter o valor "'.$value;
                $msg .= '", para o formato esperado: "'.$format.'".';

                throw new \InvalidArgumentException($msg);
            }

            $data->setTimezone(new \DateTimeZone(static::TIMEZONE_PADRAO));
        }

        return $data;
    }

    /**
     * Valida o cpf informado, retornando 'true' quando o mesmo for válido.
     *
     * @param integer $cpf
     * @return boolean
     */
    public static function isCpfValido($cpf)
    {
        $cpfValido = false;
        $cpfNumeroValido = is_numeric($cpf) && strlen($cpf) == 11;

        $isCpfValidoZeroUm = $cpf != '00000000000' && $cpf != '11111111111';
        $isCpfValidoDoisTres = $cpf != '22222222222' && $cpf != '33333333333';

        $isCpfValidoMenorTres = $isCpfValidoZeroUm && $isCpfValidoDoisTres;

        $isCpfValidoSeteOitoNove = $cpf != '77777777777' && $cpf != '88888888888' && $cpf != '99999999999';
        $isCpfValidoQuatroCincoSeis = $cpf != '44444444444' && $cpf != '55555555555' && $cpf != '66666666666';

        $cpfSemRepeticoes = $isCpfValidoMenorTres && $isCpfValidoSeteOitoNove && $isCpfValidoQuatroCincoSeis;

        if ($cpfNumeroValido && $cpfSemRepeticoes) {

            $digitoVerificador = substr($cpf, 9, 2);

            for ($i = 0; $i <= 8; $i++) {
                $digito[$i] = substr($cpf, $i, 1);
            }

            // Calcula o valor do 10º dígito de verificação.
            $posicao = 10;
            $soma = 0;

            for ($i = 0; $i <= 8; $i++) {
                $soma = $soma + $digito[$i] * $posicao;
                $posicao = $posicao - 1;
            }

            $digito[9] = $soma % 11;

            if ($digito[9] < 2) {
                $digito[9] = 0;
            } else {
                $digito[9] = 11 - $digito[9];
            }

            // Calcula o valor do 10º dígito de verificação.
            $posicao = 11;
            $soma = 0;

            for ($i = 0; $i <= 9; $i++) {
                $soma = $soma + $digito[$i] * $posicao;
                $posicao = $posicao - 1;
            }

            $digito[10] = $soma % 11;

            if ($digito[10] < 2) {
                $digito[10] = 0;
            } else {
                $digito[10] = 11 - $digito[10];
            }

            $resultado = $digito[9] * 10 + $digito[10];
            $cpfValido = $digitoVerificador == $resultado;
        }

        return $cpfValido;
    }

    /**
     * Valida o cnpj informado, retornando 'true' quando o mesmo for válido.
     *
     * @param string $cnpj
     * @return boolean
     */
    public static function isCnpjValido($cnpj)
    {
        $cnpjValido = false;
        $cnpjNumeroValido = is_numeric($cnpj) && strlen($cnpj) == 14;

        $isCnpjValidoZeroUm = $cnpj != '00000000000000' && $cnpj != '11111111111111';
        $isCnpjValidoDoisTres = $cnpj != '22222222222222' && $cnpj != '33333333333333';

        $isCnpjValidoMenorTres = $isCnpjValidoZeroUm && $isCnpjValidoDoisTres;

        $isCnpjValidoSeteOitoNove = $cnpj != '77777777777777' && $cnpj != '88888888888888' && $cnpj != '99999999999999';
        $isCnpjValidoQuatroCincoSeis = $cnpj != '44444444444444' && $cnpj != '55555555555555' &&
            $cnpj != '66666666666666';

        $cnpjSemRepeticoes = $isCnpjValidoMenorTres && $isCnpjValidoSeteOitoNove && $isCnpjValidoQuatroCincoSeis;

        if ($cnpjNumeroValido && $cnpjSemRepeticoes) {

            $soma = 0;
            $soma += ($cnpj[0] * 5);
            $soma += ($cnpj[1] * 4);
            $soma += ($cnpj[2] * 3);
            $soma += ($cnpj[3] * 2);
            $soma += ($cnpj[4] * 9);
            $soma += ($cnpj[5] * 8);
            $soma += ($cnpj[6] * 7);
            $soma += ($cnpj[7] * 6);
            $soma += ($cnpj[8] * 5);
            $soma += ($cnpj[9] * 4);
            $soma += ($cnpj[10] * 3);
            $soma += ($cnpj[11] * 2);

            $d1 = $soma % 11;
            $d1 = $d1 < 2 ? 0 : 11 - $d1;

            $soma = 0;
            $soma += ($cnpj[0] * 6);
            $soma += ($cnpj[1] * 5);
            $soma += ($cnpj[2] * 4);
            $soma += ($cnpj[3] * 3);
            $soma += ($cnpj[4] * 2);
            $soma += ($cnpj[5] * 9);
            $soma += ($cnpj[6] * 8);
            $soma += ($cnpj[7] * 7);
            $soma += ($cnpj[8] * 6);
            $soma += ($cnpj[9] * 5);
            $soma += ($cnpj[10] * 4);
            $soma += ($cnpj[11] * 3);
            $soma += ($cnpj[12] * 2);

            $d2 = $soma % 11;
            $d2 = $d2 < 2 ? 0 : 11 - $d2;

            $cnpjValido = $cnpj[12] == $d1 && $cnpj[13] == $d2;
        }

        return $cnpjValido;
    }

    /**
     * Valida o e-mail informado, retornando 'true' quando o mesmo for válido.
     *
     * @param string $email
     * @return boolean
     */
    public static function isEmailValido($email)
    {
        $ereg = "/^(([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}){0,1}$/";

        return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match($ereg, $email);
    }

    /**
     * Verifica se a string informada excedeu o limite máximo de caracteres permitidos.
     *
     * @param $className
     * @param $property
     * @param $object
     * @return bool
     */
    public static function isMaxlength($className, $property, $object)
    {
        $maxlength = false;

        $reflector = new \ReflectionProperty($className, $property);
        $doc = $reflector->getDocComment();
        $index = strpos($doc, 'length');

        if ($index != false) {
            $length = substr($doc, $index + 7, 3);
            $length = Utils::getOnlyNumbers($length);

            $reflector->setAccessible(true);
            $value = $reflector->getValue($object);

            $maxlength = !empty($value) && strlen($value) > $length;
        }

        return $maxlength;
    }
}
