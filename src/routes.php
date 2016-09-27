<?php

header('Content-Type: application/json');

header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Accept, Origin, Content-Type, Cookies, Token, x-access-token, x-key');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Entity\User;
use \App\Entity\Vuser;

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


/** listar os usuarios  */
$app->get('/users', function (Request $request, Response $response) use ($entityManager){

    try{
        $repository = $entityManager->getRepository(User::class);
        $users = $repository->findBy(array(), array('userName' => 'ASC'));
		$arrayUsers = User::toArray($users);
		$data["status"] = null;
		$data["response"] = $arrayUsers;
		 
		return $response->withStatus(200)
						->withHeader("Content-Type", "application/json")
            			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }catch (Exception $e){
	
		$data["status"] = 'error';
		$data['message'] = $e;
		return $response->withStatus(500)
						->withHeader("Content-Type", "application/json")
						->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }

});



/** listar os usuarios dados importantes
 aponta para a view*/
$app->get('/userslist', function (Request $request, Response $response) use ($entityManager){
	
	try{
		
		$event = $_GET['company'];
		
		
		$repository = $entityManager->getRepository(Vuser::class);
		$users = $repository->findBy(array('event_id' => $event), array('name' => 'ASC'));
		$arrayUsers = Vuser::toArray($users);
		$data["status"] = null;
		$data["response"] = $arrayUsers;
		
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}catch (Exception $e){
		
		$data["status"] = 'error';
		$data['message'] = $e;
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});


/** @var Listar usuario pelo ID  */
$app->get('/users/find/{id}', function (Request $request, Response $response, $id) use ($entityManager){
	
	try{
		$repository = $entityManager->getRepository(User::class);
		$users = $repository->findBy(array("userId" => $id));
		$arrayUsers = User::toArray($users);
		$data["status"] = null;
		$data["response"] = $arrayUsers;
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}catch (Exception $e){
		
		$data["status"] = 'error';
		$data['message'] = $e;
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});


/** adicionar usuarios  */
$app->post('/users/incluir', function (Request $request, Response $response) use ($entityManager){
	
	try{
		$repository = $entityManager->getRepository(User::class);
		$data = $request->getParsedBody();
		 
		$data["status"] = null;
		 
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}catch (Exception $e){
		
		$data["status"] = 'error';
		$data['message'] = $e;
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});


/** editar usuarios  */
$app->put('/users/editar/{id}', function (Request $request, Response $response,$id) use ($entityManager){
	
	try{
		$repository = $entityManager->getRepository(User::class);
		$users = $repository->findBy(array("userId" => $id));
		#$arrayUsers = User::toArray($users);
		$data = $request->getParsedBody();
		$data["status"] = null;
	#	$data["users"] = $arrayUsers;
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}catch (Exception $e){
		
		$data["status"] = 'error';
		$data['message'] = $e;
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});


$app->delete('/users/remover/{id}', function (Request $request, Response $response,$id) use ($entityManager){
	
	try{
		$repository = $entityManager->getRepository(User::class);
		$users = $repository->findBy(array("userId" => $id));
		$users->setUserActive(0);
		$users->setUserIdDeactivation(1); #ver onde está armazenado o dado
		$users->setZoneDthDeactivation('America/Sao_Paulo'); #temporário, mudar para retorno da funcao js
		$users->setUserDthDeactivation(new DateTime('now'));
 		
		$entityManager->flush();
		
		$data["status"] = null;
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}catch (Exception $e){
		
		$data["status"] = 'error';
		$data['message'] = $e;
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});





$app->run();
