<?php

namespace core\middlewares\CreazioneProgetto;

class Step2 {
    
    /**
     * Gestisce il middleware per la creazione del progetto.
     * Se non sono state inserite componenti o profili viene reinderizzato a queste viste
     */
    public function gestisci() {
        if(!isset($_SESSION['creazione-progetto'])) {
            header('location: /home/crea-progetto/informazioni-base');
            exit();
        }

        if(!$_SESSION['creazione-progetto']['step2']) {
            if($_SESSION['creazione-progetto']['tipo'] === 'hardware')
                header('location: /home/crea-progetto/hardware/componenti');
            else
                header('location: /home/crea-progetto/software/profili');
            exit();
        }
    }
}