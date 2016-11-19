<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \App\Entity\Customer;


$app->post('/customer', function (Request $request, Response $response) use ($entityManager){
	
	try{
		
		$data = array();
		$isApp = false;
		
		$allPostPutVars = $request->getParsedBody();
		foreach($allPostPutVars as $key => $param){
			$_POST[$key] = $param;
		}
		
		
		$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
		$password = filter_var($_POST['password'], FILTER_SANITIZE_MAGIC_QUOTES);
		
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
				
				$cust  = $customer[0];
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
