<?php
	$pageTitle = "Användare";
	$headerText = "Användare";
?>

<?php
	include('layout/admin-header.php');
    
    if (isset($_POST['deleteUserBtn'])) {
        try {
            $query = "
                DELETE FROM users
                WHERE id = :id;
            ";
    
            $stmt = $dbconnect->prepare($query);
            $stmt->bindValue(':id', $_POST['id']);
            $stmt->execute();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }
    
    try {
        $query = "
            SELECT * FROM users
        ";
    
        $stmt = $dbconnect->query($query);
        $users = $stmt->fetchAll();
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
?>

    <div id="content">
        <article class="border">
            <h1>Hantera användare</h1>

            <form action="new-user.php" method="GET">
            	<input type="submit" value="Ny användare">
            </form>

            <br>
            
            <table id="users-tbl">
            	<thead>
	            	<tr>
	            		<th>id</th>
	            		<th>Användarnamn</th>
                        <th>Lösenord</th>
	            		<th>E-post</th>
	            		<th>Telefonnummer</th>
                        <th>Address</th>
                        <th>Postnummer</th>
                        <th>Stad</th>
                        <th>Land</th>
	            		<th>Hantera</th>
	            	</tr>
            	</thead>
            	<tbody>
            	<?php foreach ($users as $key => $user) { ?>
            	
            		<tr>
	            		<th><?=$user['id']?></th>
	            		<th><?=htmlentities($user['first_name'])?></th>
						<th><?=htmlentities($user['last_name'])?></th>
	            		<th><?=htmlentities($user['email'])?></th>
                        <th><?=htmlentities($user['password'])?></th>
                        <th><?=htmlentities($user['phone'])?></th>
                        <th><?=htmlentities($user['street'])?></th>
                        <th><?=htmlentities($user['postal_code'])?></th>
                        <th><?=htmlentities($user['city'])?></th>
                        <th><?=htmlentities($user['country'])?></th>
	            		<th>	            			
	            			<form action="update-user.php?" method="GET" style="float:left;">
	            				<input type="hidden" name="id" value="<?=$user['id']?>">
				            	<input type="submit" value="Updatera">
				            </form>

	            			<form action="" method="POST" style="float:left;">
	            				<input type="hidden" name="id" value="<?=$user['id']?>">
	            				<input type="submit" name="deleteUserBtn" value="Radera">
	            			</form>
	            		</th>
	            	</tr>

	            <?php } ?>
            	</tbody>
            </table>         

            <hr>
        </article>
    </div>

<?php
    include('layout/admin-footer.php');
?>