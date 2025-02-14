<?php

namespace App;

class Router {

  protected $routes = [];

  /**
   * Aggiunge una nuova route alla lista delle routes.
   * 
   * @param string $method Il metodo HTTP (GET, POST, PUT, DELETE, PATCH)
   * @param string $uri L'URI della route
   * @param string $controller Il controller associato alla route
   */
  public function add($method, $uri, $controller){
    $this->routes[] = [
      'uri' => $uri,
      'controller' => $controller,
      'method' => $method
    ];
  }

  /**
   * Definisce una route per il metodo GET.
   * 
   * @param string $uri L'URI della route
   * @param string $controller Il controller associato
   */
  public function get($uri, $controller){
    $this->add('GET', $uri, $controller);
  }

  /**
   * Definisce una route per il metodo POST.
   * 
   * @param string $uri L'URI della route
   * @param string $controller Il controller associato
   */
  public function post($uri, $controller){
    $this->add('POST', $uri, $controller);
  }

  /**
   * Definisce una route per il metodo PUT.
   * 
   * @param string $uri L'URI della route
   * @param string $controller Il controller associato
   */
  public function put($uri, $controller){
    $this->add('PUT', $uri, $controller);
  }

  /**
   * Definisce una route per il metodo DELETE.
   * 
   * @param string $uri L'URI della route
   * @param string $controller Il controller associato
   */
  public function delete($uri, $controller){
    $this->add('DELETE', $uri, $controller);
  }

  /**
   * Definisce una route per il metodo PATCH.
   * 
   * @param string $uri L'URI della route
   * @param string $controller Il controller associato
   */
  public function patch($uri, $controller){
    $this->add('PATCH', $uri, $controller);
  }

  /**
   * Cerca una route corrispondente all'URI e al metodo forniti e la esegue.
   * Se la route non esiste, chiama il metodo abort().
   * 
   * @param string $uri L'URI richiesto dall'utente
   * @param string $method Il metodo HTTP utilizzato
   */
  public function route($uri, $method){
    foreach ($this->routes as $route) {
      if ($route['uri'] == $uri && $route['method'] == strtoupper($method)) {
        return require base_path($route['controller']);
      }
    }
    
    $this->abort(); // Se non viene trovata una route, genera un errore 404
  }

  /**
   * Imposta il codice di risposta HTTP e carica la pagina di errore corrispondente.
   * 
   * @param int $code Il codice di errore HTTP (default: 404)
   */
  public function abort($code = 404){
    http_response_code($code);
    require base_path("app/views/{$code}.php");
    die(); // Termina l'esecuzione dello script
  }
}