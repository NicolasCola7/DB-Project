<?php

namespace core;

use MongoDB\Driver\Manager;
use MongoDB\Driver\BulkWrite;

class MongoDatabase {

    // Proprietà per la connessione e per i parametri di configurazione
    protected $collezione;
    protected $manager;
    private $password;
    private $username;
    private $host;
    private $nome_db;

    /**
     * Costruttore della classe Database
     *
     * Riceve in ingresso un array di configurazione e utilizza i dati per:
     * - Assegnare i parametri (host, username, password, nome del database) alle proprietà della classe
     * - Costruire il DSN per la connessione
     *
     * @param array $config Array di configurazione
     */
    public function __construct($config) {
        
        $this->password = $config['databases']['mongo']['password'];
        $this->username = $config['databases']['mongo']['username'];
        $this->host     = $config['databases']['mongo']['host'];
        $this->nome_db  = $config['databases']['mongo']['nome_db'];

        $this->manager = new Manager("mongodb://".$this->username.":".$this->password."@".$this->host);
        
        // Seleziono il db e la collezione dei logs
        $this->collezione = $this->nome_db . '.logs';
    }
    
    public function inserisciLog($log) {
        $bulk = new BulkWrite;
        $bulk->insert($log);
        
        return $this->manager->executeBulkWrite($this->collezione, $bulk);
    }
}