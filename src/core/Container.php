<?php

namespace core;

/**
 * Classe Container
 *
 * Questa classe implementa un semplice Service Container per la gestione delle dipendenze
 * all'interno di un'applicazione PHP. Un Service Container è una struttura che permette di
 * registrare e risolvere dinamicamente istanze di classi, servizi o funzioni, facilitando il
 * pattern Dependency Injection.
 *
 * Utilizzo tipico:
 * - Registrare (associare) un servizio o una funzione che restituisce un'istanza:
 *
 *      $container = new Container();
 *      $container->associa('logger', function() {
 *          return new Logger();
 *      });
 *
 * - Risolvere (recuperare) il servizio associato:
 *
 *      $logger = $container->risolvi('logger');
 *      $logger->log('Messaggio di prova');
 *
 * Funzionamento:
 * - L'array protetto $associazioni memorizza le mappature tra chiavi (stringhe identificative)
 *   e valori (che possono essere oggetti, funzioni o altre entità).
 * - Il metodo associa() registra una nuova associazione nel container.
 * - Il metodo risolvi() verifica l'esistenza della chiave richiesta e, se il valore associato
 *   è una funzione (o callable), la esegue per restituire il risultato. Se la chiave non è
 *   presente, viene lanciata un'eccezione.
 *
 * Questo approccio favorisce una gestione centralizzata delle dipendenze e migliora la modularità,
 * la testabilità e la manutenibilità del codice.
 */
class Container {
    protected $associazioni = [];

    /**
     * Associa una chiave a un valore (ad esempio, una funzione di creazione dell'istanza).
     *
     * @param string $chiave  La chiave identificativa dell'associazione.
     * @param mixed  $valore  Il valore o la funzione da associare.
     */
    public function associa($chiave, $valore) {
        $this->associazioni[$chiave] = $valore;
    }

    /**
     * Risolve e restituisce il valore associato alla chiave specificata.
     *
     * Se il valore associato è una funzione, la esegue tramite call_user_func().
     * Se la chiave non esiste, viene lanciata un'eccezione.
     *
     * @param string $chiave  La chiave dell'associazione da risolvere.
     * @return mixed          Il risultato della funzione eseguita o il valore registrato.
     * @throws \Exception     Se l'associazione per la chiave specificata non viene trovata.
     */
    public function risolvi($chiave){
        if (!array_key_exists($chiave, $this->associazioni)){
            throw new \Exception("Nessuna associazione trovata per {$chiave}");
        }

        $risolutore = $this->associazioni[$chiave];

        return call_user_func($risolutore);
    }
}
