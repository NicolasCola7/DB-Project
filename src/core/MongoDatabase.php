<?php

namespace core;

use MongoDB\Driver\Manager;
use MongoDB\Driver\BulkWrite;

/**
 * Classe MongoDatabase
 *
 * Gestisce la connessione al database MongoDB e fornisce metodi per interagire con la collezione "logs".
 * I parametri di configurazione vengono passati tramite il costruttore.
 *
 * @package core
 */
class MongoDatabase {

    // Proprietà per la connessione e per i parametri di configurazione
    protected $manager;
    protected $collezione;
    private $password;
    private $username;
    private $host;
    private $nome_db;

    /**
     * Costruttore della classe MongoDatabase.
     *
     * Inizializza la connessione a MongoDB utilizzando i parametri di configurazione.
     * Estrae le credenziali e le informazioni necessarie dalla variabile $config e seleziona la collezione "logs".
     *
     * @param array $config Configurazione per il database, con le chiavi 'databases', 'mongo', 'password', 'username', 'host' e 'nome_db'.
     */
    public function __construct($config) {
        
        $this->password = $config['databases']['mongo']['password'];
        $this->username = $config['databases']['mongo']['username'];
        $this->host     = $config['databases']['mongo']['host'];
        $this->nome_db  = $config['databases']['mongo']['nome_db'];
        
        $uri = "mongodb://".$this->username.":".$this->password."@".$this->host;
        
        try {
            $this->manager = new Manager($uri);
            $this->collezione = 'logs';
            
        } catch (\Exception $e) {
            echo "Fallita connessione a MongoDB: " . $e->getMessage();
        }
    }

    /**
     * Inserisce un log nella collezione "logs" del database.
     *
     * @param array $log Testo del log da inserire.
     */
    public function inserisciLog($log) {
        $bulk = new BulkWrite();
        $bulk->insert(['testo' =>  $log, 'data' => new \DateTime()]);
        $this->manager->executeBulkWrite($this->nome_db . '.' . $this->collezione, $bulk);
    }
}
