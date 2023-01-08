<?php

namespace App\Helpers;

class HelperCPF
{
    private function __construct()
    {
        // Construtor privado para evitar que a classe seja instanciada diretamente
    }

    /**
     * Verifica se o CPF é válido.
     *
     * @param string $cpf
     * @return boolean 'Retorna true se o CPF for válido'
     */
    public static function verify(string $cpf)
    {
        // Primeira parte da validação do CPF
        $numbers = [];
        for ($i = 0, $j = 10; $i < 9; $i++, $j--) {
            $digit = $cpf[$i];

            array_push($numbers, $digit * $j);
        }

        $resultFirstVerification = (array_sum($numbers) * 10) % 11;

        if ($resultFirstVerification != $cpf[9]) {
            return false;
        }

        // Segunda parte da validação do CPF
        $numbers = [];
        for ($i = 0, $j = 11; $i < 10; $i++, $j--) {
            $digit = $cpf[$i];

            array_push($numbers, $digit * $j);
        }

        $resultSecondVerification = (array_sum($numbers) * 10) % 11;

        if ($resultSecondVerification != $cpf[10]) {
            return false;
        }

        return true;
    }
}
