<?php

header('Content-Type: application/json');

#header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Accept, Origin, Content-Type, Cookies, Token, x-access-token, x-key');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

 
$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];


$entityManager = getEntityManager();

$c = new \Slim\Container($configuration);

$c['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        return $c['response']->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->write('Algo deu errado!');
    };
};


$app = new \Slim\App($c);
 



$app->get('/', function (Request $request, Response $response) {

    #$response->getBody()->write("URL Incompleta");
    $data = "URL Incompleta";
    
    return $response
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});



//***********************************************Users*****************************************************

require_once __DIR__ . "/routes/routes_user.php";
//***********************************************Login*****************************************************

require_once __DIR__ . "/routes/routes_login.php";
//***********************************************PRODUCTSS*****************************************************
require_once __DIR__ . "/routes/routes_products.php";
//***********************************************Category*****************************************************
require_once __DIR__ . "/routes/routes_category.php";


$app->run();
