<h2>Buy some Candy!! Nom Nom..</h2>
<?php 
		echo "<p>" . anchor('client/checkout','Checkout') . "</p>";
 	  
		echo "<table>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
		
		foreach ($products as $product) {
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
				
			echo "<td>" . anchor("client/remove/$product->id",'Remove',"onClick='return confirm(\"Do you really want to remove this item?\");'") . "</td>";
			echo "<td>" . anchor("client/add/$product->id",'Add to Cart') . "</td>";
			echo "<td>" . anchor("client/read/$product->id",'View') . "</td>";
				
			echo "</tr>";
		}
		echo "<table>";
?>	

