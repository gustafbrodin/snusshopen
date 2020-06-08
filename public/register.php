<?php


    require('../src/config.php');

    include('layout/header.php');

    $pageTitle = "Registrera dig";
    $pageId = "";


    // // echo $_POST
    // echo "<pre>";
    // echo print_r($_POST);
    // echo "</pre>";

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
        if (empty($password)) {
            $error .= "<li>Lösenord är obligatoriskt</li>";
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


    <!-- Sidans/Dokumentets huvudsakliga innehåll -->
    <div id="content">
        <article class="border">
            <form method="POST" action="#">
                <fieldset>
                    <legend>Registrera dig här</legend>
                    
                    <!-- Visa errormeddelanden -->
                    <?=$msg?>
                    
                    <p>
                        <label for="input1">Förnamn:</label> <br>
                        <input type="text" class="text" name="first_name" value="<?=htmlentities($first_name)?>">
                    </p>

                    <p>
                        <label for="input1">Efternamn:</label> <br>
                        <input type="text" class="text" name="last_name" value="<?=htmlentities($last_name)?>">
                    </p>

                    <p>
                        <label for="input1">E-post:</label> <br>
                        <input type="text" class="text" name="email" value="<?=htmlentities($email)?>">
                    </p>

                    <p>
                        <label for="input1">Lösenord:</label> <br>
                        <input type="password" class="text" name="password" value="<?=htmlentities($password)?>">
                    </p>

                    <p>
                        <label for="input1">Bekräfta lösenord:</label> <br>
                        <input type="password" class="text" name="confirmPassword" value="<?=htmlentities($password)?>">
                    </p>

                    <p>
                        <label for="input2">Telefonnummer:</label> <br>
                        <input type="text" class="text" name="phone" value="<?=htmlentities($phone)?>">
                    </p>

                    <p>
                        <label for="input1">Gata:</label> <br>
                        <input type="text" class="text" name="street" value="<?=htmlentities($street)?>">
                    </p>

                    <p>
                        <label for="input1">Postnummer:</label> <br>
                        <input type="text" class="text" name="postal_code" value="<?=htmlentities($postal_code)?>">
                    </p>

                    <p>
                        <label for="input1">Stad:</label> <br>
                        <input type="text" class="text" name="city" value="<?=htmlentities($city)?>">
                    </p>

                    <p>
                        <label for="input1">Land:</label> <br>
                        <input type="text" class="text" name="country" value="<?=htmlentities($country)?>">
                    </p>

                    <p>
                        <input type="submit" name="register" value="Registrera">
                    </p>
                </fieldset>
            </form>
        
            <hr>
        </article>
    </div>

<?php include('layout/footer.php'); ?>
