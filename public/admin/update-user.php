<?php
    
    $pageTitle = "Uppdatera användare";
    $headerText = "Uppdatera användare";

    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>";
?>
<?php include('layout/admin-header.php'); 


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
                WHERE id = :id
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
            $stmt->bindValue(':id', $_GET['id']);
            $result = $stmt->execute(); // returns true/false
        } catch(\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }

        if ($result) {
            $msg = '<div class="success_msg">Användaren är uppdaterad</div>';
        } else {
            $msg = '<div class="error_msg">Uppdateringen av användaren misslyckades. Var snäll och försök igen senare!</div>';
        }
    }}

try {
    $query = "
        SELECT * FROM users
        WHERE id = :id;
    ";

    $stmt = $dbconnect->prepare($query);
    $stmt->bindvalue(':id', $_GET['id']);
    $stmt->execute();
    $user = $stmt->fetch();
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}

?>

<div class="row d-flex justify-content-center">
   
    <div class="col-3 mt-5 form offset-1">
        <form method="POST" action="#">
            <fieldset>
                
                
                <?=$msg?>
                
                    <p>
                        <label for="input1">Förnamn</label> <br>
                        <input type="text" class="text" name="first_name" value="<?=htmlentities($user['first_name'])?>">
                    </p>

                    <p>
                        <label for="input1">Efternamn</label> <br>
                        <input type="text" class="text" name="last_name" value="<?=htmlentities($user['last_name'])?>">
                    </p>

                    <p>
                        <label for="input1">E-post:</label> <br>
                        <input type="text" class="text" name="email" value="<?=htmlentities($user['email'])?>">
                    </p>

                    <p>
                        <label for="input1">Lösenord:</label> <br>
                        <input type="password" class="text" name="password">
                    </p>

                    <p>
                        <label for="input2">Telefonnummer:</label> <br>
                        <input type="phone" class="text" name="phone" value="<?=htmlentities($user['phone'])?>">
                    </p>
                    </div>
                    <div class="col-3 mt-5 form ">
                    <p>
                        <label for="input1">Gata:</label> <br>
                        <input type="text" class="text" name="street" value="<?=htmlentities($user['street'])?>">
                    </p>

                    <p>
                        <label for="input1">Postnummer:</label> <br>
                        <input type="text" class="text" name="postal_code" value="<?=htmlentities($user['postal_code'])?>">
                    </p>

                    <p>
                        <label for="input1">Stad:</label> <br>
                        <input type="text" class="text" name="city" value="<?=htmlentities($user['city'])?>">
                    </p>

                    <p>
                        <label for="input1">Land:</label> <br>
                        <input type="text" class="text" name="country" value="<?=htmlentities($user['country'])?>">
                    </p>

                <p>
                    <input type="submit" name="update" value="Uppdatera"> | 
                    <a href="users.php">Tillbaka</a>
                </p>
            </fieldset>
        </form>
    
        <hr>
    </div>
</div>

<?php include('layout/admin-footer.php'); ?>