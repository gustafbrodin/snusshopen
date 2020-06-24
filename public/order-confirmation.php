<?php
	require('../src/config.php');

  $cartItemCount = count($_SESSION['cartItems']);
  $cartTotalSum = 0;
  foreach ($_SESSION['cartItems'] as $cartId => $cartItem) {
	$cartTotalSum += $cartItem['price'] * $cartItem['quantity'];
}


if (empty($_SESSION['cartItems'])) {
  header('Location: index.php');
  exit;
}

$cartItems = $_SESSION['cartItems'];
unset($_SESSION['cartItems']);

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
        <div class="container d-flex justify-content-between">
          <h1 class="text-center text-white" style="font-family: 'Dosis', sans-serif;">Snusshopen</h1>
          <a href="index.php" class="navbar-brand d-flex align-items-center ml-5">
            <strong>Hem</strong>
          </a>
          <?php 
          if (isset($_SESSION['email'])){  
            try {
    
            $query = "SELECT * FROM users 
                      WHERE email = :email;";
            $stmt = $dbconnect->prepare($query);
            $stmt->bindvalue(':email', $_SESSION['email']);
            $stmt->execute();
            $user = $stmt->fetch();
          }   catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
                              }}

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
    <br>
    <h1 style="text-align:center;">Tack för din order!</h1>
    <br>
    <p style="text-align:center;"> Vi har mottagit din order och kommer behandla detta så fort som möjligt. Du kommer få orderbekräftelse via e-post. Vid frågor kontakta gärna vår support! </p>

	<div class="px-5">
		<table class="table table-borderless">
			<thead>
				<tr>
					<th style="width: 15%">Produkt</th>
					<th style="width: 50%">Info</th>
                    <th style="width: 15%">Pris</th>
					<th style="width: 10%">Antal</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($cartItems as $cartId => $cartItem) { ?>  
				<tr>
					<td ><img src="img/<?=$cartItem['img_url']?>" width="100px"></td>
					<td class="align-middle"><?=$cartItem['title']?></td>
                    <td><?=$cartItem['price']?> kr</td>
					<td><?=$cartItem['quantity']?></td>
          
          
				</tr>
				<?php } ?> 
        <tr class="border-top">
          <td></td>
          <td></td>
          <td></td>
          <td><b>Totalt: <?=$cartTotalSum?> kr</b></td>
        </tr>
			</tbody>
		</table>
	</div>


<?php
include('layout/footer.php');
?>  

