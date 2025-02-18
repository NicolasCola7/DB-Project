<?php

namespace core\middlewares;

class Autenticato {
    
    /**
     * Verifica se l'utente è autenticato controllando la presenza di 'utente' nella sessione.
     * Se l'utente non è autenticato, viene reindirizzato alla pagina di login e lo script termina.
     */
    public function gestisci() {
        if (!isset($_SESSION['utente'])) {
            header('location: /login');
            exit();
        }
    }
}
