<?php



use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


use \App\Entity\Product;
use \App\Entity\TypeProduct;


/** listar os Produtos  */
$app->get('/products/{d}', function (Request $request, Response $response) use ($entityManager){
	date_default_timezone_set('America/Sao_Paulo');
	try{
		$event = filter_var($_GET['company'], FILTER_SANITIZE_STRING);
		$repository = $entityManager->getRepository(Product::class);
		
		$products = $repository->findBy(array("productActive" => 1, "productEventId" => $event  ), array('productNumber' => 'ASC'));
		$arrayProducts = Product::toArray($products);
		$data = array();
		foreach ($arrayProducts as $prod){
			if($prod['product_complement'] == 1) {
				$repository = $entityManager->getRepository(TypeProduct::class);
				$typeProducts = $repository->findBy(array("typeProductActive" => 1, "typeProductProductId" => $prod['product_id']));
				$prod['type_product'] = TypeProduct::toArray($typeProducts);
			}
			array_push($data,$prod);
		}
		
		
		$data["status"] = null;
		$data["response"] = $arrayProducts;
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}catch (Exception $e){
		
		$data["status"] = 'error';
		$data['message'] = $e;
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});

/** remover Produtos  */
$app->post('/products/remover', function (Request $request, Response $response) use ($entityManager){
	
	try{
		$_POST = json_decode(file_get_contents('php://input'), true);
		
		$id = filter_var($_POST["id"], FILTER_SANITIZE_STRING);
		
		$repository = $entityManager->getRepository(Product::class);
		$products = $repository->findBy(array("productId" => $id));
		$product = $products[0];
		$product->setProductActive(0);
		  
		
		try{
			
			$entityManager->flush();
		}catch (Exception $e){
			echo $e->getMessage();die;
		}
		
		$data["status"] = null;
		$data["error"] = false;
		$data["error"] = false;
		$data["message"] = "Produto removido com sucesso";
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}catch (Exception $e){
		
		$data["status"] = 'error';
		$data["error"] = true;
		$data['message'] = "Erro ao remover. " . $e->getMessage();
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});


