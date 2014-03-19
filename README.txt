Controllers:
candystore

admin

client

cart


Models:
user_model - register			Creates an array with the form data from signup.php. Sets session data (loggedin, username, and email), and inserts the array into the customer table. 

		   - login 				Retrieves data from the form in signin.php. Queries the customer table to look for a user with the provided info. If found, set session data (loggedin, 						 username, userid and email), and return true to mark that login was successful. If a user is not found, false is returned.

		   - logout				Deletes all session data, then ets loggedin to false in the session data (this is needed to prevent people from accessing parts of the site without signing 					 in).

		   - get_user_id 		Retrieves the user's id from the customer table using the provided login from the form.

		   - get_user_email		Retrieves the user's email from the customer table using the provided login from the form.

		   - confirm_order		Retrieves all the data needed for storing into the order and order_item tables to confirm an order (this is done through retrieving form data from checkout.					 php and session data). One query is generated and inserted into the order table. Then for we loop through all of the user's products that they have added to 					   their cart, generate a query and insert it into the order_item table.

Views:

welcome/ - welcome

		 - signup

		 - signin

product/ - adminlist

		 - adminread

		 - clientlist

		 - clientread

		 - editForm

		 - list

		 - newForm

		 - read

		 - viewOrders

checkout/ - cart

		  - checkout

		  - receipt


