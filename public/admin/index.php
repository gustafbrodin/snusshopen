<?php
	$pageTitle = "Admin";
	$headerText = "Admin";
?>

<?php
    include('layout/admin-header.php');

    
?>


<div class="album py-5 bg-light">
    <div class="container">

      <div class="row">
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <div class="card-body">
              <h3 class="card-text text-center" style="font-family: 'Dosis', sans-serif;">Produkter</h3>
              <div class="d-flex justify-content-center align-items-center">
                <div class="btn-group">
                  <a href="products.php"><button type="button" class="btn btn-sm btn-outline-secondary">Visa</button></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <div class="card-body">
              <h3 class="card-text text-center" >Användare</h3>
              <div class="d-flex justify-content-center align-items-center">
                <div class="btn-group">
                  <a href="users.php"><button type="button" class="btn btn-sm btn-outline-secondary">Visa</button></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <div class="card-body">
              <h3 class="card-text text-center">Ordrar</h3>
              <div class="d-flex justify-content-center align-items-center">
                <div class="btn-group">
                  <a href="orders.php"><button type="button" class="btn btn-sm btn-outline-secondary">Visa</button></a>
                </div>
              </div>
            </div>
          </div>
        </div>   
      </div>
    </div>
  </div>




<?php
    include('layout/admin-footer.php');
?>