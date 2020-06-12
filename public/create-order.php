<?php

require('../src/config.php');


if (!isset($_SESSION['cartItems'])) {
	$_SESSION['cartItems'] = [];
}



$cartItemCount = count($_SESSION['cartItems']);
$cartTotalSum = 0;
foreach ($_SESSION['cartItems'] as $cartId => $cartItem) {
	$cartTotalSum += $cartItem['price'] * $cartItem['quantity'];
}

echo "<pre>";
print_r($_POST);
echo "</pre>";


if (isset($_POST['createOrderBtn'])) {
    $firstName        = trim($_POST['firstName']);
    $lastName         = trim($_POST['lastName']);
    $email             = trim($_POST['email']);
    $password          = trim($_POST['password']);
    $phone             = trim($_POST['phone']);
    $street            = trim($_POST['street']);
    $postalCode       = trim($_POST['postalCode']);
    $city              = trim($_POST['city']);
    $country           = trim($_POST['country']);
    $totalPrice        = trim($_POST['totalPrice']);

    try {
    	$query = "
            SELECT * FROM users 
            WHERE email = :email";
        $stmt = $dbconnect->prepare($query);
        $stmt -> bindvalue(':email', $email);
        $stmt -> execute();
    	$user = $stmt->fetch();
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
    
    if ($user) {
       $userId = $user['id'];
    } else {
            try {
                $query = "INSERT INTO users (first_name, last_name, email, password, phone, street, postal_code, city, country)
                VALUES ( :firstName, :lastName, :email, :password, :phone, :street, :postalCode, :city, :country);";
                $stmt = $dbconnect->prepare($query);
                $stmt->bindValue(':firstName', $firstName);
                $stmt->bindValue(':lastName', $lastName);
                $stmt->bindValue(':email', $email);
                $stmt->bindValue(':password', $password);
                $stmt->bindValue(':phone', $phone);
                $stmt->bindValue(':street', $street);
                $stmt->bindValue(':postalCode', $postalCode);
                $stmt->bindValue(':city', $city);
                $stmt->bindValue(':country', $country);
                $stmt->execute();
                $userId = $dbconnect->lastInsertId();
            }   catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int) $e->getCode());
                }
    }

    echo "<pre>";
    print_r($user);
    echo "</pre>";

   
    
    try {
                $query = "INSERT INTO orders (user_id, total_price, billing_full_name, billing_street, billing_postal_code, billing_city, billing_country)
                VALUES (:userId, :totalPrice, :fullName, :street, :postalCode, :city, :country);";
                $stmt = $dbconnect->prepare($query);
                $stmt->bindValue(':userId', $userId);
                $stmt->bindValue(':totalPrice', $totalPrice);
                $stmt->bindValue(':fullName', "{$firstName} {$lastName}");
                $stmt->bindValue(':street', $street);
                $stmt->bindValue(':postalCode', $postalCode);
                $stmt->bindValue(':city', $city);
                $stmt->bindValue(':country', $country);
                $stmt->execute();
                $orderId = $dbconnect->lastInsertId();
        }       catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int) $e->getCode());
                }

    foreach ($_SESSION['cartItems'] as $cartId => $cartItem) {
        try {
            $query = "INSERT into order_items (order_id, product_id, quantity, unit_price, product_title)
            VALUE (:orderId, :productId, :quantity, :price, :title);";
            $stmt = $dbconnect->prepare($query);
            $stmt->bindValue(':orderId', $orderId);
            $stmt->bindValue(':productId', $cartItem['id']);
            $stmt->bindValue(':quantity', $cartItem['quantity']);
            $stmt->bindValue(':price', $cartItem['price']);
            $stmt->bindValue(':title', $cartItem['title']); 
            $stmt -> execute();
        }   catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
            }
        }
        
        header('Location: order-confirmation.php');
            exit;

}
header('Location: checkout.php');
            exit;

