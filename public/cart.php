<?php

if (!isset($_SESSION['cartItems'])) {
	$_SESSION['cartItems'] = [];
}

$cartItemCount = count($_SESSION['cartItems']);
$cartTotalSum = 0;
foreach ($_SESSION['cartItems'] as $cartId => $cartItem) {
	$cartTotalSum += $cartItem['price'] * $cartItem['quantity'];
}
?>

<div class="">
	<div class=" ">
		<div class="dropdown ml-5">
				<button type="button" class="btn btn-info" data-toggle="dropdown">
					<i class="fa fa-shopping-cart" aria-hidden="true"></i>Varukorg
					<span class="badge badge-pill badge-danger"><?=$cartItemCount?></span>
				</button>
				<div class="dropdown-menu" style="">
					
						<div class="row total-header-section">
							<div class="col-lg-6 col-sm-6 col-6">
								<i class="fa fa-shopping-cart" aria-hidden="true"></i>
								<span class="badge badge-pill badge-danger"><?=$cartItemCount?></span>
							</div>
							<div class="col-lg-6 col-sm-6 col-6 total-section text-right">
								<p>Totalt: <span class="text-info"><?=$cartTotalSum?> kr</span></p>
						</div>
						</div>

						<?php 
						if(empty($_SESSION['cartItems'])) { ?>
							<div class="row cart-detail">
								<div class="col-lg-10 col-sm-10 col-10 cart-detail-product offset-2">
										<p>Din varukorg är tom</p>
									</div>
							</div>
						<?php } else {
							
						foreach ($_SESSION['cartItems'] as $cartId => $cartItem) { ?>
							<div class="row cart-detail">
								<div class="col-lg-2 col-sm-2 col-2">
									<img src="img/<?=$cartItem['img_url']?>" class="cart-detail-img" >
								</div>
								<div class="col-lg-6 col-sm-6 col-6 cart-detail-product offset-1">
									<p><?=$cartItem['title']?></p>
									<span class="price text-info"><?=$cartItem['price']?> kr</span>
								</div>
								<div>
									
									<form class="update-cart-form" action="update-cart-item.php" method="POST">
										<input type="hidden" name="cartId" value="<?=$cartId?>">
										<input type="number" name="quantity" value="<?=$cartItem['quantity']?>" min="0" style=" width:50px !important;}">
									</form>
								</div>
								<div>
									<form action="delete-cart-item.php" method="POST">
										<input type="hidden" name="cartId" value="<?=$cartId?>">
										<button type="submit" class="btn mt-n1">
											<svg class="bi bi-trash" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
												<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
												<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
											</svg>
										</button>
									</form>
								</div>
							</div>
						<?php } ?>

						<div class="row">
							<div class="col-lg-12 col-sm-12 col-12 text-center checkout">
								<a href="checkout.php" class="btn btn-primary btn-block">Kassa</a>
							</div>
						</div>
						<?php } ?>
					
				</div>
	</div>
</div>
