<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Doctrine\ORM\Query\ResultSetMapping;
 
 


$app->get('/event', function (Request $request, Response $response) use ($entityManager){
	
	try{
		
		$data = array();
		$eventos = array();
		
		$allGetVars = $request->getQueryParams();
		foreach($allGetVars as $key => $param){
			$_GET[$key] = $param;
		}
		
		
		$latitude = filter_var($_GET['lat'], FILTER_SANITIZE_STRING);
		$longitude = filter_var($_GET['lon'], FILTER_SANITIZE_MAGIC_QUOTES);
		
		$connection = $entityManager->getConnection()->getWrappedConnection();
		$stmt = $connection->prepare("CALL sp_DistanceEvents(:latitude,:longitude); ");
		$stmt->bindParam(":latitude",$latitude);
		$stmt->bindParam(":longitude",$longitude);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		if($stmt->rowCount() > 0){
			while ($row = $stmt->fetch()){
				$evento['id'] = $row['event_id'];
				$evento['name'] = $row['event_name'];
				$evento['distance'] = $row['distance'];
				$evento['image'] = $row['event_image'];
				$evento['city'] = $row['city_name'];
				$eventos[] = $evento;
			}
		}
		
		$data["error"] = false;
		$data["response"] = $eventos;
		
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
