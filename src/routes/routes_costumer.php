<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \App\Entity\Customer;


$app->get('/customer', function (Request $request, Response $response) use ($entityManager){
	
	try{
		
		$_POST = json_decode(file_get_contents('php://input'), true);
		
		$email = filter_var($_GET["email"], FILTER_SANITIZE_STRING);
		$password = filter_var($_GET["password"], FILTER_SANITIZE_MAGIC_QUOTES);
		
		$resposta = array();
		$isApp = false;
		
		
		if(isset($_POST['uuid'])){
			$uuid = filter_var($_POST['uuid'], FILTER_SANITIZE_MAGIC_QUOTES);
			$token = base64_encode($uuid);
			$isApp = true;
		} else{
			$token = hash('sha256', uniqid(mt_rand() . $_SERVER['HTTP_USER_AGENT'], true));
			$isApp = false;
		}
		
		
		$repository = $entityManager->getRepository(Customer::class);
		$customer = $repository->findBy(array('customer_email' => $email, 'customer_password' => sha1($password)),array('customer_email' => 'DESC'), 1);
		
		echo count($customer);die;
		
		$data["status"] = null;
		$data["error"] = false;
		$data["response"] = 123;
		
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}catch (Exception $e){
		echo $e->getMessage();
		$data["status"] = 'error';
		$data["error"] = true;
		$data['message'] = $e;
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});
