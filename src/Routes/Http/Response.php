<?php

namespace Webonise\Routes\Http;

class Response
{


  public function responseOk($data) {
    return $this->prepareResponse($data);
  }

  public function responseError() {

  }

  public function prepareResponse($data, array $options = array(), $status_code = 200) {
    $default = array('Content-Type' => 'application/json');
    $options = array_merge($default, $options);

    foreach ($options as $key => $value) {
      header($key . ': ' . $value);
    }
     http_response_code($status_code);
     return json_encode($data);
  }
}
