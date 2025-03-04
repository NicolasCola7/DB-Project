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
  public function route($uri, $metodo){
    foreach ($this->routes as $route) {
      if ($route['uri'] === $uri && $route['metodo'] === strtoupper($metodo)) {
        Middleware::risolvi($route['middleware']);

        return require percorso_base($route['controller']);
      }
    }
    
    abort(); // Se non viene trovata una route, genera un errore 404
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

  public function routeStatic($uri) {
    return include percorso_base($uri);
  }
}