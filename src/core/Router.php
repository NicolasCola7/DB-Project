<?php

namespace core;
use core\middlewares\Middleware;

class Router {

  protected $routes = [];

  /**
   * Aggiunge una nuova route alla lista delle routes.
   * 
   * @param string $metodo Il metodo HTTP (GET, POST, PUT, DELETE, PATCH)
   * @param string $uri L'URI della route
   * @param string $controller Il controller associato alla route
   */
  public function aggiungi($metodo, $uri, $controller){
     $this->routes[] = [
      'uri' => $uri,
      'controller' => $controller,
      'metodo' => $metodo,
      'middleware' => null
    ];

    return $this;
  }

  /**
   * Definisce una route per il metodo GET.
   * 
   * @param string $uri L'URI della route
   * @param string $controller Il controller associato
   */
  public function get($uri, $controller){
    return $this->aggiungi('GET', $uri, $controller);
  }

  /**
   * Definisce una route per il metodo POST.
   * 
   * @param string $uri L'URI della route
   * @param string $controller Il controller associato
   */
  public function post($uri, $controller){
    return $this->aggiungi('POST', $uri, $controller);
  }

  /**
   * Definisce una route per il metodo PUT.
   * 
   * @param string $uri L'URI della route
   * @param string $controller Il controller associato
   */
  public function put($uri, $controller){
    return $this->aggiungi('PUT', $uri, $controller);
  }

  /**
   * Definisce una route per il metodo DELETE.
   * 
   * @param string $uri L'URI della route
   * @param string $controller Il controller associato
   */
  public function delete($uri, $controller){
    return $this->aggiungi('DELETE', $uri, $controller);
  }

  /**
   * Definisce una route per il metodo PATCH.
   * 
   * @param string $uri L'URI della route
   * @param string $controller Il controller associato
   */
  public function patch($uri, $controller){
    return $this->aggiungi('PATCH', $uri, $controller);
  }

  /**
   * Cerca una route corrispondente all'URI e al metodo HTTP forniti e la esegue.
   * Se la route prevede un middleware, questo viene risolto ed eseguito.
   * Se la route non viene trovata, viene chiamata la funzione abort() per gestire l'errore (404).
   *
   * @param string $uri L'URI richiesto dall'utente.
   * @param string $metodo Il metodo HTTP utilizzato (GET, POST, etc.).
   * @return mixed L'esecuzione del controller associato alla route, se presente.
   */
  public function route($uri, $metodo) {
    foreach ($this->routes as $route) {
  
        // Trasforma il pattern della route sostituendo i placeholder dinamici (es. {id})
        // con una parte dell'espressione regolare che cattura il valore del parametro.
        //
        // Spiegazione dettagliata:
        // - La regex di ricerca: '/\{([a-zA-Z0-9_]+)\}/'
        //   • '\{' e '\}' corrispondono ai caratteri letterali '{' e '}'.
        //   • '([a-zA-Z0-9_]+)' è un gruppo di cattura che individua uno o più caratteri
        //     alfanumerici o underscore, corrispondenti al nome del parametro.
        //
        // - La stringa di sostituzione: '(?P<$1>[^/]+)'
        //   • '(?P<$1>...)' definisce un gruppo di cattura denominato; il nome è preso dal gruppo catturato
        //     nella regex di ricerca (ad esempio, 'id' per '{id}').
        //   • '[^/]+', all'interno del gruppo, indica che si catturano uno o più caratteri qualsiasi
        //     tranne il carattere '/', per evitare di includere separatori di directory.
        //
        // Esempio: se $route['uri'] è '/progetto/{NomePerogetto}', dopo preg_replace diventa:
        // '/progetto/(?P<nomeProgetto>[^/]+)'
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route['uri']);

        // Aggiunge delimitatori e ancoraggi all'espressione regolare:
        // - I delimitatori '#' racchiudono il pattern per la sintassi della regex in PHP.
        // - '^' ancorato all'inizio e '$' alla fine garantiscono che l'intera stringa URI
        //   debba corrispondere esattamente al pattern.
        // Il risultato finale è, ad esempio: '#^/progetti/(?P<nomeProgetto>[^/]+)$#'
        $pattern = '#^' . $pattern . '$#';
        
        if (preg_match($pattern, $uri) && $route['metodo'] === strtoupper($metodo)) {
  
          Middleware::risolvi($route['middleware']);
  
          return require percorso_base($route['controller']);
        }
    }
    
    abort(); 
  }

  
  /**
   * Associa un middleware all'ultima route aggiunta.
   * Il middleware specificato verrà eseguito prima dell'invocazione del controller associato alla route.
   *
   * @param string $chiave La chiave identificativa del middleware da associare.
   * @return $this Ritorna l'istanza corrente del router per permettere il method chaining.
   */
  public function soloSe($chiave) {
    $this->routes[array_key_last($this->routes)]['middleware'] = $chiave;

    return $this;
  }
  
  /**
   * Ritorna una risorsa statica
   *  @param string $uri L'URI della risorsa richiesta.
   * @return mixed Il risultato dell'inclusione del file, oppure false se l'inclusione fallisce.
   */
  public function routeStatic($uri) {
    return include percorso_base($uri);
  }
}