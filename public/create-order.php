<?php

echo "<pre>";
print_r($_POST);
echo "</pre>";
exit;

if (isset($_POST['createOrderBtn'])) {
    $first_name        = trim($_POST['first_name']);
    $last_name         = trim($_POST['last_name']);
    $email             = trim($_POST['email']);
    $password          = trim($_POST['password']);
    $phone             = trim($_POST['phone']);
    $street            = trim($_POST['street']);
    $postal_code       = trim($_POST['postal_code']);
    $city              = trim($_POST['city']);
    $country           = trim($_POST['country']);

    try {
    	$query = "
            SELECT * FROM users 
            WHERE email = :email";
        $stmt = $dbconnect->prepare($query);
        $stmt = bindvalue(':email', $email);
        $stmt = execute();
    	$user = $stmt->fetch();
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
    
    if ($user) {
       $userId = $user['id'];
    } else {
            try {
                $query = "INSERT INTO users (first_name, last_name, email, password, phone, street, postal_code, city, country)
                VALUES ( :first_name, :last_name, :email, :password, :street, :postal_code, :city, :country)";
                $stmt = $dbconnect->prepare($query);
                $stmt->bindValue(':first_name', $first_name);
                $stmt->bindValue(':last_name', $last_name);
                $stmt->bindValue(':email', $email);
                $stmt->bindValue(':password', $password);
                $stmt->bindValue(':phone', $phone);
                $stmt->bindValue(':street', $street);
                $stmt->bindValue(':postal_code', $postal_code);
                $stmt->bindValue(':city', $city);
                $stmt->bindValue(':country', $country);
                $stmt = execute();
                $userId = $dbconnect->lastInsertId();
            }   catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int) $e->getCode());
                }
    }


    try {
                $query = "INSERT INTO orders (user_id, total_price, billing_full_name, billing_street, billing_postal_code, billing_city, billing_country)
                VALUES ( :user_id, :total_price, :billing_full_name, :billinng_street, :billing_postal_code, :billing_city, :billing_country)";
                $stmt = $dbconnect->prepare($query);
                $stmt->bindValue(':user_id', $user_id);
                $stmt->bindValue(':total_price', $total_price);
                $stmt->bindValue(':full_name', "{$first_name} {$last_name}");
                $stmt->bindValue(':street', $street);
                $stmt->bindValue(':postal_code', $postal_code);
                $stmt->bindValue(':city', $city);
                $stmt->bindValue(':country', $country);
                $stmt = execute();
                $userId = $dbconnect->lastInsertId();
        }       catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int) $e->getCode());
                }
    foreach ($_SESSION['cartItems'] as $cartId => $cartItem) {
        try {
            $query = "INSERT into order_items (order_id, product_id, quantity, unit_price, product_titel)
            VALUE (:order_id, :product_id, :quantity, :unit_price, :product_titel)";
            $stmt = $dbconnect->prepare($query);
            $stmt->bindValue(':order_id', $order_id);
            $stmt->bindValue(':product_id', $cartItem['id']);
            $stmt->bindValue(':quantity', $cartItem['quantity']);
            $stmt->bindValue(':unit_price', $cartItem['price']);
            $stmt->bindValue(':product_titel', $cartItem['titel']); 
            $stmt = execute();
        }   catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
            }
        }

}