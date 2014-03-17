<h1>Admin Page</h1>

</p>

<?php 
		echo "<p>" . anchor('admin/viewOrders', 'View Finalized Orders') . "</p>";
		echo "<p>" . anchor('admin/deleteAll', 'Delete Customer and Order Information', array('onclick' => "return confirm('Do you want delete all customer and order information?')")) . "</p>";
 	  	echo "<h2>Product Table</h2>";
 	  	echo "<p>" . anchor('admin/newForm','Add New') . "</p>";
		echo "<table>";
		echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
		
		foreach ($products as $product) {
			echo "<tr>";
			echo "<td>" . $product->name . "</td>";
			echo "<td>" . $product->description . "</td>";
			echo "<td>" . $product->price . "</td>";
			echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";
				
			echo "<td>" . anchor("admin/delete/$product->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</td>";
			echo "<td>" . anchor("admin/editForm/$product->id",'Edit') . "</td>";
			echo "<td>" . anchor("admin/read/$product->id",'View') . "</td>";
				
			echo "</tr>";
		}
		echo "<table>";
?>	

