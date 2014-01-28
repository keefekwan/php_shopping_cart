<?php

if (isset($_GET["action"]) && $_GET["action"] == "add") {
	// Intval gets the integer value of $_GET["id"]
	$id = intval($_GET["id"]);
	// Check to see if product is not already in the session if it is implement the quantity
	if(isset($_SESSION["cart"][$id])) {
		$_SESSION["cart"][$id]["quantity"]++;
	
	} else {
		// Query MYSQL for ID
		global $pdo;
		$sql = $pdo->prepare("SELECT * FROM products WHERE id_product = :id");
		$sql->bindValue(":id", $_GET["id"]);
		$result = $sql->execute();
		$count = $sql->rowcount();
		
		if ($count != 0) {
			$row = $sql->fetchAll();
			//var_dump($row);
			$_SESSION["cart"][$row[0]["id_product"]] = array(
				"quantity" => 1, 
				"price" => $row[0]["price"]
				);
		} else {
			$message = "The product ID is not valid";
		}
	}
}

?>

<h1>Product List</h1>
<?php

	if (isset($message)) {
		echo "<h2>$message</h2>";
	}
	
?>

				<table>
					<tr>
						<th>Name</th>
						<th>Description</th>
						<th>Price</th>
						<th>Action</th>
					</tr>

					<?php
					global $pdo;
					$query = $pdo->query("SELECT * FROM products ORDER BY name ASC");
					// $query->execute();
					$result = $query->fetchAll(PDO::FETCH_ASSOC);

					while ($row = array_shift($result)) {
					?>	
						<tr>
							<td><?php echo $row["name"] ?></td>
							<td><?php echo $row["property"] ?></td>
							<td><?php echo "$", $row["price"] ?></td>
							<?php // Define the ID of the product using $row and id_product from mysql ?>
							<td><a href="index.php?page=products&action=add&id=<?php echo $row["id_product"]; ?>">Add to cart</a></td>
						</tr>

					<?php } ?>
					
				</table>