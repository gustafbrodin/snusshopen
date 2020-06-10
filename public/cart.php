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

					<?php foreach ($_SESSION['cartItems'] as $cartId => $cartItem) { ?>
						<div class="row cart-detail">
							<div class="col-lg-2 col-sm-2 col-2">
								<img src="img/<?=$cartItem['img_url']?>" class="cart-detail-img" >
							</div>
							<div class="col-lg-6 col-sm-6 col-6 cart-detail-product offset-1">
								<p><?=$cartItem['title']?></p>
								<span class="price text-info"><?=$cartItem['price']?> kr</span>
								<span class="count"><?=$cartItem['quantity']?> st</span>
							</div>
						</div>
					<?php } ?>

					<div class="row">
						<div class="col-lg-12 col-sm-12 col-12 text-center checkout">
							<a href="checkout.php" class="btn btn-primary btn-block">Kassa</a>
						</div>
					</div>

				</div>
	</div>
</div>
