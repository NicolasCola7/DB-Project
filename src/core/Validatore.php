<?php

namespace core;

/**
 * Classe per validare input dell'utente
 */
class Validatore {
    
    /**
     * Verifica se una stringa è un'email valida.
     *
     * @param string $email L'indirizzo email da verificare.
     * @return bool True se l'email è valida, False altrimenti.
     */
    static function isEmail($email) {
        $email = trim($email);

        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Controlla se una stringa ha una lunghezza compresa tra un minimo e un massimo.
     *
     * @param string $val La stringa da verificare.
     * @param int $min Lunghezza minima consentita (default: 1).
     * @param int $max Lunghezza massima consentita (default: infinito).
     * @return bool True se la stringa è valida, False altrimenti.
     */
    static function isString($val, $min = 1, $max = INF) {
        $val = trim($val);

        return strlen($val) >= $min && strlen($val) <= $max;
    }

    /**
     * Verifica se un valore è un numero compreso tra un minimo e un massimo.
     *
     * @param mixed $num Il valore da verificare.
     * @param float|int $min Valore minimo consentito (default: 1).
     * @param float|int $max Valore massimo consentito (default: infinito).
     * @return bool True se il valore è un numero valido e rientra nei limiti, False altrimenti.
     */
    static function isNumber($num, $min = 1, $max = INF) {
        $num = trim($num);

        return is_numeric($num) && $num >= $min && $num <= $max;
    }

    /**
     * Controlla se una data è valida nel formato "gg/mm/aaaa".
     *
     * @param string $data La data da verificare.
     * @return bool True se la data è valida, False altrimenti.
     */
    static function isDate($data) {
        $data = trim($data);
        $data = explode('/', $data);
        
        if (count($data) == 3) 
            return checkdate($data[1], $data[0], $data[2]);
        
        return false;
    }
}