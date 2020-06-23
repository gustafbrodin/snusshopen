<?php

    
	require('../src/config.php');
    include('layout/header.php');


    $pageTitle = "Logga in";
    $pageId = "";

    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>";


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
<form class="form-signin">
  <img class="mb-4" src="/docs/4.5/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Logga in</h1>
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
  <label for="inputPassword" class="sr-only">Lösenord</label>
  <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me"> Kom ihåg mig
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Logga in</button>
</form>
</div>

<?php include('layout/footer.php'); ?>
