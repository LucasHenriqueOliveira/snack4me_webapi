<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \App\Entity\Customer;


$app->get('/customer', function (Request $request, Response $response) use ($entityManager){
	
	try{
		
		$_POST = json_decode(file_get_contents('php://input'), true);
		
		$email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
		$password = filter_var($_POST["password"], FILTER_SANITIZE_MAGIC_QUOTES);
		
		$data = array();
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
		$customer = $repository->findBy(array('customerEmail' => $email, 'customerPassword' => sha1($password), 'customerSinValid' => 'S'),array('customerEmail' => 'DESC'), 1);
		
		
		
		if(count($customer) > 0){
			
			if(!$isApp){
				session_start();
			} else{
				
				$repository = $entityManager->getRepository(Customer::class);
				$cust = $repository->findBy(array("customerId" => $customer[0]->getCustomerId()));
				
				$cust  = $cust[0];
				$cust->setCustomerToken($token)
					->setCustomerDeviceId($uuid);
				$entityManager->flush();
				
			}
			
			$user['id'] = $customer[0]->getCustomerId();
			$user['email'] = $customer[0]->getCustomerEmail();
			$user['name'] = $customer[0]->getCustomerName();
			$user['type'] = $customer[0]->getCustomerType();
			$user['XSRF'] = $token;
			
			$data["error"] = false;
			$data["response"] = $user;
			
		} else{
			
			$data["error"] = true;
			$message["en"] = "User not found.";
			$message["pt"] = "Usuário não encontrado.";
			$data["message"] = $message;
		}
		
	 	
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}catch (Exception $e){
		
		$data["error"] = true;
		$data['message'] = $e;
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});
