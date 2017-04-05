<?php
	// get products uploaded by the user
	$products = get_products_by(3);
	
	// render dashboard
	render("dashboard_view", ["title" => "Dashboard", "products" => $products]);
?>
