<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require 'vendor/autoload.php';

$app = AppFactory::create();

// Add Body parsinig middleware
$app->addBodyParsingMiddleware();

// Add Error Handling Middleware
$app->addErrorMiddleware(true, false, false);

$app->get('/slim/hello/{name}', function (Request $request, Response $response, array $args) {
    
    $name = $args['name'];

    $response->getBody()->write("Hello, $name");

    return $response;
});

$app->get('/slim/users', function (Request $request, Response $response, array $args) {
    
    $users = [
        ['name' => 'John', 'age' => 30],
        ['name' => 'Marylin', 'age' => 25],
        ['name' => 'Arthur', 'age' => 45]
    ];

    $payload = json_encode($users);

    $newResponse = $response->withHeader('Content-Type', 'application/json');

    $newResponse->getBody()->write($payload);

    return $newResponse;
});

$app->post('/slim/users', function (Request $request, Response $response, array $args) {
    
    $jsonBody = $request->getParsedBody();

    $name = $jsonBody['name'];

    $age = $jsonBody['age'];

    $data = ['msg' => 'OK', 'name' => $name, 'age' => $age];

    $payload = json_encode($data);

    $newResponse = $response->withHeader('Content-Type', 'application/json');
    
    $newResponse->getBody()
                ->write($payload);

    return $newResponse;
});

$app->run();