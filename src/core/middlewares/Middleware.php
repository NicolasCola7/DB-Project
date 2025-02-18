<?php

namespace core\middlewares;

class Middleware {
    
    /* Array associativo che mappa le chiavi (stringhe) ai nomi delle classi middleware.
     * Le chiavi rappresentano l'identificativo logico del middleware, mentre il valore 
     * è il riferimento alla classe corrispondente. */
    public const TOKENS = [
        'creatore' => Creatore::class,
        'autenticato' => Autenticato::class,
        'admin' => Admin::class,
        'non-autenticato' => NonAutenticato::class
    ];

   
    /**
     * Metodo statico che si occupa di risolvere ed eseguire il middleware in base a una chiave fornita.
     *
     * @param string|null $chiave La chiave che identifica il middleware da eseguire.
     * @throws \Exception Se non viene trovato un middleware corrispondente alla chiave.
     */
    public static function risolvi($chiave) {
        if (!$chiave) {
            return;
        }

        $middleware = isset(static::TOKENS[$chiave]) ? static::TOKENS[$chiave] : false;

        if (!$middleware) {
            throw new \Exception("Nessun middleware trovato per la chiave '{$chiave}'.");
        }

        (new $middleware)->gestisci();
    }
}