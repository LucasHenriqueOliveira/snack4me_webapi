<?php



use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

  
$app->post('/customer', function (Request $request, Response $response) use ($entityManager){
	
	try{
		
		$data = array();
		$isApp = false;
		
		$_POST = $request->getParsedBody();
		
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		$password = filter_var($_POST['password'], FILTER_SANITIZE_MAGIC_QUOTES);
		
		if(isset($_POST['uuid'])){
			$uuid = filter_var($_POST['uuid'], FILTER_SANITIZE_MAGIC_QUOTES);
			$token = base64_encode($uuid);
			$isApp = true;
		} else{
			$token = hash('sha256', uniqid(mt_rand() . $_SERVER['HTTP_USER_AGENT'], true));
			$isApp = false;
		}
		
		$connection = $entityManager->getConnection()->getWrappedConnection();
		$query = $connection->prepare("SELECT `customer_id`, `customer_email`, `customer_name`, `customer_type` FROM `customer` WHERE `customer_email` = ? AND `customer_password` = SHA1(?) LIMIT 1");
		$query->execute(array($email,$password));
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$num_rows = $query->rowCount();
		$row = $query->fetch();
		
		if($num_rows > 0){
			
			if(!$isApp){
				session_start();
				
				$_SESSION['id'] = $row['customer_id'];
				$_SESSION['email'] = $row['customer_email'];
				$_SESSION['name'] = $row['customer_name'];
				$_SESSION['type'] = $row['customer_type'];
				$_SESSION['XSRF'] = $token;
			} else{
				$query = $connection->prepare("UPDATE `customer` SET `customer_token` = ?, `customer_device_id` = ? WHERE `customer_id` = ?");
				$query->execute(array($token, $uuid, $row['customer_id']));
			}
			
			$user['id'] = $row['customer_id'];
			$user['email'] = $row['customer_email'];
			$user['name'] = $row['customer_name'];
			$user['type'] = $row['customer_type'];
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
		$data['message'] = $e->getMessage();
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});

$app->post('/customer_social', function (Request $request, Response $response) use ($entityManager){
	
	try{
		
		$data = array();
		$isApp = false;
		
		$_POST = $request->getParsedBody();
		
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
		$type = filter_var($_POST['type'], FILTER_SANITIZE_NUMBER_INT);
		
		if(isset($_REQUEST['uuid'])){
			$uuid = filter_var($_REQUEST['uuid'], FILTER_SANITIZE_MAGIC_QUOTES);
			$token = base64_encode($uuid);
			$isApp = true;
		} else{
			$token = hash('sha256', uniqid(mt_rand() . $_SERVER['HTTP_USER_AGENT'], true));
			$isApp = false;
		}
		
		$connection = $entityManager->getConnection()->getWrappedConnection();
		
		$query = $connection->prepare("SELECT `customer_id`, `customer_email`, `customer_name`, `customer_type` FROM `customer` WHERE `customer_email` = ? LIMIT 1");
		$query->execute(array($email));
		$query->setFetchMode(PDO::FETCH_CLASS, 'Customer');
		$num_rows = $query->rowCount();
		$row = $query->fetch();
		
		if($num_rows > 0){
			
			if(!$isApp){
				session_start();
				
				$_SESSION['id'] = $row['customer_id'];
				$_SESSION['email'] = $row['customer_email'];
				$_SESSION['name'] = $row['customer_name'];
				$_SESSION['type'] = $row['customer_type'];
				$_SESSION['XSRF'] = $token;
			} else{
				$query = $connection->prepare("UPDATE `customer` SET `customer_token` = ?, `customer_device_id` = ? WHERE `customer_id` = ?");
				$query->execute(array($token, $uuid, $row->getCustomerId()));
			}
			
			$user['id'] = $row['customer_id'];
			$user['email'] = $row['customer_email'];
			$user['name'] = $row['customer_name'];
			$user['type'] = $row['customer_type'];
			$user['XSRF'] = $token;
			
			$data["error"] = false;
			$data["response"] = $user;
			
		}else{
			try{
				$date = date('Y-m-d H:i:s');
				
				$sql = "INSERT INTO `customer` (`customer_name`,`customer_email`,`customer_registration_date`,
			`customer_sin_valid`,`customer_valid_date`,`customer_type`)
			VALUES('" . $name . "', '" . $email . "', '" . $date . "',
			'S', '" . $date . "', " . $type . ")";
				
				$query = $connection->prepare($sql);
				$query->execute();
				
				if(!$isApp){
					session_start();
					
					$_SESSION['id'] = $connection->lastInsertId();
					$_SESSION['email'] = $email;
					$_SESSION['name'] = $name;
					$_SESSION['type'] = $type;
					$_SESSION['XSRF'] = $token;
				} else{
					$query = $connection->prepare("UPDATE `customer` SET `customer_token` = ?, `customer_device_id` = ? WHERE `customer_id` = ?");
					$query->execute(array($token, $uuid, $con->lastInsertId()));
				}
				
				$user['id'] = $connection->lastInsertId();
				$user['email'] = $email;
				$user['name'] = $name;
				$user['type'] = $type;
				$user['XSRF'] = $token;
				
				$data["error"] = false;
				$data["response"] = $user;
				
			} catch (Exception $e){
				
				$data["error"] = true;
				$data["message"] = "Error! User login by network social.";
			}
		}
		
		 
		
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}catch (Exception $e){
		$data["error"] = true;
		$data['message'] = $e->getMessage();
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});

$app->post('/customer_register', function (Request $request, Response $response) use ($entityManager){
	
	try{
		
		$data = array();
	 
		$_POST = $request->getParsedBody();
		
		
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		$password = filter_var($_POST['password'], FILTER_SANITIZE_MAGIC_QUOTES);
		$uuid = filter_var($_POST['uuid'], FILTER_SANITIZE_MAGIC_QUOTES);
		$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
		$token = '';
		$date = date('Y-m-d H:i:s');
		
		if(!isset($email)){
			$data["error"] = true;
			$data["message"] = "Enter a valid email.";
			echo json_encode($data);
			die;
		}
		
		if(!isset($name)){
			$data["error"] = true;
			$data["message"] = "Enter a name.";
			echo json_encode($data);
			die;
		}
		
		if(isset($uuid)){
			$token = base64_encode($uuid);
		}
		
		
		
		$connection = $entityManager->getConnection()->getWrappedConnection();
		
		$query = $connection->prepare("SELECT `customer_id`, `customer_name` FROM `customer` WHERE `customer_email` = ? LIMIT 1");
		$query->execute(array($email));
		$num_rows = $query->rowCount();
		
		if($num_rows > 0){
			$data["error"] = true;
			$data["message"] = "E-mail already registered.";
		} else{
			
			$query2 = $connection->prepare('INSERT INTO customer(customer_name, customer_email, customer_password, customer_token, customer_device_id, customer_registration_date, customer_type)  VALUES(?,?,?,?,?,?,?)');
			$query2->execute(array($name, $email, SHA1($password), $token, $uuid, $date, 2));
			$num_rows2 = $query2->rowCount();
			
			if($num_rows2 > 0){
				$input = "email=" . $email . "&name=" . $name;
				$arr = array("/" => "#", "\\" => "&");
				$ve = rtrim(strtr(base64_encode(gzdeflate($input, 9)), $arr), '=');
				
				include ('../lib/utilities.php');
				$assunto = "Cadastro na Snack4me";
				$mensagem = "Prezado(a) <strong>". $name . "</strong>, bem-vindo a Snack4me. <br /><br />
			Nós precisamos verificar o seu email. Para completar esse processo por favor clique no link abaixo ou copie e cole no seu navegador. <br /><br />" ;
				$mensagem .= "Link de verificação: <a href='http://www.snack4me.com/#/check-email/".$ve."' target='_blank'>http://www.snack4me.com/#/check-email/" . $ve . "</a> <br /><br />";
				$mensagem .= "Obrigado<br /><a href='http://www.snack4me.com' target='_blank'><img src='http://www.snack4me.com/hotel/images/logo_small.png' title='Snack4me'></a><br /><br />";
				$mensagem .= "<span style='font-size:9px;color:#d5d5d5'>Favor não responder o email.</span><br />";
				
				$envia_email = enviarEmail($name, $email, $assunto, $mensagem);
				
				$resposta["error"] = false;
				$customer["customer_id"] = $connection->lastInsertId();
				$customer["email"] = $email;
				$customer["XSRF"] = $token;
				$customer["uuid"] = $uuid;
				$resposta["response"] = $customer;
				
			} else{
				$resposta["error"] = true;
				$resposta["message"] = "Error! Please try again.";
			}
		}
		
		
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}catch (Exception $e){
		$data["error"] = true;
		$data['message'] = $e->getMessage();
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});

//***********************************************Fim customer*****************************************************
