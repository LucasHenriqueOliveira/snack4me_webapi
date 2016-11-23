<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->get('/local_order', function (Request $request, Response $response) use ($entityManager){
	
	try{
		
		$data = array();
		$eventos = array();
		
		$allGetVars = $request->getQueryParams();
		foreach($allGetVars as $key => $param){
			$_GET[$key] = $param;
		}
		
		
		$id_event = filter_var($_GET['id_event'], FILTER_SANITIZE_STRING);
		 
		$connection = $entityManager->getConnection()->getWrappedConnection();
		$stmt = $connection->prepare('SELECT local_order_id, local_order_name_pt, local_order_name_en, local_order_name_es FROM local_order
			WHERE local_order_active = 1 AND local_order_event_id = ? 
                        ORDER BY local_order_name_pt ASC');
		$stmt->bindParam(1, $id_event, PDO::PARAM_INT);
		
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		if($stmt->rowCount() > 0){
			$name['pt'] = "";
			$name['en'] = "";
			$name['es'] = "";
			
			$local_order['id'] = "";
			$local_order['name'] = $name;
			$locals[] = $local_order;
			
			while ($row = $stmt->fetch()){
				$name['pt'] = $row['local_order_name_pt'];
				$name['en'] = $row['local_order_name_en'];
				$name['es'] = $row['local_order_name_es'];
				
				$local_order['id'] = $row['local_order_id'];
				$local_order['name'] = $name;
				$locals[] = $local_order;
			}
		}
		
		
		
		
		$data["error"] = false;
		$data["response"] = $locals;
		
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

 