<?php

$app = new \Slim\App();

$container = $app->getContainer();

$container["jwt"] = function ($container) {
  return new StdClass;
};

$app->add(new \Slim\Middleware\JwtAuthentication([
  "secure" => true,
  "relaxed" => "localhost",
  "secret" => "testing",
  "callback" => function ($request, $response, $arguments) use ($container) {
        $container["jwt"] = $arguments["decoded"];
  },
  "error" => function ($request, $response, $arguments) {
        return $response->write("Error");
  }
]));
