<?php



use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

  
$app->post('/coupon', function (Request $request, Response $response) use ($entityManager){
	
	try{
		
		$data = array();
		
		$_POST = $request->getParsedBody();
		
		$coupon = $_POST['coupon'];
		$id_event = $_POST['id_event'];
		
		$connection = $entityManager->getConnection()->getWrappedConnection();
		
		$sql = 'SELECT c.coupon_number, c.coupon_tax, c.coupon_event_id FROM `coupon` as c 
	WHERE c.coupon_number = ? AND c.coupon_sin_used = "N"';
		
		$query = $connection->prepare($sql);
		$query->execute(array($coupon));
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$num_rows = $query->rowCount();
		$row = $query->fetch();
		
		if($num_rows > 0){
			
			if($row['coupon'] == ''){
				$data["error"] = false;
				$data["response"] = $row['coupon_tax'];
				$data["status"] = 2;
			} else{
				if($row['coupon'] == $id_event){
					$data["error"] = false;
					$data["response"] = $row['coupon_tax'];
					$data["status"] = 2;
				} else{
					$message["pt"] = 'Cupom '.$coupon.' não é válido para este evento.';
					$message["en"] = 'Coupon '.$coupon.' is not valid for this event.';
					$message["es"] = 'El cupón '.$coupon.' no es válido para este evento.';
					
					$data["error"] = false;
					$data["message"] = $message;
					$data["status"] = 1;
				}
			}
			
		} else{
			$message["pt"] = 'Cupom '.$coupon.' não encontrado.';
			$message["en"] = 'Coupon '.$coupon.' not found.';
			$message["es"] = 'El cupón '.$coupon.' no se encontró.';
			
			$data["error"] = false;
			$data["message"] = $message;
			$data["status"] = 1;
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
