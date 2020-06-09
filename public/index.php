<?php
	require('../src/config.php');
	



					
					include('layout/header.php');

	try {
					
					$first_name  = '';
    	$query = "SELECT * FROM products ";
    	$stmt = $dbconnect->query($query);
    	$products = $stmt->fetchall();
    }   catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
		   }


		   if (isset($_GET['logout'])) {
			$msg = '<div class="success_msg">Du har loggat ut.</div>';
		}

		
?>


    <main role="main">

						<section class=" " >
						<img src="img/jumbotron-img.png" alt="" style="width:100%; height: 100%;">
						<div class="container">
										
        </div>
      </section>

      <div class="album py-5">
        <div class="container">

          <div class="row">
												<?php foreach ($products as $key => $product) { ?>
														<div class="col-md-3">
																<div class=" mb-4 ">
																		<img class="card-img-top" src="img/<?=htmlentities($product['img_url'])?>"style="width: 225px; height: 225px;">
																		<div class="card-body">
																				<h5 class="card-title"><?=htmlentities($product['title'])?></h5>
																				<p class="card-text"><?=htmlentities($product['description'])?></p>
																				<p class="card-text"><?=htmlentities($product['price'])?> kr</p>
																				<div class="d-flex justify-content-between align-items-center">
																						<form action="product-page.php" method="GET">
                			  			<input type="hidden" name="id" value="<?=$product['id']?>">
		                      <button type="submit" class="btn btn-sm btn-outline-primary">Read more</button>
		                    </form>
																						<div class="btn-group">
																								<a href="product-page.php"><button type="button" class="btn btn-sm btn-outline-secondary">Köp</button></a>
																						</div>
																				</div>
																		</div>
																</div>
														</div>
												<?php } ?>
          </div>
        </div>
      </div>

    </main>




<?php
include('layout/footer.php');
?>