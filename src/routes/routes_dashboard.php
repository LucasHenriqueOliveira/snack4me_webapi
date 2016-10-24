<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

 

$app->get('/dashboard', function (Request $request, Response $response) use ($entityManager){


	
	try{
		 
		$event = filter_var($_GET['company'], FILTER_SANITIZE_STRING);
		$zone = filter_var($_GET['zone'], FILTER_SANITIZE_STRING);
		
	  	$qb = $entityManager->createQueryBuilder();
	 	$qb->select('count (u)')
			->from('\App\Entity\Vuser', 'u')
			->where($qb->expr()->andX('u.eventId = ?1'),
					$qb->expr()->andX('u.active = ?3')
			)
			->setParameters(array(1 => $event,3=>1));
		$dados['qtd_usuarios'] = $qb->getQuery()->getSingleScalarResult();
		 
		
		$qb = $entityManager->createQueryBuilder();
		$qb->select('count (p)')
			->from('\App\Entity\Product', 'p')
			->where($qb->expr()->andX('p.productActive = ?1'),
				    $qb->expr()->andX('p.productEventId = ?2')
			)
			->setParameters(array(1 => 1,2 => $event));
		
	 
		$dados['qtd_produtos'] = $qb->getQuery()->getSingleScalarResult();
		
		date_default_timezone_set($zone);
		$dataInicio = date('Y-m-01');
		$dataFim =  date("Y-m-t", strtotime('now'));
		
		
		
		$qb = $entityManager->createQueryBuilder();
		$qb->select('sum(o.orderPrice)')
			->from('\App\Entity\Vorder', 'o')
			->where($qb->expr()->andX('o.orderEventId = ?1 '),
				$qb->expr()->andX('o.orderDate <= ?2'),
				$qb->expr()->andX('o.orderDate >= ?3')
			)
			->setParameters(array(1 => $event, 2 => $dataFim, 3 => $dataInicio));
		
		
		$dados['qtd_resultado'] =$qb->getQuery()->getSingleScalarResult();
		
		$data["error"] = false;
		$data["response"] = $dados;
		
		
		
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
