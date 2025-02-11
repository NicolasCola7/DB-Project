<?php
namespace App;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\NoConfigurationException;
class Router
{
  public function __invoke(RouteCollection $routes)
  {
    $context = new RequestContext();
    
    // Routing permette di associare i percorsi al  le richieste in arrivo
    $matcher = new UrlMatcher($routes, $context);
    try {
      $arrayUri = explode('?', $_SERVER['REQUEST_URI']);
      $matcher = $matcher->match($arrayUri[0]);
      
      // Cast params to int if numeric
      array_walk($matcher, function(&$param)
      {
        if(is_numeric($param))
        {
          $param = (int) $param;
        }
      });

    // https://github.com/gmaccario/simple-mvc-php-framework/issues/2
    // Issue #2: Fix Non-static method ... should not be called statically
    $className = '\\App\\Controllers\\' . $matcher['controller'];
    $classInstance = new $className();

    // Add routes as paramaters to the next class
    $params = array_merge(array_slice($matcher, 2, -1), array('routes' => $routes));
    call_user_func_array(array($classInstance, $matcher['method']), $params);
    } catch (MethodNotAllowedException $e) {
      echo 'Metodo del percorso non permesso.';
    } catch (ResourceNotFoundException $e) {
      echo 'Percorso non trovato';
    } catch (NoConfigurationException $e) {
      echo 'Configurazione inesistente.';
    }
  }
}

$router = new Router();
$router($routes);