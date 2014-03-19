<h2>Finalized Orders</h2>

<?php 
	if(isset($query) && $query->num_rows() > 0)	{
		echo "<table>";
		echo "<tr><th>ID</th><th>Customer ID</th><th>Date</th><th>Time</th><th>Total</th><th>Credit Card Number</th><th>Card Expiry Month</th><th>Card Expiry Year</th><th>Product ID</th><th>Quantity</th></tr>";

		$result = $query->result_array();
		foreach ($result as $row){
			echo "<tr>";
			echo "<td>" . $row['id'] . "</td>";
			echo "<td>" . $row['customer_id'] . "</td>";
			echo "<td>" . $row['order_date'] . "</td>";
			echo "<td>" . $row['order_time'] . "</td>";
			echo "<td>" . $row['total'] . "</td>";
			echo "<td>" . $row['creditcard_number'] . "</td>";
			echo "<td>" . $row['creditcard_month'] . "</td>";
			echo "<td>" . $row['creditcard_year'] . "</td>";
			echo "<td>" . $row['product_id'] . "</td>";
			echo "<td>" . $row['quantity'] . "</td>";
		}
		echo "</tr>";
		echo "</table>";
	}
?>