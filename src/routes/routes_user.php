<?php

 

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Entity\User;
use \App\Entity\Vuser;

  
//***********************************************Users*****************************************************

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
		
		$event = filter_var($_GET['company'], FILTER_SANITIZE_STRING);
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
		$event = filter_var($_GET['company'], FILTER_SANITIZE_STRING);
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
		
		#$repository = $entityManager->getRepository(User::class);
		
		$_POST = json_decode(file_get_contents('php://input'), true);
		
		$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
		$profileID = filter_var($_POST['profileId'], FILTER_SANITIZE_STRING);
		$company = filter_var($_POST['company'], FILTER_SANITIZE_STRING);
		$zone = filter_var($_POST['zone'], FILTER_SANITIZE_STRING);
		$dth = new DateTime('now', new DateTimeZone($zone));
		$userActivationId = filter_var($_POST['userActivationId'], FILTER_SANITIZE_STRING);
		 
		$user = new User();
		 
		$user->setUserName($username)
			  ->setUserProfileId($profileID)
			  ->setZoneDthActivation($zone)
			  ->setUserPassword(SHA1(123456))
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
		
		$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
		$profileID = filter_var($_POST['profileId'], FILTER_SANITIZE_STRING);
		$zone = filter_var($_POST['zone'], FILTER_SANITIZE_STRING);
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
		
		$id = filter_var($_POST["id"], FILTER_SANITIZE_STRING);
		$userDesactivationId = filter_var($_POST["userDesactivationId"], FILTER_SANITIZE_STRING);
		$zone = filter_var($_POST["zone"], FILTER_SANITIZE_STRING);
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



//***********************************************Fim Users*****************************************************
