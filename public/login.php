<?php

    
	require('../src/config.php');
    include('layout/header.php');

    $msg = "";
    if (isset($_GET['mustLogin'])) {
        $msg = '<div class="error_msg">Obs! Sidan är inloggningsskyddad. Var snäll och logga in.</div>';
    }

    

    if (isset($_POST['doLogin'])) {
        $email    = $_POST['email'];
        $password = $_POST['password'];

        try {
            $query = "
                SELECT * FROM users
                WHERE email = :email;
            ";

            $stmt = $dbconnect->prepare($query);
            $stmt->bindValue(':email', $email);
            $stmt->execute(); 

            $user = $stmt->fetch(); 

        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }


        if ($user && $password === $user['password']) {

            $_SESSION['email'] = $user['email'];
            header('Location: mypage.php');

            exit;
        } else {

            $msg = '<div class="error_msg">Fel inloggningsuppgifter. Var snäll och försök igen.</div>';
        }
    }
?>




<div class="d-flex justify-content-center m-3">
<form class="form-signin" method="POST" action="#">

<?=$msg?>

  <img class="mb-4" src="/docs/4.5/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Logga in</h1>
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address">
  <label for="inputPassword" name="password" class="sr-only">Lösenord</label>
  <input type="password" id="password" name="password" class="form-control" placeholder="Password">
  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me"> Kom ihåg mig
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" name="doLogin" type="submit">Logga in</button>
  <a href="register.php" style="color: grey!important;">Inget konto? Registrera dig <u>här</u></a>
</form>
</div>

<?php include('layout/footer.php'); ?>
