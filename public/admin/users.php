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
        <article>

            <form action="new-user.php" method="GET">
            	<input type="submit" value="Ny användare" class="btn btn-sm btn-success">
            </form>

            <br>
            
            <table class="table table-striped">
            	<thead>
	            	<tr>
	            		<th>id</th>
                        <th>Förnamn</th>
                        <th>Efternamn</th>
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
	            		<td><?=$user['id']?></td>
	            		<td><?=htmlentities($user['first_name'])?></td>
						<td><?=htmlentities($user['last_name'])?></td>
	            		<td><?=htmlentities($user['email'])?></td>
                        <td><?=htmlentities($user['phone'])?></td>
                        <td><?=htmlentities($user['street'])?></td>
                        <td><?=htmlentities($user['postal_code'])?></td>
                        <td><?=htmlentities($user['city'])?></td>
                        <td><?=htmlentities($user['country'])?></td>
	            		<td>	            			
	            			<form action="update-user.php?" method="GET" style="float:left;">
	            				<input type="hidden" name="id" value="<?=$user['id']?>">
				            	<input type="submit" value="Updatera" class="btn btn-sm btn-warning mr-1">
				            </form>

	            			<form action="" method="POST" style="float:left;">
	            				<input type="hidden" name="id" value="<?=$user['id']?>">
	            				<input type="submit" name="deleteUserBtn" value="Radera" class="btn btn-sm btn-danger">
	            			</form>
	            		</td>
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