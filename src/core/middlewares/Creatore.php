<?php

namespace core\middlewares;

class Creatore {
    
    /**
     * Gestisce il middleware per gli utenti creatori.
     * Verifica che l'utente sia autenticato e che possieda il ruolo di creatore.
     * Se l'utente non è autenticato, viene reindirizzato alla pagina di login.
     * Se l'utente non possiede il ruolo "creatore", viene reindirizzato alla home.
     */
    public function gestisci() {
        if (!isset($_SESSION['utente'])) {
            header('location: /login');
            exit();
        }

        if(!isset($_SESSION['utente']['creatore'])) {
            header('location: /home');
            exit();
        }
    }
}
