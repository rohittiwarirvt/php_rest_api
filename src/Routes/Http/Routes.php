<?php

namespace Webonise\Routes\Http;

use Webonise\Routes\Http\Request;


Class Routes {


  protected $routes = [];
  protected $request;

  public function __construct(Request $request)
  {
    $this->request = $request;
  }


  public function addRoute($method, $url, $callback)
  {
    $this->routes[] = array('method' => $method,
                              'url' => $url,
                              'callback' => $callback
                              );
  }

    // referred http://stackoverflow.com/questions/20433870/php-route-parser-end-of-the-url
  public function startRouting() {
    $method = $this->request->method;
    $url =explode('?', $this->request->url);
    $request_endpoint = $url[0];
    $args['args'] = $this->request->args;
    $result = null;
    foreach ($this->routes as $key => $route) {
     $pattern = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', preg_quote($route['url'])) . "$@D";

      if ($route['method'] == $method && preg_match($pattern, $request_endpoint, $matches)) {
        array_shift($matches);
        $matches = array_merge($matches, $args);
        $result = call_user_func_array($route['callback'], $matches);
      }
    }
    return $result;
  }

}
