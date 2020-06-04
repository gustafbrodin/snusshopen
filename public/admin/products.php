<?php
    $pageTitle = "Produkter";
    $headerText = "Produkter";
?>

<?php
				include('layout/admin-header.php');

				if (isset($_POST['deleteBtn'])) {
					try {
									$query = "
									DELETE FROM products
									WHERE id = :id;
									";

									$stmt = $dbconnect->prepare($query);
									$stmt->bindValue(':id', $_POST['id']);
									$stmt->execute();
			}     catch (\PDOException $e) {
									throw new \PDOException($e->getMessage(), (int) $e->getCode());
			}
	}



	$error  = '';
	$msg    = '';
	if (isset($_POST['upload'])) {
					$title = trim($_POST['title']);
					$description = trim($_POST['description']);
					$price = trim($_POST['price']);
					$img_url = trim($_POST['img_url']);

		if (empty($title)) {
						$error .= '<div class="alert alert-danger mb-2 p-1" role="alert">Title can not be empty
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
											</div>';
		}

		if (empty($description)) {
						$error .= '<div class="alert alert-danger mb-2 p-1" role="alert">Blog post can not be empty
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
											</div>';
		}

		if (empty($price)) {
						$error .= '<div class="alert alert-danger mb-2 p-1" role="alert">price can not be empty
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
					</button>
									</div>';
		}

		if ($error) {
						$msg = "<div class='errors'>{$error}</div>";
		}

		if (empty($error)) {

						try {
										$query = "
										INSERT INTO products (title, description, price, img_url)
										VALUES (:title, :description, :price, :img_url);
										"; 

										$stmt = $dbconnect->prepare($query);
										$stmt->bindValue(':title', $title);
										$stmt->bindValue(':description', $description);
										$stmt->bindValue(':price', $price);
										$stmt->bindValue(':img_url', $img_url);
										$result = $stmt->execute();
						} catch (\PDOException $e) {
										throw new \PDOException($e->getMessage(), (int) $e->getCode()); 
						} 
						if ($result) {
						$msg = '<p class="alert alert-success">Your blog post was successfully uploaded
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
						</button>
								</p>';
						} 
}
}

if (isset($_POST['updateBtn'])) { 
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$price = trim($_POST['price']);
$img_url = trim($_POST['img_url']);

if (empty($title)) {
						$error .= '<div class="alert alert-danger mb-2 p-1" role="alert">Title can not be empty
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
											</div>';
		}

		if (empty($description)) {
						$error .= '<div class="alert alert-danger mb-2 p-1" role="alert">Blog post can not be empty
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
											</div>';
		}

		if (empty($price)) {
						$error .= '<div class="alert alert-danger mb-2 p-1" role="alert">price can not be empty
											<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
					</button>
									</div>';
		}

		if ($error) {
						$msg = "<div class='errors'>{$error}</div>";
		}

		if (empty($error)) {
		try {
				$query = "
						UPDATE products
						SET title = :title, description = :description, price = :price, img_url = :img_url
						WHERE id = :id;
				";

				$stmt = $dbconnect->prepare($query);
				$stmt->bindValue(':title', $title);
							$stmt->bindValue(':description', $description);
							$stmt->bindValue(':price', $price);
							$stmt->bindValue(':id', $_POST['id']);
							$stmt->bindValue(':img_url', $img_url);
							$result = $stmt->execute();
					} catch (\PDOException $e) {
							throw new \PDOException($e->getMessage(), (int) $e->getCode()); 
					}
					if ($result) {
					$msg = '<div class="alert alert-success">Your blog post has been updated
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
							</div>';
					}
}
}

				try {
    	$query = "SELECT * FROM products ";
    	$stmt = $dbconnect->query($query);
    	$products = $stmt->fetchall();
    }   catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
   		}
?>

<div class="container">
			  <div class="row" id="row_style">
			    <div class="col-md-10   offset-md-2">
				  <h2 class="mt-5">Ny produkt</h2>
				  <form action="" method="POST">
				   <div class="form-group">
				      <input type="text" class="form-control col-md-5" name="title" placeholder="Produktnamn">
				    </div>
				    <textarea class="form-control" cols="30" rows="5" name="description" placeholder="Beskrivning av produkten"></textarea><br>
				    <div class="form-group inline-block">
									<input type="text" class="form-control col-md-2" style="display: inline-block;" name="price" placeholder="Pris" >
									 <input type="text" class="form-control col-md-9" style="display: inline-block;" name="img_url" placeholder="Bild-URL"> 
									<!-- <input type="file" class="form-control col-md-9" style="display: inline-block;" name="img_url" placeholder="Bild-URL"> -->
				    </div>
				    <div class="form-group mb-4">
			          <input type="submit" class="btn btn-primary" name="upload" id="submit" value="Lägg till ny produkt">
		   	        </div>
				  </form>
						<?=$msg?>
				</div>

<div class="row">
		<?php foreach ($products as $key => $product) { ?>
				<div class="col-md-2">
						<div class=" mb-4 ">
								<img class="card-img-top ml-5" src="<?=htmlentities($product['img_url'])?>" style="width: 100px; height: 100px;">
								<div class="card-body">
										<h6 class="card-title"><?=htmlentities($product['title'])?></h5>
										<p class="card-text" style="font-size: 0.7rem"><?=htmlentities($product['description'])?></p>
										<p class="card-text" style="font-size: 0.7rem"><?=htmlentities($product['price'])?> kr</p>
										<div class="d-flex justify-content-between align-items-center">
												<div class="btn-group">
														<button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#exampleModal" 
														data-title="<?=htmlentities($product['title'])?>" data-description="<?=htmlentities($product['description'])?>" 
														data-price="<?=htmlentities($product['price'])?>" data-img_url="<?=htmlentities($product['img_url'])?>"  data-id="<?=htmlentities($product['id'])?>">Uppdatera</button>
														<form action="" method="POST" class="float-left">
																<input type="hidden" name="id" value="<?=$product['id']?>">
			             <input type="submit" name="deleteBtn" value="Delete" class="btn btn-sm btn-outline-secondary">
														</form>
												</div>
										</div>
								</div>
						</div>
				</div>
		<?php } ?>
</div>










<?php
    include('layout/admin-footer.php');
?>