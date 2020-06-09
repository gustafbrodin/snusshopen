<?php
	require('../src/config.php');
	
	include('layout/header.php');

	echo "<pre>";
	print_r($_POST);
	echo "</pre>";

	if (!empty($_POST['quantity'])) {
		$productId = (int) $_POST['productId'];
		$quantity = (int) $_POST['quantity'];
	

		try {

			$query = "SELECT * FROM products 
					WHERE id = :id;";
					
			$stmt = $dbconnect->prepare($query);
			$stmt->bindvalue(':id', $_POST['productId']);
			$stmt->execute();
			$product = $stmt->fetch();
		}   catch (\PDOException $e) {
			throw new \PDOException($e->getMessage(), (int) $e->getCode());
			}

		if ($product) {
			$product = array_merge($product, ['quantity' => $quantity]);
			echo "<pre>";
			print_r($product);
			echo "</pre>";

			$cartItem = [$productId => $product];

			echo "<pre>";
			print_r($cartItem);
			echo "</pre>";

			$_SESSION['cartItems'] = $cartItem;
		}
	}

	header('Location: index.php');
	exit;
?>
