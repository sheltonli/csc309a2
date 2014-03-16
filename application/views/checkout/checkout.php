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
            echo form_input('ccnum', "", "required pattern='\d{16}' title='Your card should have 16 digits.'");

            echo form_label('Expiry Month');
            echo form_error('ccexpmonth');
            echo form_input('ccexpmonth', "", "required pattern='\d{2}' title='Please enter your card's expiry month.");

            echo form_label('Expiry Year');
            echo form_error('ccexpyear');
            echo form_input('ccexpyear', "", "required pattern='\d{2}' title='Please enter your card's expiry year.");

            echo form_submit('submit', 'Confirm Order');
            echo form_close();
        ?>	
    </body>

</html>
