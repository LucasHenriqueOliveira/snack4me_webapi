<?php



use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

 
 
$app->get('/dashboard', function (Request $request, Response $response) use ($entityManager){
	
	try{
		$_POST = json_decode(file_get_contents('php://input'), true);
		
		 
		
		$event = filter_var($_GET['company'], FILTER_SANITIZE_STRING);
			
		
		$qb = $entityManager->createQueryBuilder();
	 	$qb->select('count (u)')
			->from('\App\Entity\Vuser', 'u')
			->where($qb->expr()->andX('u.eventId = ?1'),
				  #  $qb->expr()->andX('u.profileId = ?2'),
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
		
		
		$qb = $entityManager->createQueryBuilder();
		$qb->select('count(o)')
			->from('\App\Entity\Order', 'o');
		$dados['qtd_resultado'] = $qb->getQuery()->getSingleScalarResult();
		
		
		/*$qb = $entityManager->createQueryBuilder();
		$qb->select('sum(o.orderPrice) as qtd_resultado')
			->from('\App\Entity\Order', 'o')
			->where($qb->expr()->andX('o.orderEventId = ?1'),
				    $qb->expr()->andX('o.orderDate <= ?2'),
				    $qb->expr()->andX('o.orderDate >= ?3')
			)
			->setParameters(array(
									1 => $event,
									2 => ' LAST_DAY(CURDATE()) ',
									3 => ' DATE_SUB(LAST_DAY(NOW()), INTERVAL DAY(LAST_DAY(NOW()))-1 DAY)'
								 )
							);
		*/
		$dados['qtd_resultado'] = $qb->getQuery()->getSingleScalarResult();
		
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
