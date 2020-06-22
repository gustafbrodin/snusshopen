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
?>

<div class="row pt-5" id="row_style" style="background-color:<?=htmlentities($products['background_color'])?>">
	         <div class="col-md-8   offset-md-2 text-center ">
	             <div class="col-10 offset-md-1 px-5 text-center">
	               <img src="img/<?=htmlentities($products['background_img'])?>">
	               <p class="mb-2 font-weight-lighter font-italic text-center"><?=htmlentities($products['title'])?>
																<?=htmlentities($products['description'])?></p><br>
	               <section class="mb-3 font-weight-light"><?=htmlentities($products['price'])?> kr</section>
																<button class="btn btn-sm btn-outline-primary">Lägg i varukorg</button><br><br>
	               <form action="index.php">
	               	<button class="btn btn-sm btn-outline-primary">Tillbaka</button>
	               </form>
	             </div><br>
	         </div>
	       </div>


<?php
include('layout/footer.php');
?>