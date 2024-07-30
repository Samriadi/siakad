<?php
// core/Route.php

class Router
{
  private $routes = [];

  public function add($route, $controller, $action)
  {
    $this->routes[$route] = [
      'controller' => $controller,
      'action' => $action
    ];
  }

  public function dispatch($url)
  {
    foreach ($this->routes as $route => $target) {
      $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route);
      if (preg_match("#^$pattern$#", $url, $matches)) {
        array_shift($matches); // Remove the full match
        $controllerName = $target['controller'];
        $actionName = $target['action'];

        require_once __DIR__ . '../../Controllers/' . $controllerName . '.php';

        $controller = new $controllerName();
        if (method_exists($controller, $actionName)) {
          call_user_func_array([$controller, $actionName], $matches);
        } else {
          echo "Error: Method $actionName not found in controller $controllerName";
        }
        return;
      }
    }
    echo "404";
  }
}
