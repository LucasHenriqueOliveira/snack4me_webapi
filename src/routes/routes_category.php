<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \App\Entity\Category;


$app->get('/categories/{d}', function (Request $request, Response $response) use ($entityManager){
	
	try{
		
		#$event = filter_var($_GET['company'], FILTER_SANITIZE_STRING);
		$repository = $entityManager->getRepository(Category::class);
		$categories = $repository->findBy(array(),array('categoryNamePt' => 'ASC'));
		$arrayCategories = Category::toArray($categories);
		$data["status"] = null;
		$data["error"] = false;
		$data["response"] = $arrayCategories;
		
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}catch (Exception $e){
		echo $e->getMessage();
		$data["status"] = 'error';
		$data["error"] = true;
		$data['message'] = $e;
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});
