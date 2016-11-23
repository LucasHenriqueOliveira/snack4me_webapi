<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Accept, Origin, Content-Type, Cookies, Token, x-access-token, x-key');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
 
  


$entityManager = getEntityManager();


$c = new \Slim\Container();

 
$c['settings']['displayErrorDetails'] = true;

$app = new \Slim\App($c);


$app->get('/', function (Request $req,  Response $res, $args = []) {
	return $res->withStatus(400)->write('Bad Request');
});

 
//***********************************************Users*****************************************************
require_once __DIR__ . "/routes/routes_user.php";
//***********************************************Login*****************************************************
require_once __DIR__ . "/routes/routes_login.php";
//***********************************************PRODUCTSS*****************************************************
require_once __DIR__ . "/routes/routes_products.php";
//***********************************************Category*****************************************************
require_once __DIR__ . "/routes/routes_category.php";
//***********************************************dashboard*****************************************************
require_once __DIR__ . "/routes/routes_dashboard.php";
//***********************************************dashboard*****************************************************
require_once __DIR__ . "/routes/routes_costumer.php";
//***********************************************dashboard*****************************************************
require_once __DIR__ . "/routes/routes_event.php";
//***********************************************dashboard*****************************************************
require_once __DIR__ . "/routes/routes_order.php";

$app->run();
