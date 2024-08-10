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
    // Pastikan $url dimulai dengan /admin/ dan hapus jika ada
    $basePath = '/admin/';
    if (strpos($url, $basePath) === 0) {
      $url = substr($url, strlen($basePath));
    }

    foreach ($this->routes as $route => $target) {
      // Tambahkan /admin/ di awal pattern route
      $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route);
      $pattern = str_replace('/', '\/', $pattern);
      $pattern = "^" . str_replace('/admin/', '', $pattern) . "$";

      if (preg_match("#$pattern#", $url, $matches)) {
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
