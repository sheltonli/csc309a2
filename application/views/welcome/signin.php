<!DOCTYPE html>
<html>
    <head>
        <style>
            input { display: block;}
        </style>
        <script src="http://code.jquery.com/jquery-latest.js"></script>

    </head>

 	<body>
 		<h2>Back for more sweets eh?</h2>

        <?php 
        	echo "<p>" . anchor('candystore/index','Back') . "</p>";
			echo "<p>" . anchor('candystore/loadadmin','admin-succes-link-remove-later') . "</p>";
			echo "<p>" . anchor('candystore/loadclient','client-succes-link-remove-later') . "</p>";

            echo form_open('candystore/login');

        	echo form_label('Username');
            echo form_error('username');
            echo form_input('username', set_value('username'), "required");

            echo form_label('Password');
            echo form_error('password');
            echo form_password('password', "", "required");

            echo form_submit('submit', 'Sign In');
            echo form_close();
        ?>	
    </body>

</html>