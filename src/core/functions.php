<?php

require_once percorso_base("core/Risposta.php");


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
 * @param array $errori Gli errori derivati 
 * @return string Il percorso assoluto della vista.
 */
function view($percorso, $attributi = []) {
    extract($attributi);
    return percorso_base("app/views" . $percorso);
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

/**
 * Funzione per eliminare tutti i file di una directory e poi la directory stessa
 * 
 * @param string $dir Percorso della directory da eliminare
 * @return bool Restituisce true in caso di successo, false in caso di errore
 */
function rimuoviDirectory($dir) {
    // Verifica che la directory esista
    if (!is_dir($dir)) {
        return false;
    }
    
    // Ottiene il contenuto della directory
    $files = array_diff(scandir($dir), array('.', '..'));
    
    foreach ($files as $file) {
        $path = $dir . '/' . $file;
        
        // Se è una directory, chiamata ricorsiva
        if (is_dir($path)) {
            rimuoviDirectory($path);
        } else {
            // Altrimenti elimina il file
            unlink($path);
        }
    }

    return rmdir($dir);
}