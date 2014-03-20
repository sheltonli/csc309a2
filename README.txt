Shelton Li 999009905
William Armstrong 993418789

SL & WA Candy Co. Store Readme


Overview of the site:

	The candystore controller controls the signin and signup aspects of the site.

	Admin controller controls all aspects of the admin (viewing orders, deleting tables, adding/editing/deleting products and their respective views).

	Client controller controls all aspects of a regular user (viewing products and adding/removing products from cart).

	Cart controller controls all aspects of the cart and checking out (editing product quantity in the cart, checkout, receipt and email that come with checking out).

	The data that is stored in the session are loggedin (determines if user has logged in), username, userid, products (key) and their quantity (value), and total of the order.

	For the email functionality, we have also added email.php in the config folder that has the settings for the email library to work.



Controllers: Only explaining functions that are not 1 line redirects or loading views. Also, both admin and client reuse starter code (adding items, viewing product list, etc.), so those
functions will not be explained.

candystore - register 			This is the handler function for the form in signup.php. It does the appropriate form validation per the assignment requirements. Once the form is 
								validated, if it fails, it will return to signup.php with appropriate errors. If it is successful, the register function from the user_model will be 
								called, sets session data with the user's id, and redirect to the admin or client controller depending on which account signs up.

		   - login 				This is the handler function for the form in signin.php. It does the appropriate form validation per the assignment requirements. If the form validation 
		   						fails, it will return to signin.php with appropriate errors. If it is successful, depening on which account signs in (admin or a client) it will redirect 
		   						to their appropriate controller.

		   - check_login		One of the callback functions used by the signin.php form. It will call the user_model's login function and if it was successful it will return true, else 
		   						it will display an error message.

admin 	   - index				Checks session data to see if the person accessing this page is logged in and the admin. If so, it will load all the products into an array and then go to 
								adminlist.

		   - viewOrders			Generates a query that will join both the order and order_item table. Will then pass the query to viewOrders.php.

		   - deleteAll			This will delete all entries from customer table not named admin. Will also drop the order and order_item tables.

		   - go_to_logout		Calls the logout function from the user_model and then redirects to the candystore controller.

client 	   - index				Same as the index function from the admin controller. Does not check if the user is admin, only that they are logged.

		   - add 				If the item is not in the session array (client has not added it to their cart), it will be added with a value of 1 (meaning quantity of 1).

		   - deletecandy		Checks to see if item is already added to the client's cart, if so, remove it from the session meaning that it is no longer in the cart.		

		   - go_to_logout		Calls the logout function from the user_model and then redirects to the candystore controller.

cart 	   - index				Same as the index function from the admin controller. Does not check if the user is admin, only that they are logged.

		   - add 				Will add 1 to the value stored in the session array for the product.

		   - remove				Will subtract 1 to the value stored in the session array for the product. If the value reaches 0, it will remove the product from the session array.

		   - paymentconf		Handler function for checkout.php. Does all the form validation as specified by the assignment. If validation is successful, it will calculate the total of
		    					the order and store it in the session array. It will also call the confirm_order function from the user_model, and then send_email in the cart controller. 
		    					It will just reload the checkout page with error messages if the validation fails.

		   - send_email			Utilizes the CodeIgniter email library to send an email. It will send to the client's email (which is stored in the session array). It will generate a 
		   						message by iterating through products and finding ones that the user wants to purchase. It will then append to a string the product name, price, and the 
		   						quantity that they want to purchase. It will also append the total cost of the purchase and a nice thank you message. The email will then be sent.

		   - ccmonth_check		One of the callback functions for the form validation in checkout. This one checks to see if the expiry month entered by a client is valid. It just checks 
		   						that it is between 1 and 12.

		   - ccexp_check		One of the callback functions for the form validation in checkout. This one checks to see if the overall month and year entered makes sense. If the year is
		    					less than the current year, then the card is expired. Else if the year is the same, but the month is less than the current month, it is expired.

		   - deletecandy		Same as deletecandy from the admin controller.

		   - gotocheckout		Does a quick check to see if there is something in the cart. If not, it redirects to the cart controller index. Else it goes to checkout.php.


Models:

user_model - register			Creates an array with the form data from signup.php. Sets session data (loggedin, username, and email), and inserts the array into the customer table. 

		   - login 				Retrieves data from the form in signin.php. Queries the customer table to look for a user with the provided info. If found, set session data (loggedin, 
		   						username, userid and email), and return true to mark that login was successful. If a user is not found, false is returned.

		   - logout				Deletes all session data, then ets loggedin to false in the session data (this is needed to prevent people from accessing parts of the site without signing
		    					in).

		   - get_user_id 		Retrieves the user's id from the customer table using the provided login from the form.

		   - get_user_email		Retrieves the user's email from the customer table using the provided login from the form.

		   - confirm_order		Retrieves all the data needed for storing into the order and order_item tables to confirm an order (this is done through retrieving form data from checkout.
		  						php and session data). One query is generated and inserted into the order table. Then for we loop through all of the user's products that they have added to
		  						their cart, generate a query and insert it into the order_item table.


Views:

welcome/ - welcome				Provides a link to signup.php and signin.php.

		 - signup				Provides a form which takes a username, first name, last name, email, password, and password confirmation. The handler for this form is candystore 
								register. 
		 						There is also a JS function called checkPassword (taken from lecture notes) that will compare the password and password confirmation to make sure that they 
		 						are the same.

		 - signing 				Provides a form which takes a username and a password. The handler for this form is candstore/login.

product/ - adminlist			Edited version of the list view provided in the starter code. Edited so it now has links to view finalized orders, deleting customer and order information,
 								and logout. All of this is handled by the admin controller.

		 - adminread			Same as the provided starter code read, except it has a back button to go back to adminlist.

		 - clientlist			Edited version of the list view provided in the starter code. Edited so it now has links to view cart, and logout. All of this is handled by the client 
		 						controller.

		 - clientread			Same as the provided starter code read, except it has a back button to go back to clientlist.

		 - editForm				Edited to have a back button that leads to adminlist.

		 - list					Unchanged.

		 - newForm				Edited to have a back button that leads to adminlist.

		 - read					Unchanged.

		 - viewOrders			Displays finalized orders. Given query results, loop through them and place them into a table. 

checkout/ - cart 				An edited version of the starter code list. Contains links to go back to the clientlist and also to checkout. Given an array of all the products, it will 
								check against the session data to see which items the client has added to their cart. It will list the items that were added to the cart, and with options 
								to increase/decrease the quantity, and to remove it from the cart. Also the total cost of all the items will be displayed. All of this is handled by the cart
								controller.

		  - checkout			A form that takes in credit card information (number, and expiry). Handled by the cart controller. 

		  - receipt				Reused code from given example to display a pop out receipt. Given an array of all the products, figure out which ones the client is buying, and then 
		  						display all the appropriate info (such as name, quantity and price). Also displays the total cost of the order. There is also a link which will return the 
		  						client to the clientlist.