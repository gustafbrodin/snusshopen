<?php

	require('../src/config.php');
	
	include('layout/header.php');

    $pageTitle = "Logga in";
    $pageId = "";

    $msg = "";
    if (isset($_GET['mustLogin'])) {
        $msg = '<div class="error_msg">Obs! Sidan är inloggningsskyddad. Var snäll och logga in.</div>';
    }

    if (isset($_GET['logout'])) {
        $msg = '<div class="success_msg">Du har loggat ut.</div>';
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
            $user = $stmt->fetch(); // returns the user record if exists, else returns false
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }


        if ($user && $password === $user['password']) {
            $_SESSION['username'] = $user['username'];
            header('Location: get.php');
            exit;
        } else {

            $msg = '<div class="error_msg">Fel inloggningsuppgifter. Var snäll och försök igen.</div>';
        }
    }
?>

    <div id="content">
        <article class="border">
            <form method="POST" action="#">
                <fieldset>
                    <legend>Logga in</legend>
                    
                    <!-- Visa errormeddelanden -->
                    <?=$msg?>
                    
                    <p>
                        <label for="input1">E-post:</label> <br>
                        <input type="text" class="text" name="email">
                    </p>

                    <p>
                        <label for="input2">Lösenord:</label> <br>
                        <input type="password" class="text" name="password">
                    </p>

                    <p>
                        <input type="submit" name="doLogin" value="Login">
                    </p>
                </fieldset>
            </form>
        
            <hr>
        </article>
    </div>

<?php include('layout/footer.php'); ?>