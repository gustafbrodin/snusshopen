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
						$error .= '<div class="alert alert-danger mb-2 p-1" role="alert">Produktnamn får inte vara tomt
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
											</div>';
		}

		if (empty($description)) {
						$error .= '<div class="alert alert-danger mb-2 p-1" role="alert">Beskrivnginen får inte vara tom
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
				</button>
											</div>';
		}

		if (empty($price)) {
						$error .= '<div class="alert alert-danger mb-2 p-1" role="alert">Pris får inte vara tomt
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
										INSERT INTO products (title, description, price, img_url, background_img)
										VALUES (:title, :description, :price, :img_url, :img_url);
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
						$msg = '<p class="alert alert-success">Produkten har skapats
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
			    <div class="col-md-10   offset-md-1">
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
			          <input type="submit" class="btn btn-sm btn-success" name="upload" id="submit" value="Lägg till ny produkt">
		   	        </div>
				  </form>
						<?=$msg?>
				</div>
				</div>
				</div>

<div class="row">
		<?php foreach ($products as $key => $product) { ?>
				<div class="col-md-3">
						<div class=" mb-4 ">
								<img class="card-img-top ml-5" src="../img/<?=htmlentities($product['img_url'])?>" style="width: 100px; height: 100px;">
								<div class="card-body">
										<h6 class="card-title"><?=htmlentities($product['title'])?></h6>
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








<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
	          <div class="modal-header">
	            <h5 class="modal-title" id="exampleModalLabel">Update post</h5>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	              <span aria-hidden="true">&times;</span>
	            </button>
	          </div> 
	          <form action="" method="POST">
	            <div class="modal-body">
	              <div class="form-group">
	                <label for="updateTitle" class="col-form-label">Title:</label>
	                <input type="text" class="form-control" name="title" id="updateTitle-">
	                <div class="form-group">
	                  <label for="updatePost" class="col-form-label">Description: </label>
	                  <textarea class="form-control" name="description" id="updatePost"></textarea>
	                  <div class="form-group">
	              	    <label for="updatePrice" class="col-form-label">Price: </label>
	                    <input type="text" class="form-control" name="price" id="updatePrice">
	                    
					  </div>
					  <div class="form-group">
	              	    <label for="updateImg" class="col-form-label">Bild-URL </label>
	                    <input type="text" class="form-control" name="img_url" id="updateImg">
	                    <input type="hidden" class="form-control" name="id">
	                  </div>
	                </div>
	            	<div class="modal-footer">
	              	  <button type="button" class="btn btn-secondary" data-dismiss="modal">Stäng</button>
	                  <input type="submit" name="updateBtn" value="Uppdatera" class="btn btn-success">
		            </div>
	              </div>
	            </div>
		      </form>
		    </div>
	      </div>
	</div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script>
	  	$('#exampleModal').on('show.bs.modal', function (event) {
	    var button = $(event.relatedTarget); // Button that triggered the modal
	    var title = button.data('title'); // Extract info from data-* attributes
	    var description = button.data('description'); // Extract info from data-* attributes
		var price = button.data('price'); // Extract info from data-* attributes
		var img_url = button.data('img_url'); // Extract info from data-* attributes
	    var id = button.data('id'); // Extract info from data-* attributes
	   
	    var modal = $(this);
	    modal.find(".modal-body input[name='title']").val(title);
	    modal.find(".modal-body textarea[name='description']").val(description);
		modal.find(".modal-body input[name='price']").val(price);
		modal.find(".modal-body input[name='img_url']").val(img_url);
	    modal.find(".modal-body input[name='id']").val(id);
	  	});
	</script>

	

<?php
    include('layout/admin-footer.php');
?>