<?php

namespace core\middlewares\CreazioneProgetto;

class Step4 {
    
    /**
     * Gestisce il middleware per la creazione del progetto.
     * Se non sono state inserite rewards lo reindirizzo a questa vista
     */
    public function gestisci() {
        if(!isset($_SESSION['creazione-progetto'])) {
            header('location: /home/crea-progetto/informazioni-base');
            exit();
        }
 
        if(!$_SESSION['creazione-progetto']['step4']) {
            header('location: /home/crea-progetto/rewards');
            exit();
        }
    }
}