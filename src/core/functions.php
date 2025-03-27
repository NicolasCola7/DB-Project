<?php

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

function rimuoviDatiCreazione() {
    $cartellaUtente = md5($_SESSION['utente']['nickname']);
    $directoryTemporanea = 'public/immagini/temporanee/'.$cartellaUtente;

    rimuoviDirectory($directoryTemporanea);

    //eliminiamo tutte le variabili per la creazione del progetto
    unset($_SESSION['creazione-progetto']);
    unset($_SESSION['aggiunta-foto']);
    unset($_SESSION['aggiunta-reward']);
    unset($_SESSION['aggiunta-skill']);
    unset($_SESSION['aggiunta-componente']);
}