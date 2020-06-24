<?php


    require('../src/config.php');

    include('layout/header.php');

    $pageTitle = "Registrera dig";
    $pageId = "";


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

        if (empty($error)) {
            try {
                $query = "
                    INSERT INTO users ( first_name, last_name, password, email, phone, street, postal_code, city, country)
                    VALUES ( :first_name, :last_name, :password, :email, :phone, :street, :postal_code, :city, :country);
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
                $msg = '<div class="success_msg">Ditt konto är nu skapat</div>';
            } else {
                $msg = '<div class="error_msg">Regisreringen misslyckades. Var snäll och försök igen senare!</div>';
            }
        }
    }

?>


    <div id="content">
    <legend class="d-flex justify-content-center">Registera dig här</legend>
        <article class="justify-content-center m-5 p-3">
            <form method="POST">
            <?=$msg?>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="inputEmail4">Förnamn</label>
          <input type="text" class="form-control" name="first_name" placeholder="Förnamn" value="<?=htmlentities($first_name)?>">
        </div>
        <div class="form-group col-md-6">
          <label for="inputPassword4">Efternamn</label>
          <input type="text" class="form-control" name="last_name" placeholder="Efternamn" value="<?=htmlentities($last_name)?>">
        </div>
      </div>
      <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputAddress">Adress</label>
        <input type="text" class="form-control"  placeholder="Adress" name="street" value="<?=htmlentities($street)?>">
      </div>
      <div class="form-group col-md-6">
          <label for="inputZip">Postnummer</label>
          <input type="text" class="form-control" name="postal_code" value="<?=htmlentities($postal_code)?>">
        </div>
      <div class="form-group col-md-6">
        <label for="inputAddress">E-post</label>
        <input type="email" class="form-control" name="email"  placeholder="E-post" value="<?=htmlentities($email)?>">
      </div> 
      <div class="form-group col-md-6">
      <label for="inputPassword4">Lösenord</label>
      <input type="password" class="form-control" placeholder="Lösenord" name="password" value="<?=htmlentities($password)?>">
      </div>
      <div class="form-group col-md-6">
      <label for="inputPassword4">Bekräfta Lösenord</label>
      <input type="password" class="form-control" placeholder="Lösenord" name="confirmPassword" value="<?=htmlentities($password)?>">
      </div>
      </div>
      <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputPhone">Telefonnummer</label>
        <input type="number" class="form-control telefonnummer" name="phone" placeholder="Telefonnummer" value="<?=htmlentities($phone)?>">
      </div>
        <div class="form-group col-md-3">
          <label for="inputCity">Stad</label>
          <input type="text" class="form-control" name="city" value="<?=htmlentities($city)?>">
        </div>
        <div class="form-group col-md-3">
          <label for="inputState">Land</label>
          <select  name="country" class="form-control" value="<?=htmlentities($country)?>">
            <option selected>Välj</option>
            <option value="SE">Sverige</option>
          </select>
        </div>
      </div>
      <div class="form-group">
      </div>
      <input type="submit" name="register" value="Registrera" class="btn btn-primary">
    </form>
        
            <hr>
        </article>
    </div>

<?php include('layout/footer.php'); ?>
