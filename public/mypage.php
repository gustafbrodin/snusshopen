<?php
    require('../src/config.php');
    $pageTitle = "Mypage";
    $pageId = "me";

  if (!isset($_SESSION['email'])) {
	    header("location: login.php?mustLogin");
	    }
?>

<?php 


$first_name  = '';
$last_name   = '';
$email       = '';
$password    = '';
$phone       = '';
$street      = '';
$postal_code = '';
$city        = '';
$country     = '';
$error       = '';
$msg         = '';

if (isset($_POST['update'])) {
    $first_name      = trim($_POST['first_name']);
    $last_name       = trim($_POST['last_name']);
    $email           = trim($_POST['email']);
    $password        = trim($_POST['password']);
    $phone           = trim($_POST['phone']);
    $street          = trim($_POST['street']);
    $postal_code     = trim($_POST['postal_code']);
    $city            = trim($_POST['city']);
    $country         = trim($_POST['country']);
    
    
    if (empty($first_name)) {
        $error .= "<li>Användarnamnet är obligatoriskt</li>";
    }
    if (empty($last_name)) {
        $error .= "<li>Användarnamnet är obligatoriskt</li>";
    }
    if (empty($email)) {
        $error .= "<li>E-post är obligatoriskt</li>";
    }
    if (empty($password)) {
        $error .= "<li>Lösenord är obligatoriskt</li>";
    }
    if (!empty($password) && strlen($password) < 6) {
        $error .= "<li>Lösenordet får inte vara mindre än 6 tecken lång</li>";
    }
    if (empty($phone)) {
        $error .= "<li>Telefonnummer är obligatoriskt</li>";
    }
    if (empty($street)) {
        $error .= "<li>Gatuadress är obligatoriskt</li>";
    }
    if (empty($postal_code)) {
        $error .= "<li>Postnummer är obligatoriskt</li>";
    }
    if (empty($city)) {
        $error .= "<li>Stad är obligatoriskt</li>";
    }
    if (empty($country)) {
        $error .= "<li>Land är obligatoriskt</li>";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error .= "<li>Ogiltig e-post</li>";
    }
    
    
    

    if ($error) {
        $msg = "<ul class='error_msg'>{$error}</ul>";
    }

    if (empty($error)) {
        try {
            $query = "
                UPDATE users
                SET first_name = :first_name, last_name = :last_name, password = :password, email = :email, phone = :phone, street = :street, postal_code = :postal_code, city = :city, country = :country
                WHERE email = :email
            ";

            

            $stmt = $dbconnect->prepare($query);
            $stmt->bindValue(':first_name', $first_name);
            $stmt->bindValue(':last_name', $last_name);
            $stmt->bindValue(':password', $password);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':phone', $phone);
            $stmt->bindValue(':street', $street);
            $stmt->bindValue(':postal_code', $postal_code);
            $stmt->bindValue(':city', $city);
            $stmt->bindValue(':country', $country);
            
            $result = $stmt->execute(); // returns true/false
        } catch(\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        if ($result) {
            $msg = '<div class="success_msg">Dina uppgifter har uppdaterats</div>';
        } else {
            $msg = '<div class="error_msg">Uppdateringen av användaren misslyckades. Var snäll och försök igen senare!</div>';
        }
    }
}


try {
    
    $query = "SELECT * FROM users 
              WHERE email = :email;";
    $stmt = $dbconnect->prepare($query);
    $stmt->bindvalue(':email', $_SESSION['email']);
    $stmt->execute();
    $user = $stmt->fetch();
}   catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
       }



    if (isset($_POST['deleteBtn'])) {
        try {
                        $query = "
                        DELETE FROM users
                        WHERE email = :email;
                        ";

                        $stmt = $dbconnect->prepare($query);
                        $stmt->bindValue(':email', $_POST['email']);
                        $stmt->execute();
                        session_destroy();
                        header('Location: index.php?logout');
                        exit;
               }        catch (\PDOException $e) {
                        throw new \PDOException($e->getMessage(), (int) $e->getCode());
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

        

    <form method="POST" action="#" class="container-fluid">
    <div class="row d-flex justify-content-around">

            <div class="col-3 mt-5 form">
            
            <h2 class="mb-4">Dina uppgifter</h2>
            <?=$msg?>
            
            <label class="form-group__label">Förnamn</label>
            <input class="form-group__field" name="first_name" type="text" value="<?=htmlentities($user['first_name'])?>"><br>
            
            <label class="form-group__label">Efternamn</label>
            <input class="form-group__field" name="last_name" type="text" value="<?=htmlentities($user['last_name'])?>"><br>
            
            <label class="form-group__label">E-mail</label>
            <input class="form-group__field" name="email" type="text" value="<?=htmlentities($user['email'])?>"><br>
            
            <label class="form-group__label">Lösenord</label>
            <input class="form-group__field" name="password" type="password"><br>
            
            <label class="form-group__label ">Telefon</label>
            <input class="form-group__field telefonnummer" name="phone" type="number" value="<?=htmlentities($user['phone'])?>">
            </div>
            
            <div class="col-3 mt-5 form ">
            <h2 class="mb-4">Leveransaddress</h2>

            <label class="form-group__label">Gatuadress</label>
            <input class="form-group__field" name="street" type="text" value="<?=htmlentities($user['street'])?>"><br>
            
            <label class="form-group__label">Postnummer</label>
            <input class="form-group__field" name="postal_code" type="text" value="<?=htmlentities($user['postal_code'])?>"><br>
            
            <label class="form-group__label">Stad</label>
            <input class="form-group__field" name="city" type="text" value="<?=htmlentities($user['city'])?>"><br>
            
            <label class="form-group__label">Land</label>
            <input class="form-group__field" name="country" type="text" value="<?=htmlentities($user['country'])?>">
            </div>
            </div>
            </div>
            <div class="d-flex justify-content-center p-5">
                <input class="btn btn-primary m-2" type="submit" name="update" value="Uppdatera">
                <input class="btn btn-primary m-2" type="submit" name="deleteBtn" value="Delete">
            </div>

    </form>

<?php include('layout/footer.php'); ?>

<script type="text/javascript">

function myFunction() {
  var checkBox = document.getElementById("deliveryAddressCheckbox");
  var div = document.getElementById("deliveryAddress");

  if (checkBox.checked == true){
    div.style.display = "block";
  } else {
    div.style.display = "none";
  }
}

</script>
