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

$first_name      = '';
$last_name       = '';
$email           = '';
$phone           = '';
$street          = '';
$postal_code     = '';
$city            = '';
$country         = '';
$error           = '';
$msg             = '';
if (isset($_POST['register'])) {
    $first_name        = trim($_POST['first_name']);
    $last_name         = trim($_POST['last_name']);
    $email             = trim($_POST['email']);
    $password          = trim($_POST['password']);
    $confirmPassword   = trim($_POST['confirmPassword']);
    $phone             = trim($_POST['phone']);
    $street            = trim($_POST['street']);
    $postal_code       = trim($_POST['postal_code']);
    $city              = trim($_POST['city']);
    $country           = trim($_POST['country']);

    if (empty($first_name)) {
        $error .= "<li>förnamnet är obligatoriskt</li>";
    }
    if (empty($last_name)) {
        $error .= "<li>efternamnet är obligatoriskt</li>";
    }
    if (empty($email)) {
        $error .= "<li>E-post är obligatoriskt</li>";
    }
    if (empty($phone)) {
        $error .= "<li>Telefonnummer är obligatoriskt</li>";
    }
    if (empty($street)) {
        $error .= "<li>Adress är obligatoriskt</li>";
    }
    if (empty($postal_code)) {
        $error .= "<li>Postkod är obligatoriskt</li>";
    }
    if (empty($city)) {
        $error .= "<li>Stad är obligatoriskt</li>";
    }
    if (empty($country)) {
        $error .= "<li>Land är obligatoriskt</li>";
    }
    if (!empty($password) && strlen($password) < 6) {
        $error .= "<li>Lösenordet får inte vara mindre än 6 tecken lång</li>";
    }
    if ($confirmPassword !== $password) {
        $error .= "<li>Det bekräftade lösenordet matchar inte</li>";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error .= "<li>Ogiltig e-post</li>";
    }
    

    if ($error) {
        $msg = "<ul class='error_msg'>{$error}</ul>";
    }
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

	<div class="px-5">
		<table class="table table-borderless">
			<thead>
				<tr>
					<th style="width: 15%">Produkt</th>
					<th style="width: 50%">Info</th>
          <th style="width: 15%">Pris</th>
					<th style="width: 10%">Antal</th>
					<th style="width: 30%"></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($_SESSION['cartItems'] as $cartId => $cartItem) { ?>  
				<tr>
					<td ><img src="img/<?=$cartItem['img_url']?>" width="100px"></td>
					<td class="align-middle"><?=$cartItem['title']?></td>
          <td><?=$cartItem['price']?> kr</td>
					<td>
            <form class="update-cart-form" action="update-cart-item.php" method="POST">
              <input type="hidden" name="cartId" value="<?=$cartId?>">
              <input type="number" name="quantity" value="<?=$cartItem['quantity']?>" min="0" class="quantity">
            </form>
          </td>
          
					<td >
						<form action="delete-cart-item.php" method="POST">
							<input type="hidden" name="cartId" value="<?=$cartId?>">
							<button type="submit" class="btn mt-n1">
								<svg class="bi bi-trash" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
									<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
									<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
								</svg>
							</button>
						</form>
					</td>
          
				</tr>
				<?php } ?> 
        <tr class="border-top">
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td><b>Totalt: <?=$cartTotalSum?> kr</b></td>
        </tr>
			</tbody>
		</table>

  <?php if (isset($_SESSION['email'])){ ?>      
	<div> 
    <form action="create-order.php" method="POST">
    <?=$msg?>
      <input type="hidden" name="totalPrice" value="<?=$cartTotalSum?>">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputEmail4">Förnamn</label>
          <input type="text" class="form-control" name="firstName" value="<?=htmlentities($user['first_name'])?>" placeholder="Förnamn" required>
        </div>
        <div class="form-group col-md-6">
          <label for="inputPassword4">Efternamn</label>
          <input type="text" class="form-control" name="lastName" value="<?=htmlentities($user['last_name'])?>" placeholder="Efternamn" required>
        </div>
      </div>
      <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputAddress">Adress</label>
        <input type="text" class="form-control" value="<?=htmlentities($user['street'])?>" placeholder="Adress" name="street" required>
      </div>
      <div class="form-group col-md-6">
          <label for="inputZip">Postnummer</label>
          <input type="text" class="form-control" value="<?=htmlentities($user['postal_code'])?>" name="postalCode" required>
        </div>
      <div class="form-group col-md-6">
        <label for="inputAddress">E-post</label>
        <input type="email" class="form-control" name="email" value="<?=htmlentities($user['email'])?>" placeholder="E-post" required>
      </div> 
      <div class="form-group col-md-6">
      <label for="inputPassword4">Lösenord</label>
      <input type="password" class="form-control" placeholder="Lösenord" name="password" value="<?=htmlentities($user['password'])?>" required>
      </div>
      </div>
      <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputPhone">Telefonnummer</label>
        <input type="number" class="form-control" name="phone" value="<?=htmlentities($user['phone'])?>" placeholder="Telefonnummer" required>
      </div>
        <div class="form-group col-md-3">
          <label for="inputCity">Stad</label>
          <input type="text" class="form-control" value="<?=htmlentities($user['city'])?>" name="city" required >
        </div>
        <div class="form-group col-md-3">
          <label for="inputState">Land</label>
          <select  name="country" class="form-control" value="<?=htmlentities($country)?>" required>
            
            <option value="SE">Sverige</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="gridCheck" required>
          <label class="form-check-label" for="gridCheck">
            Jag har läst och godkänner villkoren
          </label>
        </div>
      </div>

<?php } else { ?>

  
	<div> 
    <form action="create-order.php" method="POST">
    <?=$msg?>
      <input type="hidden" name="totalPrice" value="<?=$cartTotalSum?>">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputEmail4">Förnamn</label>
          <input type="text" class="form-control" name="firstName" placeholder="Förnamn" required>
        </div>
        <div class="form-group col-md-6">
          <label for="inputPassword4">Efternamn</label>
          <input type="text" class="form-control" name="lastName" placeholder="Efternamn" required>
        </div>
      </div>
      <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputAddress">Adress</label>
        <input type="text" class="form-control"  placeholder="Adress" name="street" required>
      </div>
      <div class="form-group col-md-6">
          <label for="inputZip">Postnummer</label>
          <input type="text" class="form-control" name="postalCode" required>
        </div>
      <div class="form-group col-md-6">
        <label for="inputAddress">E-post</label>
        <input type="email" class="form-control" name="email"  placeholder="E-post" required>
      </div> 
      <div class="form-group col-md-6">
      <label for="inputPassword4">Lösenord</label>
      <input type="password" class="form-control" placeholder="Lösenord" name="password" required>
      </div>
      </div>
      <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputPhone">Telefonnummer</label>
        <input type="number" class="form-control" name="phone" placeholder="Telefonnummer" required>
      </div>
        <div class="form-group col-md-3">
          <label for="inputCity">Stad</label>
          <input type="text" class="form-control" name="city" required>
        </div>
        <div class="form-group col-md-3">
          <label for="inputState">Land</label>
          <select name="country" class="form-control" required>
            <option selected value="">Välj</option>
            <option value="SE">Sverige</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="gridCheck"  required>
          <label class="form-check-label" for="gridCheck">
            Jag har läst och godkänner villkoren
          </label>
        </div>
      </div>
      <?php } ?>
      
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" name="billingAdress" type="checkbox" id="checkbox" onclick="myFunction()">
          <label class="form-check-label" for="checkbox">
            Jag har en annan fakturaadress
          </label>
        </div>
      </div>

      
        <div id="billing" style="display:none"> 
        
        
          <input type="hidden" name="totalPrice" value="<?=$cartTotalSum?>">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Förnamn</label>
              <input type="text" class="form-control" name="billingFirstName" placeholder="Förnamn" >
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword4">Efternamn</label>
              <input type="text" class="form-control" name="billingLastName" placeholder="Efternamn" >
            </div>
          </div>
          <div class="form-row">
          <div class="form-group col-md-6">
            <label for="inputAddress">Adress</label>
            <input type="text" class="form-control"  placeholder="Adress" name="billingStreet" >
          </div>
          <div class="form-group col-md-6">
              <label for="inputZip">Postnummer</label>
              <input type="text" class="form-control" name="billingPostalCode" >
          </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="inputCity">Stad</label>
              <input type="text" class="form-control" name="billingCity" >
            </div>
            <div class="form-group col-md-3">
              <label for="inputState">Land</label>
              <select name="billingCountry" class="form-control" >
                <option selected value="">Välj</option>
                <option value="SE">Sverige</option>
              </select>
            </div>
          </div>
          
	      </div>
      </div>
      
      

      <button type="submit" class="btn btn-primary" name="createOrderBtn">Genomför köp</button>
    </form>
	</div>
  
</div>


<?php
include('layout/footer.php');
?>  

