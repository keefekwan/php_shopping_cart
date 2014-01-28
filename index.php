<?php session_start(); ?>
<?php require_once("includes/database.php"); ?>
<?php

// If no page variable is set go to the products page
if (isset($_GET["page"])) {
	// If it is set check if the variable is from one of the values from the array
	$pages = array(
		"products",
		"cart"
		);
	// If the value of $_GET["page"] is an array value then it's true and go to the page (i.e., products or cart) else go to products page
	if (in_array($_GET["page"], $pages)) {
		$_page = $_GET["page"];
	} else {
		$_page = "products";
	}
} else {
	$_page = "products";
}

?>


<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" href="css/reset.css">
		<link rel="stylesheet" href="css/style.css">

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>
		<title>Shopping Cart</title>

		<script type="text/javascript">
			&(function() {

			});
		</script>
	</head>
	<body>
		<div id="container">
			<div id="main">
				<?php require($_page . ".php"); ?>
			</div><!-- end of main -->

			<div id="sidebar">
				<h1>Cart</h1>
				<?php
				
				if (isset($_SESSION["cart"])) {
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
																		
						while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
						// echo "<pre>";
						// var_dump($row);
						?>
						<?php 
						
						$quantity = isset($_SESSION["cart"][$row["id_product"]]["quantity"]) ? $_SESSION["cart"][$row["id_product"]]["quantity"] : 0;
						// var_dump($quantity); 
						?>
							<p><?php if ($quantity != 0) { echo $row["name"] . "x" . $quantity; } ?></p>

						<?php
						}
						?>
						<hr>
						<a href="index.php?page=cart">Go to cart</a>

				<?php
				} else {
					echo "<pre>Your cart is empty. Please add some products.</pre>";
				}
				
				?>
				
			</div><!-- end of sidebar -->

		</div><!-- end of container -->

	</body>
</html>