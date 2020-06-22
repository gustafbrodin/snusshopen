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
				<div class="text-center mb-5" style="font-family: 'Oswald', sans-serif;">
    		<h1 class="display-3"><strong>Senaste Produktionen</strong></h1>
    		<p class="col-8 offset-2 h3"><strong>Köp snus som tillverkades för högst sju dagar sedan, direkt från våra fabriker i Göteborg och Kungälv.
					Välj bland utvalda produkter från General, Ettan, Grov och Göteborgs Rapé.</strong></p>
  			</div>
        <div class="container"><br>
          <div class="row">
					<?php foreach ($products as $key => $product) { ?>
							<div class="col-md-3">
									<div class=" mb-4 ">
											<img class="card-img-top" src="img/<?=($product['img_url'])?>"style="width: 225px; height: 225px;">
											<div class="card-body">
													<h5 class="card-title"><?=($product['title'])?></h5>
													<small><p class="card-text"><?=($product['description'])?></p></small>
													<hr>
													<p class="card-text mb-0"><?=($product['price'])?> kr / st</p>
													<div class="d-flex justify-content-between align-items-center">
															<form action="product-page.php" method="GET">
																<input type="hidden" name="id" value="<?=$product['id']?>">
																<button type="submit" class="btn btn-info btn-sm stretched-link">Läs mer</button>
															</form>
															<form action="add-cart-item.php" method="POST">
          											<input type="hidden" name="productId" value="<?=$product['id']?>">
																<input type="number" name="quantity" value="1" min="0" class="quantity">
		        										<input type="submit" name="addToCart" value="Köp" class="btn btn-info btn-sm">
		      										</form>
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