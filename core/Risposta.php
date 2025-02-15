<?php

class Risposta {
    const OK = 200;
    const CREATO = 201;
    const ACCETTATO = 202;
    
    const ERRORE_RICHIESTA = 400;
    const NON_AUTORIZZATO = 401;
    const PAGAMENTO_RICHIESTO = 402;
    const VIETATO = 403;
    const NON_TROVATO = 404;
    const METODO_NON_PERMESSO = 405;
    const NON_ACCETTABILE = 406;    

    const ERRORE_SERVER = 500;
}