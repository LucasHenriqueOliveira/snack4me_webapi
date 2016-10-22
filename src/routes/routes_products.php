<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


use \App\Entity\Product;
use \App\Entity\TypeProduct;


/** listar os Produtos  */
$app->get('/products/{d}', function (Request $request, Response $response) use ($entityManager) {
	date_default_timezone_set('America/Sao_Paulo');
	try {
		$event = filter_var($_GET['company'], FILTER_SANITIZE_STRING);
		$repository = $entityManager->getRepository(Product::class);
		
		$products = $repository->findBy(array("productActive" => 1, "productEventId" => $event), array('productNumber' => 'ASC'));
		$arrayProducts = Product::toArray($products);
		$data = array();
		foreach ($arrayProducts as $prod) {
			if ($prod['product_complement'] == 1) {
				$repository = $entityManager->getRepository(TypeProduct::class);
				$typeProducts = $repository->findBy(array("typeProductActive" => 1, "typeProductProductId" => $prod['product_id']));
				$prod['type_product'] = TypeProduct::toArray($typeProducts);
			}
			array_push($data, $prod);
		}
		
		
		$data["status"] = null;
		$data["response"] = $arrayProducts;
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	} catch (Exception $e) {
		
		$data["status"] = 'error';
		$data['message'] = $e;
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});

/** remover Produtos  */
$app->post('/products/remover', function (Request $request, Response $response) use ($entityManager) {
	
	try {
		$_POST = json_decode(file_get_contents('php://input'), true);
		
		$id = filter_var($_POST["id"], FILTER_SANITIZE_STRING);
		
		$repository = $entityManager->getRepository(Product::class);
		$products = $repository->findBy(array("productId" => $id));
		$product = $products[0];
		$product->setProductActive(0);
		
		
		try {
			
			$entityManager->flush();
		} catch (Exception $e) {
			echo $e->getMessage();
			die;
		}
		
		$data["status"] = null;
		$data["error"] = false;
		$data["error"] = false;
		$data["message"] = "Produto removido com sucesso";
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	} catch (Exception $e) {
		
		$data["status"] = 'error';
		$data["error"] = true;
		$data['message'] = "Erro ao remover. " . $e->getMessage();
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});


/** add Produtos  */
$app->post('/products/incluir', function (Request $request, Response $response) use ($entityManager) {
	
	try {
		
		$_POST = json_decode(file_get_contents('php://input'), true);
		
		
		$numero = filter_var($_POST['numero'], FILTER_SANITIZE_STRING);
		$categoria = filter_var($_POST['categoria'], FILTER_SANITIZE_STRING);
		$hora_fim = filter_var($_POST['hora_fim'], FILTER_SANITIZE_STRING) . ':00';
		$hora_inicio = filter_var($_POST['hora_inicio'], FILTER_SANITIZE_STRING) . ':00';
		$price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
		$nome_en = filter_var($_POST['nome_en'], FILTER_SANITIZE_STRING);
		$nome_es = filter_var($_POST['nome_es'], FILTER_SANITIZE_STRING);
		$nome_pt = filter_var($_POST['nome_pt'], FILTER_SANITIZE_STRING);
		$desc_es = filter_var($_POST['desc_es'], FILTER_SANITIZE_STRING);
		$desc_en = filter_var($_POST['desc_en'], FILTER_SANITIZE_STRING);
		$desc_pt = filter_var($_POST['desc_pt'], FILTER_SANITIZE_STRING);
		$fast = filter_var($_POST['fast'], FILTER_SANITIZE_STRING);
		$qtd_complemento = filter_var($_POST['qtd_complemento'], FILTER_SANITIZE_STRING);
		$company = filter_var($_POST['company'], FILTER_SANITIZE_STRING);
		$hour_timezone = filter_var($_POST['zone'], FILTER_SANITIZE_STRING);
		 
		
		
		createDirectory(getcwd(). "../../events/$company");
		createDirectory(getcwd(). "../../events/$company/products");
		createDirectory(getcwd(). "../../events/$company/products/full");
		createDirectory(getcwd(). "../../events/$company/products/thumb");
		
		$imagenFull = save_base64_image($_POST['imageFull'], $company . '_' . $numero . '_full' ,getcwd(). "../../events/$company/" );
		
		
		
		$complement = $qtd_complemento > 0 ? 1 : 0;
		$fast = $fast > 0 ? 1 : 0;
		
		
		if ($numero != "" && $numero > 0) {
			
			$entityManager->getConnection()->beginTransaction(); // suspend auto-commit
			
			$product = new Product();
			$product->setProductNumber($numero)
				->setProductCategoryId($categoria)
				->setProductHourFinal($hora_inicio)
				->setProductHourFinal($hora_fim)
				->setProductPrice($price)
				->setProductNameEn($nome_en)
				->setProductNameEs($nome_es)
				->setProductNamePt($nome_pt)
				->setProductDescEn($desc_en)
				->setProductDescEs($desc_es)
				->setProductDescPt($desc_pt)
				->setProductFast($fast)
				->setProductEventId($company)
				->setProductComplement($complement)
				->setProductHourTimezone($hour_timezone)
				->setProductInventoryCurrent(250)
				->setProductInventoryMaximum(300)
				->setProductInventoryMinimum(10)
				->setProductInventoryQtd(250);
			
			
			$entityManager->persist($product);
			$entityManager->flush();
			$id = $product->getProductId();
			
			$typeProduct = new TypeProduct();
			
			for ($i = 0; $i < $qtd_complemento; $i++) {
				$complemento_en = filter_var($_POST['complemento_en_' . $i], FILTER_SANITIZE_STRING);
				$complemento_es = filter_var($_POST['complemento_es_' . $i], FILTER_SANITIZE_STRING);
				$complemento_pt = filter_var($_POST['complemento_pt_' . $i], FILTER_SANITIZE_STRING);
				
				$typeProduct->setTypeProductNameEn($complemento_en)
					->setTypeProductNameEs($complemento_es)
					->setTypeProductNamePt($complemento_pt)
					->setTypeProductProductId($id);
				
				$entityManager->persist($typeProduct);
				$entityManager->flush();
				
			}
			$entityManager->getConnection()->commit();
			
			
		}
		
		
		$data["status"] = null;
		$data["error"] = false;
		$data["message"] = "Produto incluído com sucesso";
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	} catch (Exception $e) {
		
		$entityManager->getConnection()->rollBack();
		$data["status"] = 'error';
		$data["error"] = true;
		$data['message'] = "Erro ao incluir produto. " . $e->getMessage();
		 
		throw $e;
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});
