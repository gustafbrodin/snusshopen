<?php
    require('../src/config.php');
    $pageTitle = "Mypage";
    $pageId = "me";
    
    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>";
?>
<?php include('layout/header.php'); 

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
            $msg = '<div class="success_msg">Användaren är uppdaterad</div>';
        } else {
            $msg = '<div class="error_msg">Uppdateringen av användaren misslyckades. Var snäll och försök igen senare!</div>';
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
?>

    <!-- Sidans/Dokumentets huvudsakliga innehåll -->
    <form method="POST" action="#">
        <div class="my-pages__content">
        <div class="my-pages__settings">
        <div class="my-pages__settings__col">
            <h2 class="my-pages__content__heading">Dina uppgifter</h2>
            <?=$msg?>
            <div class="form-group">
            <label class="form-group__label">Förnamn</label>
            <input class="form-group__field" name="first_name" type="text" value="<?=htmlentities($user['first_name'])?>">
            </div>

            <div class="form-group">
            <label class="form-group__label">Efternamn</label>
            <input class="form-group__field" name="last_name" type="text" value="<?=htmlentities($user['last_name'])?>">
            </div>

            <div class="form-group">
            <label class="form-group__label">E-mail</label>
            <input class="form-group__field" name="email" type="text" value="<?=htmlentities($user['email'])?>">
            </div>

            <div class="form-group">
            <label class="form-group__label">Lösenord</label>
            <input class="form-group__field" name="password" type="password">
            </div>

            <div class="form-group">
            <label class="form-group__label">Telefon</label>
            <input class="form-group__field" name="phone" type="text" value="<?=htmlentities($user['phone'])?>">
            </div>

            <h2 class="my-pages__content__heading">Leveransaddress</h2>

            <div class="form-group">
            <label class="form-group__label">Gatuadress</label>
            <input class="form-group__field" name="street" type="text" value="<?=htmlentities($user['street'])?>">
            </div>

            <div class="form-group">
            <label class="form-group__label">Postnummer</label>
            <input class="form-group__field" name="postal_code" type="text" value="<?=htmlentities($user['postal_code'])?>">
            </div>

            <div class="form-group">
            <label class="form-group__label">Stad</label>
            <input class="form-group__field" name="city" type="text" value="<?=htmlentities($user['city'])?>">
            </div>

            <div class="form-group">
            <label class="form-group__label">Land</label>
            <input class="form-group__field" name="country" type="text" value="<?=htmlentities($user['country'])?>">
            </div>

        </div>
        <div class="my-pages__settings__col">
            <h2 class="my-pages__content__heading">Fakturaaddress</h2>

            <div class="form-group">
            <label class="form-group__label">Förnamn</label>
            <input class="form-group__field" name="" type="text" value="<?=htmlentities($user[''])?>">
            </div>

            <div class="form-group">
            <label class="form-group__label">Efternamn</label>
            <input class="form-group__field" name="" type="text" value="<?=htmlentities($user[''])?>">
            </div>

            <div class="form-group">
            <label class="form-group__label">E-mail</label>
            <input class="form-group__field" name="" type="text" value="<?=htmlentities($user[''])?>">
            </div>

            <div class="form-group">
            <label class="form-group__label">Lösenord</label>
            <input class="form-group__field" name="" type="text" value="<?=htmlentities($user[''])?>">
            </div>

        </div>
        <div class="my-pages__settings__col">
            

                <div class="form-group">
                <input type="submit" name="update" value="Uppdatera">
                </div>
            </div>
        </div>
        </div>
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
