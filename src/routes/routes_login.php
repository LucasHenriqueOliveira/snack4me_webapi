<?php



use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \App\Entity\Vuser;


/** listar os usuarios dados importantes
aponta para a login de usuario*/
$app->post('/login', function (Request $request, Response $response) use ($entityManager){
	
	try{
		
		$_POST = json_decode(file_get_contents('php://input'), true);
		
		$user = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
		$password = filter_var($_POST["password"], FILTER_SANITIZE_MAGIC_QUOTES);
		$repository = $entityManager->getRepository(Vuser::class);
		$users = $repository->findBy(array('name' => $user, 'active' => 1, 'password' => sha1($password)));
		$arrayUsers = Vuser::toArray($users);
		
		$data = array();
		$data["error"] = true;
		
		
		if (!empty($arrayUsers)){
			$arrayUsers[0]["token"] = base64_encode($user);
			$data["response"] = $arrayUsers[0];
			$data["error"] = false;
			
		} else {

// Nenhum registro foi encontrado => o usuário é inválido
			$data["message"] = "Usuário e/ou Senha inválidos.";
		}
		
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}catch (Exception $e){
		
		$data['message'] = $e->getMessage();
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});



//***********************************************Fim Login*****************************************************
