<?php

if (!isset($_SESSION['cartItems'])) {
	$_SESSION['cartItems'] = [];
}

$cartItemCount = count($_SESSION['cartItems']);
$cartTotalSum = count($_SESSION['cartItems']);
?>


<div class="dropdown">
    <button type="button" class="btn btn-info" data-toggle="dropdown">
					<i class="fa fa-shopping-cart" aria-hidden="true"></i>Varukorg
					<span class="badge badge-pill badge-danger"><?=$cartItemCount?></span>
				</button>
		<div class="dropdown-menu">
			<div class="row total-header-section">
				<div class="col-lg-6 col-sm-6 col-6">
					<i class="fa fa-shopping-cart" aria-hidden="true"></i>
					<span class="badge badge-pill badge-danger"><?=$cartItemCount?></span>
				</div>
				<div class="col-lg-6 col-sm-6 col-6 total-section text-right">
					<p>Totalt: <span class="text-info">2000 kr</span></p>
		 	</div>
			</div>

			<?php foreach ($_SESSION['cartItems'] as $cartId => $cartItem) { ?>
				<div class="row cart-detail">
					<div>
						<img src="" >
					</div>
					<div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
						<p>Shoes</p>
						<span class="price text-info">2000 kr</span>
						<span class="count">Antal: 1</span>
					</div>
				</div>
			<?php } ?>

			<div class="row">
				<div class="col-lg-12 col-sm-12 col-12 text-center checkout">
					<a href="#" class="btn btn-primary btn-block">Kassa</a>
				</div>
			</div>

		</div>
</div>
