<!DOCTYPE html>
<html>
    <head>
        <style>
            input { display: block;}
        </style>
        <script src="http://code.jquery.com/jquery-latest.js"></script>

    </head>

 	<body>
 		<h2>Spend all your money on Candy!!</h2>

        <?php 
        	echo "<p>" . anchor('client/index','Back') . "</p>";
        	echo "<p> Please fill in your payment information. You will be emailed your receipt.</p>";

            echo form_open('client/paymentconf');

        	echo form_label('Credit Card Number');
            echo form_error('ccnum');
            echo form_input('ccnum', "", "required");

            echo form_label('Expiry Date (MM-YY)');
            echo form_error('ccexp');
            echo form_input('ccexp', "", "required pattern='\d{2}-\d{2}' title='MM/YY'");

            echo form_submit('submit', 'Confirm Order');
            echo form_close();
        ?>	
    </body>

</html>
