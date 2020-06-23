<?php

    $pageTitle = "Order";
	$headerText = "Order ";

    include('layout/admin-header.php');
    

    //  echo "<pre>";
    // print_r($_GET);
    // echo "</pre>";
    // exit;

    if(empty($_GET['id'])) {
        header('Location: orders.php');
        exit;
    }

 


// lista över singel beställ
try {

    $query = "
        SELECT * FROM orders 
        WHERE id = :id;
    
    
    ";
            
    $stmt = $dbconnect->prepare($query);
    $stmt->bindValue(':id', $_GET['id']);
    $stmt->execute();
    $order = $stmt->fetch();
}   catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }

///Lista över vad man har beställt.

    try {

        $query = "
            SELECT * FROM order_items
            WHERE order_id = :id;
        
        
        ";
                
        $stmt = $dbconnect->prepare($query);
        $stmt->bindValue(':id', $_GET['id']);
        $stmt->execute();
        $orderItems = $stmt->fetchAll();
    }   catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
//// Hämtar info om användare

        try {

            $query = "
                SELECT * FROM users
                WHERE id = :id;
            
            
            ";
                    
            $stmt = $dbconnect->prepare($query);
            $stmt->bindValue(':id', $order['user_id']);
            $stmt->execute();
            $user = $stmt->fetch();
        }   catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
            }

       
    
    

?>


    <br>
    <h1>Hanterar order #<?=$order['id']?></h1>
    <br>

	<div class="px-5">
		<table class="table table-borderless table-hover">
			<thead>
            <table class="table table-borderless">
			<thead>
				<tr>
					<th style="width: 15%">Namn</th>
                    <th style="width: 15%">Adress</th>
                    <th style="width: 15%">Produkt</th>
					<th style="width: 10%">Pris</th>
                    <th style="width: 10%">Antal</th>
                    <th style="width: 10%">Total summa</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($orderItems as $orderItemsId => $orderItem) { ?>  
				<tr>
					<td><?=$order['billing_full_name']?></td>
                    <td><?=$order['billing_street']?></td>
                    <td><?=$orderItem['product_title']?></td>
					<td><?=$orderItem['unit_price']?> kr</td>
                    <td><?=$orderItem['quantity']?> st</td>
                    <td><?=$order['total_price']?> kr</td>
          
				</tr>
				<?php } ?> 

			</tbody>
		</table>
			</tbody>
		</table>

        <a href="orders.php">Tillbaka</a>

                </div>
<?php
include('layout/admin-footer.php');
?>  

