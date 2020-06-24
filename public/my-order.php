<?php

    require('../src/config.php');
    
    if (!isset($_SESSION['email'])) {
	    header("location: login.php?mustLogin");
	    }
    
try {

    $query = "
        SELECT * FROM orders 
        WHERE id = :id;
    
    
    ";
            
    $stmt = $dbconnect->prepare($query);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
    $order = $stmt->fetch();
}   catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }

///Lista över vad man har beställt.

    try {

        $query = "
            SELECT * FROM order_items
            WHERE order_id = :id;
        
        
        ";
                
        $stmt = $dbconnect->prepare($query);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();
        $orderItems = $stmt->fetchAll();
    }   catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
//// Hämtar info om användare

        try {

            $query = "
                SELECT * FROM users
                WHERE id = :id;
            
            
            ";
                    
            $stmt = $dbconnect->prepare($query);
            $stmt->bindValue(':id', $order['user_id']);
            $stmt->execute();
            $user = $stmt->fetch();
        }   catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
            }

       
    
    

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@800&display=swap" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet">
			
      
	<title>Snusshopen</title>
</head>
<body>


	<header>
      <nav class="navbar navbar-dark bg-primary box-shadow" style="background: linear-gradient(135deg,#1e5799,#035b79 0,#498ca3); color: white;">
        <div class="container-fluid d-flex justify-content-between" style="margin-left:100px;">
          <h1 class="text-center text-white" style="font-family: 'Dosis', sans-serif;">Snusshopen</h1>
          <a href="index.php" class="navbar-brand d-flex align-items-center ml-5">
            <strong>Hem</strong>
          </a>
          <?php 
          

          if (isset($_SESSION['email'])) {
            // ucfirst() turns the first letter to a capital letter, in a string
            $loggedInUsername = htmlentities(ucfirst($user['first_name'])); 
            $aboveNav = "Välkommen $loggedInUsername | <a href='mypage.php'>Mina sidor</a> | <a href='logout.php'>Logga ut</a>";
          } else {
            $aboveNav = "<a href='register.php' class='ml-auto'>Registrera dig</a> | <a href='login.php'>Logga in</a>";
          }

          echo $aboveNav;
          
        ?>
        <a href="index.php" class="ml-5">Fortsätt handla</a>
        </div>
        </nav>
    </header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light ">
    <div class="collapse navbar-collapse offset-5" id="navbarNav">
        <ul class="navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="mypage.php">Mina uppgifter <span class="sr-only">(current)</span></a>
        </li>  
        <li class="nav-item active">
            <a class="nav-link" href="my-orders.php">Mina beställningar <span class="sr-only">(current)</span></a>
        </li>
        </ul>
    </div>
    </nav>


	<div class="px-5">
		<table class="table table-borderless table-hover">
			<thead>
            <table class="table table-borderless">
			<thead>
				<tr>
                    <th style="width: 15%">Produkt</th>
					<th style="width: 10%">Pris</th>
                    <th style="width: 10%">Antal</th>
                    <th style="width: 10%">Total summa</th> 
				</tr>
			</thead>
			<tbody>
				<?php foreach ($orderItems as $orderItemsId => $orderItem) { ?>  
				<tr>

                    <td><?=$orderItem['product_title']?></td>
					<td><?=$orderItem['unit_price']?> kr</td>
                    <td><?=$orderItem['quantity']?> st</td>
                    <td><?=$order['total_price']?> kr</td>
          
				</tr>
				<?php } ?> 

			</tbody>
		</table>
			</tbody>
		</table>

        <a href="my-orders.php" class="btn btn-primary">Tillbaka</a>
        </div>
<?php
include('layout/footer.php');
?>  

