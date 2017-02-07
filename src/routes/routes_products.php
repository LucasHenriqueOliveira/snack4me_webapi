<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \App\Entity\Product;
use \App\Entity\TypeProduct;
use \App\TratarImagem;


//***********************************************prod*****************************************************



/** listar os Produtos  */
$app->get('/products/{d}', function (Request $request, Response $response) use ($entityManager) {
	date_default_timezone_set('America/Sao_Paulo');
	try {
		$event = filter_var($_GET['company'], FILTER_SANITIZE_STRING);
		$repository = $entityManager->getRepository(Product::class);
		
		$products = $repository->findBy(array("productActive" => 1, "productEventId" => $event), array('productNumber' => 'ASC'));
		$arrayProducts = Product::toArray($products);
		$data = array();
		$produts =  array();
		foreach ($arrayProducts as $prod) {
			if ($prod['product_complement'] == 1) {
				$repository = $entityManager->getRepository(TypeProduct::class);
				$typeProducts = $repository->findBy(array("typeProductActive" => 1, "typeProductProductId" => $prod['product_id']));
				$prod['type_product'] = TypeProduct::toArray($typeProducts);
			}
			
			$produts[] = $prod;
			 
		}
		
		$data["error"] = false;
		$data["status"] = null;
		$data["response"] = $produts;
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	} catch (Exception $e) {
		
		$data["status"] = 'error';
		$data["error"] = true;
		$data['message'] = $e;
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});

/** listar os Produtos usado pela App */
$app->get('/product', function (Request $request, Response $response) use ($entityManager) {
	date_default_timezone_set('America/Sao_Paulo');
	try {
		
		$data = array();
		$produtos = array();
		$concessions = array();
		
		$_GET = $request->getQueryParams();
		$id_event = $_GET['id_event'];
		$categoria = [];
		
		
		$connection = $entityManager->getConnection()->getWrappedConnection();
		$query = $connection->prepare('SELECT p.product_category_id, c.category_name_pt, c.category_name_en, c.category_name_es FROM product p INNER JOIN category c ON p.product_category_id = c.category_id
	        WHERE product_event_id = ? AND product_inventory_current > 0 AND product_active = 1 GROUP BY c.category_id');
		$query->execute(array($id_event));
		$num_rows = $query->rowCount();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		
		
		if($num_rows > 0){
			
			while ($row = $query->fetch()) {
				$category['pt'] = $row['category_name_pt'];
				$category['en'] = $row['category_name_en'];
				$category['es'] = $row['category_name_es'];
				$categoria['id'] = $row['product_category_id'];
				$categoria['name'] = $category;
				
				$query2 = $connection->prepare('SELECT * FROM product WHERE product_event_id = ? AND product_inventory_current > 0 AND product_category_id = ? AND product_active = 1');
				$query2->execute(array($id_event, $row['product_category_id']));
				$num_rows2 = $query2->rowCount();
				$query2->setFetchMode(PDO::FETCH_ASSOC);
				
				if($num_rows2 > 0) {
					while ($row2 = $query2->fetch()) {
						$product['pt'] = $row2['product_name_pt'];
						$product['en'] = $row2['product_name_en'];
						$product['es'] = $row2['product_name_es'];
						
						$desc['pt'] = $row2['product_desc_pt'];
						$desc['en'] = $row2['product_desc_en'];
						$desc['es'] = $row2['product_desc_es'];
						
						$produto['id'] = $row2['product_id'];
						$produto['number'] = $row2['product_number'];
						$produto['hour_initial'] = substr($row2['product_hour_initial'],0,5);
						$produto['hour_final'] = substr($row2['product_hour_final'],0,5);
						$produto['name'] = $product;
						$produto['image'] = $row2['product_image'];
						$produto['price'] = $row2['product_price'];
						$produto['complement'] = $row2['product_complement'];
						$produto['desc'] = $desc;
						
						$query3 = $connection->prepare('SELECT * FROM type_product WHERE type_product_product_id = ? AND type_product_active = 1');
						$query3->execute(array($row2['product_id']));
						$num_rows3 = $query3->rowCount();
						$query3->setFetchMode(PDO::FETCH_ASSOC);
						
						if($num_rows3 > 0) {
							while ($row3 = $query3->fetch()) {
								$type_product['pt'] = $row3['type_product_name_pt'];
								$type_product['en'] = $row3['type_product_name_en'];
								$type_product['es'] = $row3['type_product_name_es'];
								
								$tipo_produto['id'] = $row3['type_product_id'];
								$tipo_produto['name'] = $type_product;
								$tipo_produtos[] = $tipo_produto;
							}
						}
						
						$produto['type'] = $tipo_produtos;
						$produtos[] = $produto;
						unset($tipo_produtos);
					}
					$categoria['products'] = $produtos;
					unset($produtos);
				}
				
				$categorias[] = $categoria;
			}
			
			
			$query = $connection->prepare('SELECT event_tax_service FROM event WHERE event_id = ?');
			$query->execute(array($id_event));
			$num_rows = $query->rowCount();
			$query->setFetchMode(PDO::FETCH_ASSOC);
			
			if($num_rows > 0){
				$row = $query->fetch();
				$tax_service = $row['event_tax_service'];
			}
			
			$data["error"] = false;
			$data["products"] = $categorias;
			$data["tax_service"] = $tax_service;
		}
		
	 
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	} catch (Exception $e) {
		
		$data["status"] = 'error';
		$data["error"] = true;
		$data['message'] = $e;
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});


/** add Produtos  */
$app->post('/products/incluir', function (Request $request, Response $response) use ($entityManager) {
	
	try {
		
		$_POST = json_decode(file_get_contents('php://input'), true);
		
		
		$numero =    filter_var($_POST['numero'], FILTER_SANITIZE_STRING);
		$categoria = filter_var($_POST['categoria'], FILTER_SANITIZE_STRING);
		
		
		$hora_fim = new DateTime('1970-01-01 ' . filter_var($_POST['hora_fim'] . ':00', FILTER_SANITIZE_STRING), new DateTimeZone('America/Sao_Paulo'));
		$hora_inicio = new DateTime('1970-01-01 ' . filter_var($_POST['hora_inicio'] . ':00', FILTER_SANITIZE_STRING) , new DateTimeZone('America/Sao_Paulo'));
		
		$price =   filter_var($_POST['price'], FILTER_SANITIZE_STRING);
		$nome_en = filter_var($_POST['nome_en'], FILTER_SANITIZE_STRING);
		$nome_es = filter_var($_POST['nome_es'], FILTER_SANITIZE_STRING);
		$nome_pt = filter_var($_POST['nome_pt'], FILTER_SANITIZE_STRING);
		$desc_es = filter_var($_POST['desc_es'], FILTER_SANITIZE_STRING);
		$desc_en = filter_var($_POST['desc_en'], FILTER_SANITIZE_STRING);
		$desc_pt = filter_var($_POST['desc_pt'], FILTER_SANITIZE_STRING);
		$fast =    filter_var($_POST['fast'], FILTER_SANITIZE_STRING);
		$qtd_complemento = filter_var($_POST['qtd_complemento'], FILTER_SANITIZE_STRING);
		$company = filter_var($_POST['company'], FILTER_SANITIZE_STRING);
		$hour_timezone = filter_var($_POST['zone'], FILTER_SANITIZE_STRING);
		$full = $_POST['imageFull'];
		$thumb = $_POST['imageThumbnails'];
		
		
		
		$im = new TratarImagem();
		$im->confimarPastas($company);
		 
		$pastaRaiz = "../../events/$company/products/";
		$pastaOriginal =  "../../events/$company/products/originals/";
		
		$imagemFull = $im->save_base64_image($full, $company . '_' . $numero . '_full'
			,$pastaOriginal);
		$imagemThumb = $im->save_base64_image($thumb, $company . '_' . $numero . '_thumb'
			,$pastaOriginal );
		
		$nomeFinalArquivo = $company.'_'.$numero.'_'. preg_replace("/\s+/","_",$nome_pt). '.jpg';
		
		
		$im->compressImage($pastaOriginal.$imagemFull,$pastaRaiz."full/$nomeFinalArquivo", 85);
		$im->compressImage($pastaOriginal.$imagemThumb,$pastaRaiz."thumb/$nomeFinalArquivo",85);
		
		
		$complement = $qtd_complemento > 0 ? 1 : 0;
		$fast = $fast > 0 ? 1 : 0;
		
		$entityManager->getConnection()->beginTransaction(); // suspend auto-commit
		
		if ($numero != "" && $numero > 0) {
			
			
			$product = new Product();
			$product->setProductNumber($numero)
				->setProductCategoryId($categoria)
				->setProductHourInitial($hora_inicio)
				->setProductHourFinal($hora_fim)
				->setProductUpdateDate( new DateTime('now', new DateTimeZone($hour_timezone)))
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
				->setProductImage($nomeFinalArquivo)
				->setProductInventoryCurrent(250)
				->setProductInventoryMaximum(300)
				->setProductInventoryMinimum(10)
				->setProductInventoryQtd(250);
			
			$entityManager->persist($product);
			$entityManager->flush();
			$id = $product->getProductId();
			
			
			
			for ($i = 0; $i < $qtd_complemento; $i++) {
				$complemento_en = filter_var($_POST['complemento_en_' . $i], FILTER_SANITIZE_STRING);
				$complemento_es = filter_var($_POST['complemento_es_' . $i], FILTER_SANITIZE_STRING);
				$complemento_pt = filter_var($_POST['complemento_pt_' . $i], FILTER_SANITIZE_STRING);
				
				$typeProduct = new TypeProduct();
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



/** update Produtos  */
$app->put('/products/update', function (Request $request, Response $response) use ($entityManager) {
	
	try {
		
		$_POST = json_decode(file_get_contents('php://input'), true);
		
		$id =    filter_var($_POST['id'], FILTER_SANITIZE_STRING);
		
		$numero =    filter_var($_POST['numero'], FILTER_SANITIZE_STRING);
		$categoria = filter_var($_POST['categoria'], FILTER_SANITIZE_STRING);
		
		
		$hora_fim = new DateTime('1970-01-01 ' . filter_var($_POST['hora_fim'] . ':00', FILTER_SANITIZE_STRING), new DateTimeZone('America/Sao_Paulo'));
		$hora_inicio = new DateTime('1970-01-01 ' . filter_var($_POST['hora_inicio'] . ':00', FILTER_SANITIZE_STRING) , new DateTimeZone('America/Sao_Paulo'));
		
		$price =   filter_var($_POST['price'], FILTER_SANITIZE_STRING);
		$nome_en = filter_var($_POST['nome_en'], FILTER_SANITIZE_STRING);
		$nome_es = filter_var($_POST['nome_es'], FILTER_SANITIZE_STRING);
		$nome_pt = filter_var($_POST['nome_pt'], FILTER_SANITIZE_STRING);
		$desc_es = filter_var($_POST['desc_es'], FILTER_SANITIZE_STRING);
		$desc_en = filter_var($_POST['desc_en'], FILTER_SANITIZE_STRING);
		$desc_pt = filter_var($_POST['desc_pt'], FILTER_SANITIZE_STRING);
		$fast =    filter_var($_POST['fast'], FILTER_SANITIZE_STRING);
		$qtd_complemento = filter_var($_POST['qtd_complemento'], FILTER_SANITIZE_STRING);
		$company = filter_var($_POST['company'], FILTER_SANITIZE_STRING);
		$hour_timezone = filter_var($_POST['zone'], FILTER_SANITIZE_STRING);
		
		$roles =    filter_var($_POST['roles_id'], FILTER_SANITIZE_STRING);
		
		$complement = $qtd_complemento > 0 ? 1 : 0;
		$fast = $fast > 0 ? 1 : 0;
		
		$entityManager->getConnection()->beginTransaction(); // suspend auto-commit
		
		if ($numero != "" && $numero > 0) {
			
			$repository = $entityManager->getRepository(Product::class);
			$product = $repository->findBy(array("productId" => $id));
			
			$product  = $product[0];
			$product->setProductNumber($numero)
				->setProductCategoryId($categoria)
				->setProductHourInitial($hora_inicio)
				->setProductHourFinal($hora_fim)
				->setProductUpdateDate( new DateTime('now', new DateTimeZone($hour_timezone)))
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
				->setProductHourTimezone($hour_timezone);
			
			
			if($roles){
				$product->setProductInventoryCurrent(filter_var($_POST['inventory_current'], FILTER_SANITIZE_STRING))
					->setProductInventoryMaximum(filter_var($_POST['inventory_maximum'], FILTER_SANITIZE_STRING))
					->setProductInventoryMinimum(filter_var($_POST['inventory_minimum'], FILTER_SANITIZE_STRING))
					->setProductInventoryQtd(filter_var($_POST['inventory_qtd'], FILTER_SANITIZE_STRING));
			}
			
			$entityManager->flush();
			
			$repository = $entityManager->getRepository(TypeProduct::class);
			$typeProducts = $repository->findBy(array("typeProductActive" => 1, "typeProductProductId" => $id));
			
			foreach ( $typeProducts as $typeProduct) {
				
				$typeProduct->setTypeProductActive(0);
				$entityManager->flush();
				
			}
			
			
			
			
			for ($i = 0; $i < $qtd_complemento; $i++) {
				$complemento_en = filter_var($_POST['complemento_en_' . $i], FILTER_SANITIZE_STRING);
				$complemento_es = filter_var($_POST['complemento_es_' . $i], FILTER_SANITIZE_STRING);
				$complemento_pt = filter_var($_POST['complemento_pt_' . $i], FILTER_SANITIZE_STRING);
				
				$typeProduct = new TypeProduct();
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
		$data["message"] = "Produto atualiado com sucesso";
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	} catch (Exception $e) {
		
		$entityManager->getConnection()->rollBack();
		$data["status"] = 'error';
		$data["error"] = true;
		$data['message'] = "Erro ao atualizar produto. " . $e->getMessage();
		
		throw $e;
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});

/** update image Produtos  */
$app->put('/products/updateimage', function (Request $request, Response $response) use ($entityManager) {
	
	try {
		
		$_POST = json_decode(file_get_contents('php://input'), true);
		
		$id =    filter_var($_POST['id'], FILTER_SANITIZE_STRING);
		$company = filter_var($_POST['company'], FILTER_SANITIZE_STRING);
		$hour_timezone = filter_var($_POST['zone'], FILTER_SANITIZE_STRING);
		$full = $_POST['imageFull'];
		$thumb = $_POST['imageThumbnails'];
		$numero =    filter_var($_POST['numero'], FILTER_SANITIZE_STRING);
		$nome_pt = filter_var($_POST['nome_pt'], FILTER_SANITIZE_STRING);
		
		
		
		
		$im = new TratarImagem();
		$im->confimarPastas($company);
		
		$pastaRaiz = "../../events/$company/products/";
		$pastaOriginal =  "../../events/$company/products/originals/";
		
		$imagemFull = $im->save_base64_image($full, $company . '_' . $numero . '_full'
			,$pastaOriginal);
		$imagemThumb = $im->save_base64_image($thumb, $company . '_' . $numero . '_thumb'
			,$pastaOriginal );
		
		$nomeFinalArquivo = $company.'_'.$numero.'_'. preg_replace("/\s+/","_",$nome_pt). '.jpg';
		
		
		$im->compressImage($pastaOriginal.$imagemFull,$pastaRaiz."full/$nomeFinalArquivo", 85);
		$im->compressImage($pastaOriginal.$imagemThumb,$pastaRaiz."thumb/$nomeFinalArquivo",85);
		
		$entityManager->getConnection()->beginTransaction(); // suspend auto-commit
		
		$repository = $entityManager->getRepository(Product::class);
		$product = $repository->findBy(array("productId" => $id));
		
		$product  = $product[0];
		$product->setProductUpdateDate( new DateTime('now', new DateTimeZone($hour_timezone)))
				->setProductHourTimezone($hour_timezone)
				->setProductImage($nomeFinalArquivo);
		
		$entityManager->flush();
		$entityManager->getConnection()->commit();
		
		
		
		$data["status"] = null;
		$data["error"] = false;
		$data["message"] = "Imagem alterada com sucesso";
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	} catch (Exception $e) {
		
		$entityManager->getConnection()->rollBack();
		$data["status"] = 'error';
		$data["error"] = true;
		$data['message'] = "Erro ao alterar imagem do produto. " . $e->getMessage();
		
		throw $e;
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













//***********************************************Fim prod*****************************************************
 



