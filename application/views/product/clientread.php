<h2>Product Entry</h2>
<?php 
	echo "<p>" . anchor('client/index','Back') . "</p>";

	echo "<p> Name: " . $product->name . "</p>";
	echo "<p> Description: " . $product->description . "</p>";
	echo "<p> Price: " . $product->price . "</p>";
	echo "<p><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px'/></p>";
		
?>	

