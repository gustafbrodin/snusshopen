<?php

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

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@800&display=swap" rel="stylesheet">

			<link href="css/style.css" rel="stylesheet">
	<title>Snusshopen</title>
</head>
<body>
	

	<header>
        
      <nav class="navbar navbar-dark bg-primary box-shadow" style="background: linear-gradient(135deg,#1e5799,#035b79 0,#498ca3);">
        <div class="container d-flex justify-content-between">
          <h1 class="text-center text-white" style="font-family: 'Dosis', sans-serif;">Snusshopen</h1>
          <a href="index.php" class="navbar-brand d-flex align-items-center">
            <strong>Hem</strong>
          </a>
          <?php 
          if (isset($_SESSION['email'])) {
            // ucfirst() turns the first letter to a capital letter, in a string
            $loggedInUsername = htmlentities(ucfirst($user['first_name'])); 
            $aboveNav = "Välkommen $loggedInUsername | <a href='logout.php'>Logga ut</a>";
          } else {
            $aboveNav = "<a href='register.php'>Registrera dig</a> | <a href='login.php'>Logga in</a>";
          }

          echo $aboveNav;
        ?>
        </div>
      </nav>
    </header>