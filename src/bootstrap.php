<?php

header('Content-Type: application/json');

#header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Accept, Origin, Content-Type, Cookies, Token, x-access-token, x-key');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\TratarImagem;
 
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

$app->get('/pasta',function(Request $request, Response $response){
	
	
	$im = new TratarImagem();
	$company = 33;
	$numero = 8888;
	$str="data:image/png;base64,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";
	try{
		$im->createDirectory(getcwd(). "../../events/$company");
		$im->createDirectory(getcwd(). "../../events/$company/products");
		$im->createDirectory(getcwd(). "../../events/$company/products/full");
		$im->createDirectory(getcwd(). "../../events/$company/products/thumb");
		
		$imagenFull = $im->save_base64_image($str, $company . '_' . $numero . '_full'
			,getcwd(). "../../events/$company/" );
	}catch(Exception $e){
		echo $e->getMessage();
	}
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
