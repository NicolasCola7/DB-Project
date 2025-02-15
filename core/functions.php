<?php

require_once percorso_base("/core/Risposta.php");


/**
 * Controlla se l'URL corrente corrisponde a quello specificato.
 *
 * @param string $val L'URL da confrontare.
 * @return bool True se l'URL corrente è uguale a $val, altrimenti False.
 */
function url($val){
    return $_SERVER['REQUEST_URI'] == $val;
}

/**
 * Verifica una condizione e, in caso negativo, termina l'esecuzione con un determinato stato HTTP.
 *
 * @param bool $condizione Condizione da verificare.
 * @param int $stato Stato HTTP da restituire in caso di fallimento (default: Response::FORBIDDEN).
 * @return void
 */
function autorizza($condizione, $stato = Risposta::NON_AUTORIZZATO){
    if(!$condizione)
        abort($stato);
}

/**
 * Restituisce il percorso assoluto concatenando la costante di base con il percorso specificato.
 *
 * @param string $percorso Il percorso relativo da concatenare.
 * @return string Il percorso assoluto risultante.
 */
function percorso_base($percorso){
    return PERCORSO_BASE . $percorso;
}

/**
 * Restituisce il percorso completo della vista specificata.
 *
 * @param string $percorso Il percorso relativo della vista.
 * @return string Il percorso assoluto della vista.
 */
function view($percorso) {
    return percorso_base("app/views" . $percorso);
}

/**
 * Restituisce il percorso completo del controller specificato.
 *
 * @param string $percorso Il percorso relativo del controller.
 * @return string Il percorso assoluto del controller.
 */
function controller($percorso) {
    return percorso_base("app/controllers" . $percorso);
}

/**
* Imposta il codice di risposta HTTP e carica la pagina di errore corrispondente.
* 
* @param int $codice Il codice di errore HTTP (default: 404)
*/
function abort($codice = 404){
    http_response_code($codice);
    //require percorso_base("app/views/{$codice}.php");
    die(); // Termina l'esecuzione dello script
}