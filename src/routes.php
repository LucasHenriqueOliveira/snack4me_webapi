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
$app->get('/userslist/{d}', function (Request $request, Response $response) use ($entityManager){
	
	try{
		
		$event = 1;# $_GET['company'];
		$repository = $entityManager->getRepository(Vuser::class);
		$users = $repository->findBy(array('eventId' => $event, 'active' => 1), array('name' => 'ASC'));
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
		$event = 1;# $_GET['company'];
		$repository = $entityManager->getRepository(User::class);
		$users = $repository->findBy(array('userId' => $id));
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
/**
 * @param Request $request
 * @param Response $response
 * @return mixed
 */
$app->post('/users/incluir', function (Request $request, Response $response) use ($entityManager){
	
	try{
		
		$repository = $entityManager->getRepository(User::class);
		
		$_POST = json_decode(file_get_contents('php://input'), true);
		
		$username = $_POST['username'];
		$profileID = $_POST['profileId'];
		$company = $_POST['company'];
		$zone = $_POST['zone'];
		$dth = new DateTime('now', new DateTimeZone($zone));
		$userActivationId = $_POST['userActivationId'];
		 
		$user = new User();
		 
		$user->setUserName($username)
			  ->setUserProfileId($profileID)
			  ->setZoneDthActivation($zone)
			  ->setUserPassword(123456)
			  ->setUserIdActivation($userActivationId)
		      ->setUserDthActivation($dth)
		      ->setEventId($company);
		
		try{
			$entityManager->persist($user);
			$entityManager->flush();
		}catch (Exception $e){
			echo $e->getMessage();die;
		}
			
		
		$data["status"] = null;
		$data["error"] = false;
		
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}catch (Exception $e){
		
		$data["status"] = 'error';
		$data["error"] = true;
		$data['message'] = $e;
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});


/** editar usuarios  */
$app->put('/users/editar/{id}', function (Request $request, Response $response,$id) use ($entityManager){
	
	try{
		
		$_POST = json_decode(file_get_contents('php://input'), true);
		
		$username =  $_POST['username'];
		$profileID = $_POST['profileId'];
		$zone = $_POST['zone'];
		$dth = new DateTime('now', new DateTimeZone($zone));
	 	
		$repository = $entityManager->getRepository(User::class);
		$user = $repository->findBy(array("userId" => $id));
		 
		$user  = $user[0];
		 
		
		$user->setUserName($username)
			->setUserProfileId($profileID)
			->setZoneDthUpdate($zone)
			->setUserDthUpdate($dth);
		 try{
		 	$entityManager->flush();
		}catch (Exception $e){
			echo $e->getMessage();die;
		}
		
		$data["status"] = null;
		$data["error"] = false;
		 
		
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


$app->post('/users/remover', function (Request $request, Response $response) use ($entityManager){
	
	try{
	 	$_POST = json_decode(file_get_contents('php://input'), true);
		
		$id = $_POST['id'];
		$userDesactivationId = $_POST['userDesactivationId'];
		$zone = $_POST['zone'];
		$dth = new DateTime('now', new DateTimeZone($zone));
		
		 
		$repository = $entityManager->getRepository(User::class);
		$users = $repository->findBy(array("userId" => $id));
		$users = $users[0];
		$users->setUserActive(0);
		$users->setUserIdDeactivation($userDesactivationId); #ver onde está armazenado o dado
		$users->setZoneDthDeactivation($zone);
		$users->setUserDthDeactivation($dth);
		 
		
		try{
			 
			$entityManager->flush();
		}catch (Exception $e){
			echo $e->getMessage();die;
		}
		
		$data["status"] = null;
		$data["error"] = false;
		
		
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
