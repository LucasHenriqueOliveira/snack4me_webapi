
<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \App\Entity\Event;


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
		
		
		$qb = $entityManager->createQueryBuilder();
		$qb->select('*, ( 6371 * acos( cos( radians('.$latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( latitude ) ) ) ) AS distance, c.city_name')
			->from('\App\Entity\Event', 'e')
			->innerJoin('e', 'city', 'c', 'e.event_city_id = c.city_id')
			->where($qb->expr()->andX('e.eventSinActive = ?1'))
			->orderBy('distance', 'ASC')
			->setParameters(array(1 => 1));
		$data['qtd_produtos'] = $qb->getQuery()->getSingleScalarResult();
		
		
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
