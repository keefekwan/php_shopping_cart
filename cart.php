<?php

if (isset($_POST["submit"])) {
	foreach ($_POST["quantity"] as $key => $value) {
		if ($value == 0) {
			unset($_SESSION["cart"][$key]);
		} else {
			$_SESSION["cart"][$key]["quantity"] = $value;
		}
	}
}

?>


<h1>View Cart</h1>
<a href="index.php?page=products">Back to Products</a>
<form action="index.php?page=cart" method="post">

	<table>
		<tr>
			<th>Name</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Items Price</th>			
		</tr>

					<?php
	
						global $pdo;
						$sql = $pdo->query("SELECT * FROM products WHERE id_product IN (");
							// Loops through all items in MYSQL and comma seperates
							foreach ($_SESSION["cart"] as $id => $value) {
								$sql .= $id . ",";
							}
	                        // Subtracts the last comma from the listing       
							$sql = substr($sql, 0, -1) . ") ORDER BY name ASC";
							$sql = $pdo->query("SELECT * FROM products ORDER BY name ASC");
							// $result = $sql->fetchAll();
							$totalprice = 0;										
							while ($row = $sql->fetch()) {
								$quantity = "";
								$quantity = isset($_SESSION["cart"][$row["id_product"]]["quantity"]) ? $_SESSION["cart"][$row["id_product"]]["quantity"] : 0;
								$subtotal = $quantity * $row["price"];
								$totalprice += $subtotal;
							?>
								<tr>
									<td><?php echo $row["name"]; ?></td>
									<td><input type="text" name="quantity[<?php echo $row["id_product"]; ?>]" size="5" value="<?php echo $quantity; ?>"></td>
									<td><?php echo "$", $row["price"]; ?></td>
									<td><?php echo "$", $quantity * $row["price"]; ?></td>
								</tr>
							<?php
							}
							

					?>
					<tr>
						<td>Total Price: <?php echo "$", $totalprice; ?></td>
					</tr>

	</table>
	<br>
	<button type="submit" name="submit">Update Cart</button>
</form>

<p>To remove an item set the quantity to 0</p>