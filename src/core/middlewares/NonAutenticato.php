<?php

namespace core\middlewares;

class NonAutenticato {
    
    /**
     * Gestisce il middleware per utenti non autenticati.
     * Se l'utente risulta autenticato, viene reindirizzato alla home page e l'esecuzione termina.
     */
    public function gestisci() {
        if (isset($_SESSION['utente'])) {
            header('location: /home');
            exit();
        }
    }
}
