<?php

namespace core;

use PDO;
use PDOException;

class Database {

    // Proprietà per la connessione PDO e per i parametri di configurazione
    protected $connessione;
    private $password;
    private $username;
    private $host;
    private $nome_db;
    private $charset;

    /**
     * Costruttore della classe Database
     *
     * Riceve in ingresso un array di configurazione e utilizza i dati per:
     * - Assegnare i parametri (host, username, password, nome del database e charset) alle proprietà della classe
     * - Costruire il DSN per la connessione PDO
     * - Creare una nuova connessione PDO e impostare il fetch mode predefinito
     *
     * @param array $config Array di configurazione
     */
    public function __construct($config) {
        
        $this->password = $config['databases']['mysql']['password'];
        $this->username = $config['databases']['mysql']['username'];
        $this->host     = $config['databases']['mysql']['host'];
        $this->nome_db  = $config['databases']['mysql']['nome_db'];
        $this->charset  = $config['databases']['mysql']['charset'];

        $dsn = "mysql:host={$this->host};dbname={$this->nome_db};charset={$this->charset}";
        try {
            $this->connessione = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Connessione fallita: " . $e->getMessage());
        }
    }

    /**
     * Metodo per eseguire una query sul database.
     */
    public function query() {
        // Qui va implementata la logica per eseguire una query SQL
    }

    /**
     * Metodo per eseguire una stored procedure sul database.
     */
    public function procedure(){
        // Qui va implementata la logica per eseguire una stored procedure
    }
}
