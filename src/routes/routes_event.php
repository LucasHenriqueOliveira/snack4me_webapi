<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


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
				$evento['integration'] = $row['event_integration'];
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

$app->get('/event_call', function (Request $request, Response $response) use ($entityManager){
	
	try{
		
		$data = array();
		$eventos = array();
		
		$allGetVars = $request->getQueryParams();
		foreach($allGetVars as $key => $param){
			$_GET[$key] = $param;
		}
		
		
		$city = filter_var($_GET['city'], FILTER_SANITIZE_STRING);
	 	
		$connection = $entityManager->getConnection()->getWrappedConnection();
		$stmt = $connection->prepare('SELECT *,city.city_name FROM event INNER JOIN city ON event.event_city_id = city.city_id 
										WHERE event.event_city_id = ? AND event.event_sin_active = 1');
		$stmt->bindParam(1, $city, PDO::PARAM_INT);
		
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		if($stmt->rowCount() > 0){
			while ($row = $stmt->fetch()){
				$evento['id'] = $row['event_id'];
				$evento['name'] = $row['event_name'];
				$evento['image'] = $row['event_image'];
				$evento['city'] = $row['city_name'];
				$evento['integration'] = $row['event_integration'];
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


$app->get('/event_city', function (Request $request, Response $response) use ($entityManager){
	
	try{
		
		$data = array();
		$cities = array();
		
		$connection = $entityManager->getConnection()->getWrappedConnection();
		$stmt = $connection->prepare("SELECT e.event_city_id, c.city_name 
			FROM event e INNER JOIN city c ON e.event_city_id = c.city_id 
			WHERE e.event_sin_active = 1 GROUP BY e.event_city_id");
		
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
		if($stmt->rowCount() > 0){
			while ($row = $stmt->fetch()){
				$city['id_city'] = $row['event_city_id'];
				$city['name_city'] = $row['city_name'];
				$cities[] = $city;
			}
		}
		
		$data["error"] = false;
		$data["response"] = $cities;
		
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
