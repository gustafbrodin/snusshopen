<?php
	require('../src/config.php');
	
    include('layout/header.php');
    
    try {

    	$query = "SELECT * FROM products 
    			  WHERE id = :id;";
    	$stmt = $dbconnect->prepare($query);
        $stmt->bindvalue(':id', $_GET['id']);
        $stmt->execute();
        $products = $stmt->fetch();
    }   catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
   		}

	if (empty($products['background_color'])) { ?>
		<div class="row pb-5 mr-0 text-body" id="row_style" style="background-color:<?=htmlentities($products['background_color'])?>; color:white; height: 750px; padding-top: 50px;">
	<?php } else { ?>
<div class="row pb-5 mr-0 " id="row_style" style="background-color:<?=htmlentities($products['background_color'])?>; color:white; height: 700px; padding-top: 0px;">	<?php } ?>
	<div class="c offset-md-1 d-flex align-items-center">
		<div class="">
	    <p class="mb-2 mt-5 h1 display-4 mb-5"><strong><?=htmlentities($products['title'])?></strong></p>
			<p><?=htmlentities($products['description'])?></p>
	    <section class="mb-3"><?=htmlentities($products['price'])?> kr</section>
			<form action="add-cart-item.php" method="POST">
        <input type="hidden" name="productId" value="<?=$products['id']?>">
				<input type="number" name="quantity" value="1" min="0" class="quantity">
		    <input type="submit" name="addToCart" value="Köp" class="btn btn-info btn-sm">
		  </form>
			<a href="index.php"><button class="btn btn-light btn-sm" >Tillbaka</button></a>
		</div><br>
		<div class="col-8 px-5 mt-5 text-center">
			<img src="img/<?=htmlentities($products['background_img'])?>">
		</div>
	</div>
	
	    	
	   
</div>



<?php
include('layout/footer.php');
?>