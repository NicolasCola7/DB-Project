<?php

namespace core\middlewares;

class Admin {
    
    /**
     * Gestisce il middleware per utenti amministratori.
     * Verifica che l'utente sia autenticato e che disponga dei privilegi di amministratore.
     * Se l'utente non è autenticato, viene reindirizzato alla pagina di login.
     * Se l'utente non possiede i privilegi di amministratore, viene reindirizzato alla home.
     */
    public function gestisci() {
        if (!isset($_SESSION['utente'])) {
            header('location: /login');
            exit();
        }

        if(!isset($_SESSION['utente']['admin'])) {
            header('location: /home');
            exit();
        }
    }
}
