<h2>Look at all that candy in your cart!!</h2>
<?php
	$total = 0;
	echo "<p>" . anchor('client/index','Back') . "</p>";
	echo "<p>" . anchor('cart/gotocheckout','Checkout') . "</p>";

echo "<table>";
                echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";

                foreach ($products as $product) {
                        if ($this->session->userdata($product->id)) {
				echo "<tr>";
				echo "<td>" . $product->name . "</td>";
				echo "<td>" . $product->description . "</td>";
				echo "<td>" . $product->price . "</td>";
				echo "<td><img src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px' /></td>";

				echo "<td>" . anchor("cart/remove/$product->id",'Decrease Quantity') . "</td>";
				echo "<td>" . anchor("cart/add/$product->id",'Increase Quantity') . "</td>";
				echo "<td>" . anchor("cart/deletecandy/$product->id",'Remove from Cart', "onClick='return confirm(\"Do you really want to remove this item?\");'") . "</td>";
				echo"<td>Amount: ". $this->session->userdata($product->id) . "</td>";
                        	echo "</tr>";
				$total += ($product->price * $this->session->userdata($product->id));
                        }

                }
                echo "<table>";
		echo "<p>". "Your total is: " . $total . "</p>"
?>	
