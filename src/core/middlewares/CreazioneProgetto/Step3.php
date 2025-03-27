<?php

namespace core\middlewares\CreazioneProgetto;

class Step3 {
    
    /**
     * Gestisce il middleware per la creazione del progetto.
     * Se non sono state inserite foto lo reindirizzo a questa vista
     */
    public function gestisci() {
        if(!isset($_SESSION['creazione-progetto'])) {
            header('location: /home/crea-progetto/informazioni-base');
            exit();
        }

        if(!$_SESSION['creazione-progetto']['step3']) {
            header('location: /home/crea-progetto/foto');
            exit();
        }
    }
}