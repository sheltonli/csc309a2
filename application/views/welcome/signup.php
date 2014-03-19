<!DOCTYPE html>
<html>
    <head>
        <style>
            input { display: block;}
        </style>

        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script>
        function checkPassword(){
            var P1 = $("#pass1");
            var P2 = $("#pass2");
            if (P1.val() == P2.val()){
                P1.get(0).setCustomValidity("");
                return true;
            } else {
                P1.get(0).setCustomValidity("Passwords do not match");
                return false;
            }
        }
        </script>
    </head>

    <body>
        <h2>Sign up to start purchasing sweets!</h2>
        <?php 
        	echo "<p>" . anchor('candystore/index','Back') . "</p>";

            echo form_open('candystore/register');

        	echo form_label('Username');
            echo form_error('username');
            echo form_input('username', set_value('username'), "required");

            echo form_label('First Name');
            echo form_error('first');
            echo form_input('first', set_value('first'), "required");

            echo form_label('Last Name');
            echo form_error('last');
            echo form_input('last', set_value('last'), "required");

            echo form_label('Email');
            echo form_error('email');
            echo form_input('email', set_value('email'), "required");

            echo form_label('Password');
            echo form_error('password');
            echo form_password('password', "", "id='pass1' required");

            echo form_label('Password Confirmation');
            echo form_error('passconf');
            echo form_password('passconf', "", "id='pass2' required oninput='checkPassword()'");

            echo form_submit('submit', 'Register');
            echo form_close();
        ?>	
    </body>

</html>