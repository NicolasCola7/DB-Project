<?php

namespace core\middlewares\CreazioneProgetto;

class Step1 {
    
    /**
     * Gestisce il middleware per la creazione del progetto.
     * Se non sono state inserite le info di base viene reindirizzato a questa vista
     */
    public function gestisci() {
        if(!isset($_SESSION['creazione-progetto']) || !$_SESSION['creazione-progetto']['step1']) {
            header('location: /home/crea-progetto/informazioni-base');
            exit();
        } 
    }
}