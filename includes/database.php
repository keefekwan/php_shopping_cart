<?php

try {
$pdo = new PDO('mysql:host=localhost;dbname=tutorials', 'root', '');
} catch(PDOException $e) {
	exit("Database error");
}

?>
