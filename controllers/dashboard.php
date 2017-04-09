<?php
	// get products uploaded by the user
	$products = get_products_by(3, $_SESSION["id"]);
	
	// render dashboard
	render("dashboard_view", ["title" => "Dashboard", "products" => $products]);
?>
