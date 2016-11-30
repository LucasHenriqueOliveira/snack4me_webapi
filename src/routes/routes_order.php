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


$app->post('/page-personal', function (Request $request, Response $response) use ($entityManager){
	
	$data = array();
	$products = array();
	
	
	try{
		$_POST = $request->getParsedBody();
		
		$email = $_POST['email'];
		$id = $_POST['id'];
		
		$connection = $entityManager->getConnection()->getWrappedConnection();
		$query = $connection->prepare('SELECT o.order_customer_id, o.order_tracking_number,e.event_name,
			DATE_FORMAT(o.order_date, "%d/%m/%Y %H:%i") as order_date,
			o.order_price_total, s.status_name_pt, s.status_name_en, s.status_name_es, o.order_id
			FROM `order` as o INNER JOIN `event` as e ON o.order_event_id = e.event_id
			INNER JOIN `status` as s ON o.order_status_id = s.status_id
			INNER JOIN `customer` as c ON order_customer_id = c.customer_id
			WHERE c.customer_email = ? and c.customer_id = ? ORDER BY o.order_id DESC');
		$query->execute(array($email, $id));
		$num_rows = $query->rowCount();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		
		if($num_rows > 0){
			$i = 0;
			while ($row = $query->fetch()){
				$date_time = explode(" ", $row['order_date']);
				
				$status['pt'] = $row['status_name_pt'];
				$status['en'] = $row['status_name_en'];
				$status['es'] = $row['status_name_es'];
				
				$order['number'] = $i;
				$order['num_order'] = $row['order_tracking_number'];
				$order['event_name'] = $row['event_name'];
				$order['status'] = $status;
				$order['date'] = $date_time[0];
				$order['hour'] = $date_time[1];
				$order['price_total'] = $row['order_price_total'];
				$order['id'] = $row['order_id'];
				$orders[] = $order;
				$i++;
			}
			
			$data["error"] = false;
			$data["response"] = $orders;
			$data["status"] = 2;
		} else{
			$mensagem['pt'] = 'Nenhum pedido encontrado.';
			$mensagem['en'] = 'Order not found.';
			
			$data["error"] = false;
			$data["message"] = $mensagem;
			$data["status"] = 1;
		}
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
		
	} catch(PDOException $e){
		$data["error"] = true;
		$data["message"] = $e->getMessage();
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});


$app->post('/rate-us', function (Request $request, Response $response) use ($entityManager){
	
	$data = array();
	
	try{
		$_POST = $request->getParsedBody();
		
		$id_order = $_POST['id_order'];
		$comment = '';
		if(isset($_POST['comment']) && !empty($_POST['comment']) && $_POST['comment'] != 'undefined') {
			$comment = $_POST['comment'];
		}
		$rate_order_question_1 = isset($_POST['rate_0']) ? $_POST['rate_0'] : null;
		$rate_order_question_2 = isset($_POST['rate_1']) ? $_POST['rate_1'] : null;
		$rate_order_question_3 = isset($_POST['rate_2']) ? $_POST['rate_2'] : null;
		
		$connection = $entityManager->getConnection()->getWrappedConnection();
		
		$query = $connection->prepare("SELECT * FROM `rate_order` WHERE `rate_order_order_id` = ? LIMIT 1");
		$query->execute(array($id_order));
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$num_rows = $query->rowCount();
		
		if($num_rows > 0){
			
			$query = $connection->prepare("UPDATE `rate_order` SET `rate_order_question_1` = ?, `rate_order_question_2` = ?, `rate_order_question_3` = ?, `rate_order_desc` = ? WHERE `rate_order_order_id` = ?");
			$query->execute(array($rate_order_question_1, $rate_order_question_2, $rate_order_question_3, $comment, $id_order));
			
			$data["error"] = false;
			$data["message"] = true;
			
		} else{
			
			$sql = "INSERT INTO `rate_order` (`rate_order_question_1`,`rate_order_question_2`,`rate_order_question_3`,
			`rate_order_desc`,`rate_order_order_id`)
			VALUES(?, ?, ?, ?, ?)";
			
			$query = $connection->prepare($sql);
			$query->execute(array($rate_order_question_1, $rate_order_question_2, $rate_order_question_3, $comment, $id_order));
			
			$data["error"] = false;
			$data["message"] = true;
		}
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
		
	} catch(PDOException $e){
		$data["error"] = true;
		$data["message"] = $e->getMessage();
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});


$app->post('/order', function (Request $request, Response $response) use ($entityManager){
	
	$data = array();
	
	try{
		
		
		$_POST = $request->getParsedBody();
		
		$products = array();
		$tipo_produtos = array();
		
		
		$order = $_POST['order'];
		$id = $_POST['id'];
		$email = $_POST['email'];
		
		
		
		
		$connection = $entityManager->getConnection()->getWrappedConnection();
			$query = $connection->prepare('SELECT *,
				DATE_FORMAT(o.order_date, "%d/%m/%Y %H:%i") as order_date,
				o.order_tax_service, s.status_name_pt, s.status_name_en, s.status_name_es, o.order_local_order_id
				FROM `order` as o INNER JOIN `event` as e ON o.order_event_id = e.event_id
				INNER JOIN `status` as s ON o.order_status_id = s.status_id
				WHERE order_id = ? and order_customer_id = ? and order_customer_email = ? LIMIT 1');
		$query->execute(array($order, $id, $email));
		$num_rows = $query->rowCount();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		
		
		if($num_rows > 0){
			$row = $query->fetch();
			$date_time = explode(" ", $row['order_date']);
			
			$input = "o=" . $row['order_id'] . "&n=" . $row['order_tracking_number'];
			$arr = array("/" => "#", "\\" => "&");
			$ve = rtrim(strtr(base64_encode(gzdeflate($input, 9)), $arr), '=');
			
			$status['pt'] = $row['status_name_pt'];
			$status['en'] = $row['status_name_en'];
			$status['es'] = $row['status_name_es'];
			 
			$pedido['id_order'] = $row['order_id'];
			$pedido['num_order'] = $row['order_tracking_number'];
			$pedido['date'] = $date_time[0];
			$pedido['hour'] = $date_time[1];
			$pedido['event_name'] = $row['event_name'];
			$pedido['status_order'] = $status;
			$pedido['ve'] = $ve;
			$pedido['floor'] = $row['order_floor'];
			$pedido['seat'] = $row['order_apartment'];
			
			 	
			$query2 = $connection->prepare('SELECT i.item_price_total,i.item_price_unit,i.item_quantity, i.item_product_id, i.item_id,
				p.product_name_pt, p.product_name_en, p.product_name_es,
                                p.product_desc_pt, p.product_desc_en, p.product_desc_es
				FROM item as i INNER JOIN product as p ON i.item_product_id = p.product_id
				WHERE item_order_id = ?');
			$query2->execute(array($order));
			$query2->setFetchMode(PDO::FETCH_ASSOC);
			
			while ($row2 = $query2->fetch()){
				
				$query3 = $connection->prepare('SELECT 	 i.item_type_product_desc, i.item_type_product_type_product_id
                                      FROM item_type_product as i
                                      WHERE i.item_type_product_product_id = ? AND i.item_type_product_item_id = ?');
				$query3->execute(array($row2['	item_product_id'], $row2['item_id']));
				
				$tipo_produtos = array();
				while ($row3 = $query3->fetch()){
					if($row3['item_type_product_type_product_id']) {
						$query4 = $connection->prepare('SELECT t.type_product_name_pt, t.type_product_name_en, t.type_product_name_es
                                                      FROM type_product as t
                                                      WHERE t.type_product_id = ?');
						$query4->execute(array($row3['item_type_product_type_product_id']));
						$row4 = $query4->fetch();
						
						$tipo_produto_nome['pt'] = $row4['type_product_name_pt'];
						$tipo_produto_nome['en'] = $row4['type_product_name_en'];
						$tipo_produto_nome['es'] = $row4['type_product_name_es'];
						
						$tipo_produto['name'] = $tipo_produto_nome;
					}
					$tipo_produto['comment'] = $row3['item_type_product_desc'];
					$tipo_produto['id'] = $row3['item_type_product_type_product_id'];
					$tipo_produtos[] = $tipo_produto;
				}
				
				$produto['pt'] = $row2['product_name_pt'];
				$produto['en'] = $row2['product_name_en'];
				$produto['es'] = $row2['product_name_es'];
				
				$produto_des['pt'] = $row2['product_desc_pt'];
				$produto_des['en'] = $row2['product_desc_en'];
				$produto_des['es'] = $row2['product_desc_es'];
				
				$product['name'] = $produto;
				$product['desc'] = $produto_des;
				$product['type'] = $tipo_produtos;
				$product['price_unit']  = $row2['item_price_unit'];
				$product['quantity']    = $row2['item_quantity'];
				$product['price_total'] = $row2['item_price_total'];
				$products[] = $product;
			}
			
			$query5 = $connection->prepare('SELECT local_order_name_pt, local_order_name_en, local_order_name_es
                              FROM local_order
                              WHERE local_order_id = ?');
			$query5->execute(array($row['order_local_order_id']));
			$row5 = $query5->fetch();
			
			$local['pt'] = $row5['local_order_name_pt'];
			$local['en'] = $row5['local_order_name_es'];
			$local['es'] = $row5['local_order_name_en'];
			
			$pedido['local'] = $local;
			$pedido['products'] = $products;
			$pedido['price'] = $row['order_price'];
			$pedido['discount'] = $row['order_price_discount'];
			$pedido['tax_service'] = $row['order_tax_service'];
			$pedido['price_total'] = $row['order_price_total'];
			
			$data["error"] = false;
			$data["response"] = $pedido;
			$data["status"] = 2;
			
		} else{
			$mensagem['pt'] = 'Nenhum pedido encontrado.';
			$mensagem['es'] = 'No hay pedidos.';
			$mensagem['en'] = 'Order not found.';
			
			$data["error"] = false;
			$data["message"] = $mensagem;
			$data["status"] = 1;
		}
		
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
		
	} catch(PDOException $e){
		$data["error"] = true;
		$data["message"] = $e->getMessage();
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});

$app->post('/checkout', function (Request $request, Response $response) use ($entityManager){
	
	$data = array();
	$arrItem = array();
	$connection = $entityManager->getConnection()->getWrappedConnection();
	
	
	try{
		$_POST = $request->getParsedBody();
		
		$num_products = filter_var($_POST['num_products'], FILTER_SANITIZE_NUMBER_INT);
		$prod_qtd = array();
		$itens = 0;
		
		$products = ' AND (';
		for($i = 0; $i < $num_products; $i++){
			if($_POST['qtd_product_'.$i] > 0){
				$itens++;
				$products .= 'product_id = '.$_POST['id_product_'.$i] . ' OR ';
				$prod_qtd[$_POST['id_product_'.$i]] = $_POST['qtd_product_'.$i];
			}
		}
		$products = substr($products,0,-3);
		$products .= ')';
		
		$arrIdProducts = explode("|", $_POST['id_products']);
		$arrTypeProducts = explode("|", $_POST['type_products']);
		$arrCommentProducts = explode("|", $_POST['comment_products']);
		
		$id_event = filter_var($_POST['id_event'], FILTER_SANITIZE_NUMBER_INT);
		$seat = $_POST['seat'];
		$floor = $_POST['floor'];
		$coupon = '';
		$coupon_number = '';
		$coupon_tax = '';
		$coupon_id = null;
		$num_rows3 = 0;
		$id_user = filter_var($_POST['id_user'], FILTER_SANITIZE_NUMBER_INT);
		$email = $_POST['email'];
		$name = $_POST['name'];
		$order_tracking_number = $id_user . date('ymdHi');
		$local = $_POST["local"];
		$lang = $_POST["lang"];
		$schedule_time = '';
		$schedule = 0;
		
		if(isset($_POST["schedule"]) && !empty($_POST['schedule']) && $_POST['schedule'] != 'undefined'){
			$schedule = new DateTime($_POST["schedule"]);
			$now = new DateTime();
			$schedule_time = $schedule->format('H:i:s');
			$now = $now->format('H:i:s');
			$schedule = 1;
			
			if($schedule_time < $now){
				$data["error"] = true;
				$data["status"] = 1;
				$data["message"] = "Horário do agendamento deve ser maior ou igual que horário atual!";
				return $response->withStatus(200)
					->withHeader("Content-Type", "application/json")
					->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
			}
		} else {
			$now = new DateTime();
			$schedule_time = $now = $now->format('H:i:s');
			$schedule = 0;
		}
		
		if(isset($_POST['coupon']) && !empty($_POST['coupon']) && $_POST['coupon'] != 'null'){
			$coupon = filter_var($_POST['coupon'], FILTER_SANITIZE_MAGIC_QUOTES);
			
		 
			$sql3 = 'SELECT c.coupon_number, c.coupon_tax, c.coupon_id, c.coupon_event_id FROM `coupon` as c WHERE c.coupon_number = ? AND coupon_sin_used="N"';
			
			$query3 = $connection->prepare($sql3);
			$query3->execute(array($coupon));
			$num_rows3 = $query3->rowCount();
			$query3->setFetchMode(PDO::FETCH_ASSOC);
			
			if($num_rows3 > 0){
				$row3 = $query3->fetch();
				if($row3['coupon_event_id'] == '' || $row3['coupon_event_id'] == $id_event){
					$coupon_number = $row3['coupon_event_id'];
					$coupon_tax = $row3['coupon_tax'];
					$coupon_id = $row3['coupon_id'];
				}
			}
		}
		
		$sql2 = 'SELECT e.event_tax_service FROM `event` as e WHERE e.event_id = ?';
		
		$query2 = $connection->prepare($sql2);
		$query2->execute(array($id_event));
		$query2->setFetchMode(PDO::FETCH_ASSOC);
		$row2 = $query2->fetch();
		
		$tax_service = $row2['event_tax_service'];
		 
		$sql = 'SELECT `product_id`,`product_name_pt`, `product_name_en`, `product_name_es`,`product_price` FROM product WHERE product_event_id = ?'. $products;
		$query = $connection->prepare($sql);
		$query->execute(array($id_event));
		$num_rows = $query->rowCount();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		
		if($num_rows > 0){
			$total = 0;
			$i = 0;
			$product[] = array();
			$subtotal = 0;
			while ($row = $query->fetch()){
			 
				$subtotal += $row['product_price'] * $prod_qtd[$row['product_id']];
				
				$product[$i]['id'] = $row['product_id'];
				$product[$i]['price'] = $row['product_price'];
				$product[$i]['quantity'] = $prod_qtd[$row['product_id']];
				$product[$i]['subtotal'] = number_format( $row['product_price'] * $prod_qtd[$row['product_id']] ,2);
				$i++;
			}
			
			if($num_rows3 > 0){
				$discount = number_format($subtotal * $coupon_tax,2);
				$total = number_format($subtotal - $discount,2);
			} else{
				$discount = '0.00';
				$total = number_format($subtotal,2);
			}
			$subtotal = number_format($subtotal, 2);
			$date = date('Y-m-d H:i:s');
			
			try{
				$connection->beginTransaction();
				
				$sql = "INSERT INTO `order`  (`order_customer_id`,
                            `order_customer_email`,
                            `order_tracking_number`,
                            `order_date`,
                            `order_apartment`,
                            `order_floor`,
                            `order_local_order_id`,
                            `order_price`,
                            `order_price_discount`,
                            `order_tax_service`,
                            `order_price_total`,
                            `order_coupon_id`,
                            `order_event_id`,
                            `order_schedule_date`,
                            `order_schedule`,
                            `order_status_id`)
      VALUES(" . $id_user . ", '" . $email . "', '" . $order_tracking_number . "', '" . $date . "', '" . $seat . "',
      '" . $floor . "', '" . $local . "', " . $subtotal . ",
      " . $discount . ", " . $tax_service . ", " . $total . ", '" . $coupon_id . "', " . $id_event . ", '" . $schedule_time . "' , '" . $schedule . "' ,1)";
				
				$query = $connection->prepare($sql);
				$query->execute();
				
				$order_id = $connection->lastInsertId();
				
				
				for($i = 0; $i < count($product); $i++){
					
					$sql = "INSERT INTO item (`item_order_id`, `item_product_id`,
        `item_price_unit`, `item_quantity`, `item_price_total`)
        VALUES(" . $order_id . ", " . $product[$i]['id'] . ",
        " . $product[$i]['price'] . ", " . $product[$i]['quantity'] . ", " . $product[$i]['subtotal'] . ")";
					
					$query = $connection->prepare($sql);
					$query->execute();
					
					$item_id = $connection->lastInsertId();
					
					$arrItem[$product[$i]['id']] = $item_id;
					
					// SUBTRAI A QUANTIDADE NO ESTOQUE
					$sql5 = "UPDATE product
                SET product_inventory_current = product_inventory_current - " . $product[$i]['quantity'] . "
            WHERE product_id = ?";
					$query5 = $connection->prepare($sql5);
					$query5->execute(array($product[$i]['id']));
					
				}
				
				
				for($i = 0; $i < count($arrIdProducts); $i++){
					$type_product = 'null';
					
					if($arrTypeProducts[$i] != ''){
						$type_product = explode("*", $arrTypeProducts[$i]);
						
						for($a = 0; $a < count($type_product); $a++){
							$sql = "INSERT INTO item_type_product (`item_type_product_desc`, `item_type_product_item_id`,
                          `item_type_product_type_product_id`, `item_type_product_product_id`)
                          VALUES('" . $arrCommentProducts[$i] . "', " . $arrItem[$arrIdProducts[$i]] . ",
                          " . $type_product[$a] . ", " . $arrIdProducts[$i] . ")";
							
							$query = $connection->prepare($sql);
							$query->execute();
						}
						
					} else {
						$sql = "INSERT INTO item_type_product (`item_type_product_desc`, `item_type_product_item_id`,
                          `item_type_product_type_product_id`, `item_type_product_product_id`)
                          VALUES('" . $arrCommentProducts[$i] . "', " . $arrItem[$arrIdProducts[$i]] . ",
                          " . $type_product . ", " . $arrIdProducts[$i] . ")";
						
						$query = $connection->prepare($sql);
						$query->execute();
					}
					
				}
				
				$connection->commit();
				
				$input = "o=" . $order_id . "&n=" . $order_tracking_number;
				$arr = array("/" => "#", "\\" => "&");
				$ve = rtrim(strtr(base64_encode(gzdeflate($input, 9)), $arr), '=');
				
				try{
					include ('lib/utilities.php');
					
					$titulo = $order_tracking_number . ".pdf";
					$html = geraHTML($order_id, $lang);
					$bolPDF = geraPDF($titulo, $html);
					
					if($lang == 'pt') {
						
						$assunto = "Pedido realizado - " . $order_tracking_number;
						$message = "Prezado(a), a Snack4me agradece pelo pedido realizado. Você pode verificar o status do seu pedido fazendo login em sua conta. Confirmação do seu pedido está em anexo.<br /><br />";
						
						$message .= "Obrigado<br /><a href='http://www.snack4me.com' target='_blank'><img src='http://www.snack4me.com/hotel/images/logo_small.png' title='Snack4me'></a><br /><br />";
						$message .= "<span style='font-size:9px;color:#d5d5d5'>Favor não responder o email.</span><br />";
						
					} else if ($lang == 'es') {
						
						$assunto = "Order done - " . $order_tracking_number;
						$message = "Dear, the Snack4me appreciates the order placed. You can check the status of your order by logging into your account. Your order confirmation is attached.<br /><br />";
						
						$message .= "Thank you<br /><a href='http://www.snack4me.com' target='_blank'><img src='http://www.snack4me.com/hotel/images/logo_small.png' title='Snack4me'></a><br /><br />";
						$message .= "<span style='font-size:9px;color:#d5d5d5'>Please don't respond to email.</span><br />";
						
					} else {
						
						$assunto = "Order done - " . $order_tracking_number;
						$message = "Dear, the Snack4me appreciates the order placed. You can check the status of your order by logging into your account. Your order confirmation is attached.<br /><br />";
						
						$message .= "Thank you<br /><a href='http://www.snack4me.com' target='_blank'><img src='http://www.snack4me.com/hotel/images/logo_small.png' title='Snack4me'></a><br /><br />";
						$message .= "<span style='font-size:9px;color:#d5d5d5'>Please don't respond to email.</span><br />";
					}
					
					$envia_email = enviarEmail($name, $email, $assunto, $message, $tipo = $bolPDF, $titulo);
					
					$dados['id_order'] = $order_id;
					$dados['num_order'] = $order_tracking_number;
					$dados['ve'] = $ve;
					
					$data["error"] = false;
					$data["status"] = 2;
					$data["response"] = $dados;
					
				} catch (Exception $e){
					
					$assunto = "Erro no envio de email";
					$message = "Erro no envio de email do pedido ".$order_tracking_number."<br /><br />";
					$name = "Erro Sales";
					$email = "sales@snack4me.com";
					
					$envia_email = enviarEmail($name, $email, $assunto, $message);
					
					$dados['id_order'] = $order_id;
					$dados['num_order'] = $order_tracking_number;
					$dados['ve'] = $ve;
					
					$data["error"] = false;
					$data["status"] = 2;
					$data["response"] = $dados;
				}
			} catch (Exception $e){
				$connection->rollBack();
				
				$data["error"] = true;
				$data["status"] = 1;
				$data["message"] = "Erro ao salvar dados do pedido!";
			}
			
		} else{
			$data["error"] = true;
			$data["status"] = 1;
			$data["message"] = 'Erro ao salvar dados do pedido.';
		}
			
			                                                                   
		
		
		return $response->withStatus(200)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
		
	} catch(PDOException $e){
		$data["error"] = true;
		$data["message"] = $e->getMessage();
		return $response->withStatus(500)
			->withHeader("Content-Type", "application/json")
			->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
	
});

