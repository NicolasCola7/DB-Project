<?php

namespace core;

/**
 * Classe App
 *
 * Questa classe funge da punto centrale per l'accesso al Service Container dell'applicazione.
 * Utilizzando metodi statici, permette di impostare e recuperare il container che gestisce le dipendenze
 * dell'applicazione.
 *
 * Utilizzo tipico:
 * 1. Durante l'inizializzazione dell'applicazione (bootstrap.php), si crea ed imposta il container:
 *
 *      $container = new Container();
 *      // Registrazione dei servizi...
 *      App::setContainer($container);
 *
 * 2. Successivamente, in ogni parte dell'applicazione dove è necessario accedere a un servizio,
 *    si può recuperare il container tramite App::getContainer() e risolvere il servizio desiderato:
 *
 *      $db = App::getContainer()->risolvi(Database::class);
 */
class App {

    /**
     * Proprietà statica che memorizza il Service Container.
     *
     * @var mixed
     */
    protected static $container;

    /**
     * Imposta il container che gestisce le dipendenze dell'applicazione.
     *
     * @param mixed $container L'istanza del container (ad esempio, un oggetto della classe Container).
     */
    public static function setContainer($container){
        static::$container = $container;
    }

    /**
     * Restituisce il container impostato, permettendo l'accesso ai servizi registrati.
     *
     * @return mixed L'istanza del container.
     */
    public static function getContainer(){
        return static::$container;
    }
}
