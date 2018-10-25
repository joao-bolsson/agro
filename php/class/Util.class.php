<?php
/**
 * @author João Bolsson (joaovictorbolsson@gmail.com)
 * @version 2018, Oct 25.
 */

class Util {

    /**
     * @return string A random password.
     */
    public static function randPassword(): string {
        $retorno = "";

        // tamanho da nova senha
        $tam = 8;
        // caracteres que serão utilizados
        $min = 'abcdefghijklmnopqrstuvwxyz';
        $mai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';

        $caracteres = str_split($min . $mai . $num . $simb);
        for ($i = 0; $i < $tam; $i++) {
            $rand = mt_rand(0, count($caracteres) - 1);
            $retorno .= $caracteres[$rand];
        }
        return $retorno;
    }

    /**
     * Formats the given date (in d/m/Y format) to database date format (Y-m-d)
     *
     * @param string $data Given date.
     * @return string Date formatted.
     */
    public static function dateFormat(string $data): string {
        $array_data = explode('/', $data);

        if (count($array_data) == 3) {
            $retorno = "";
            // Y-m-d
            $retorno .= $array_data[2] . '-' . $array_data[1] . '-' . $array_data[0];
            return $retorno;
        } else {
            return $data;
        }
    }


}