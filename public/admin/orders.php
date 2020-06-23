<?php

  $pageTitle = "Ordrar";
	$headerText = "Ordrar";

  include('layout/admin-header.php');

try {

    $query = "SELECT * FROM orders ";
            
    $stmt = $dbconnect->query($query);
    $orders = $stmt->fetchAll();
}   catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }

    // echo "<pre>";
    // print_r($orders);
    // echo "</pre>";

?>


    <br>
    
    <br>

	<div class="px-5">
		<table class="table table-borderless table-striped">
			<thead>
				<tr>
					<th style="width: 15%">Order Id</th>
                    <th style="width: 15%">Kundnamn</th>
                    <th style="width: 15%">Pris</th>
                    <th style="width: 15%">Hantera status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($orders as $key => $order) { ?>  
				<tr>
                    <td><a href="order.php?id=<?=$order['id']?>">#<?=$order['id']?></a></td>
                    <td><?=$order['billing_full_name']?></td>
                    <td><?=$order['total_price']?> kr</td>

                    <td>
                            <select  name="status" id="status" class="form-control">
                            <option>Öppen</option>
                            <option>Behandlas</option>
                            <option>Skickad</option>
                            <option>Makulerad</option>
                        </select>
                    </td>
          
          
				</tr>
				<?php } ?> 
			</tbody>
		</table>
    </div>
	


<?php
include('layout/admin-footer.php');
?>  

