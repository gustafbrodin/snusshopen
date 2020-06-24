<?php
    require('../../src/config.php');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
	integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link href="css/style.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@800&display=swap" rel="stylesheet">
	<title><?php echo $pageTitle ?></title>
</head>
<body>
	

	<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background: linear-gradient(135deg,#1e5799,#035b79 0,#498ca3); color: white;">
  <h1 class="text-center text-white" style="font-family: 'Dosis', sans-serif; margin-left:100px;">Snusshopen</h1>
  <div class="collapse navbar-collapse offset-2 pl-5" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link text-white" href="index.php">Hem <span class="sr-only">(current)</span></a>
      </li>  
      <li class="nav-item active">
        <a class="nav-link text-white" href="products.php">Produkter <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link text-white" href="users.php">Användare</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link text-white" href="orders.php">Ordrar</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link text-white" href="../index.php">Shopen</a>
      </li>
    </ul>
  </div>
</nav>
<br>
<h1 class="text-center"><?php echo $headerText ?></h1>
<br>
