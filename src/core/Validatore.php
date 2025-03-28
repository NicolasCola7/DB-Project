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
    
        // Verifica che sia una stringa, che la sua lunghezza sia nei limiti richiesti e che non sia composta solo da numeri
        if (!is_string($val) || strlen($val) < $min || strlen($val) > $max || ctype_digit($val)) {
            return false;
        }
    
        // Verifica che non contenga i caratteri non consentiti: /, \, :, *, ?, ", <, >, |
        if (preg_match('/[\/\\\\:*?"<>|]/', $val)) {
            return false;
        }
        
        return true;
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

        return preg_match('/^-?\d+([.,]\d+)?$/', $num) && $num >= $min && $num <= $max;
    }

    /**
     * Controlla se una data è valida nel formato "gg/mm/aaaa" e se rientra nel range specificato.
     *
     * @param string $data La data da verificare.
     * @param string $min La data minima accettata (formato "gg/mm/aaaa").
     * @param string $max La data massima accettata (formato "gg/mm/aaaa").
     * @return bool True se la data è valida ed è compresa tra $min e $max, False altrimenti.
     */
    static function isDate($data, $min='01/01/1900', $max='31/12/2100') {
        $data = \DateTime::createFromFormat('Y-m-d', $data);
        $data = $data->format('d/m/Y');

        $data    = \DateTime::createFromFormat('d/m/Y', $data);
        $minData = \DateTime::createFromFormat('d/m/Y', trim($min));
        $maxData = \DateTime::createFromFormat('d/m/Y', trim($max));
        
        if (!$data || !$minData || !$maxData) {
            return false;
        }
        
        return ($data > $minData && $data < $maxData);
    }

    static function estensioneValida($estensione) {
        $ESTENSIONI_VALIDE = array('jpg', 'jpeg', 'png', 'webp', 'avif');

        return in_array($estensione, $ESTENSIONI_VALIDE);
    }
}
