<?php

namespace core;

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
      'metodo' => $metodo
    ];
  }

  /**
   * Definisce una route per il metodo GET.
   * 
   * @param string $uri L'URI della route
   * @param string $controller Il controller associato
   */
  public function get($uri, $controller){
    $this->aggiungi('GET', $uri, $controller);
  }

  /**
   * Definisce una route per il metodo POST.
   * 
   * @param string $uri L'URI della route
   * @param string $controller Il controller associato
   */
  public function post($uri, $controller){
    $this->aggiungi('POST', $uri, $controller);
  }

  /**
   * Definisce una route per il metodo PUT.
   * 
   * @param string $uri L'URI della route
   * @param string $controller Il controller associato
   */
  public function put($uri, $controller){
    $this->aggiungi('PUT', $uri, $controller);
  }

  /**
   * Definisce una route per il metodo DELETE.
   * 
   * @param string $uri L'URI della route
   * @param string $controller Il controller associato
   */
  public function delete($uri, $controller){
    $this->aggiungi('DELETE', $uri, $controller);
  }

  /**
   * Definisce una route per il metodo PATCH.
   * 
   * @param string $uri L'URI della route
   * @param string $controller Il controller associato
   */
  public function patch($uri, $controller){
    $this->aggiungi('PATCH', $uri, $controller);
  }

  /**
   * Cerca una route corrispondente all'URI e al metodo forniti e la esegue.
   * Se la route non esiste, chiama il metodo abort().
   * 
   * @param string $uri L'URI richiesto dall'utente
   * @param string $metodo Il metodo HTTP utilizzato
   */
  public function route($uri, $metodo){
    foreach ($this->routes as $route) {
      if ($route['uri'] === $uri && $route['metodo'] === strtoupper($metodo)) {
        return require percorso_base($route['controller']);
      }
    }
    
    abort(); // Se non viene trovata una route, genera un errore 404
  }
}