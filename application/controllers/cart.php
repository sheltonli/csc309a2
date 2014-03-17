<?php

class Cart extends CI_Controller {


	function __construct() {
		// Call the Controller constructor
		parent::__construct();


		$config['upload_path'] = './images/product/';
		$config['allowed_types'] = 'gif|jpg|png';
/*	    	$config['max_size'] = '100';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';
 */

		$this->load->library('upload', $config);

	}

	function index() {
		if ($this->session->userdata("loggedin")) {
			$this->load->model('product_model');
			$products = $this->product_model->getAll();
			$data['products']=$products;
			$this->load->view('checkout/cart.php',$data);
		} else {
			redirect("candystore","refresh");
		}
	}

	function add($id) {
		if (!$this->session->userdata($id)) {
			//if this isn't in the cart
			//add it to the cart with quantity 1
			$this->session->set_userdata($id, 1);

		} else {
			//increment quantity by 1
			$this->session->set_userdata($id, $this->session->userdata($id) + 1);
		}
		redirect("cart/index","refresh");
	}

	function remove($id) {
		if ($this->session->userdata($id)) {
			//if it is in the cart
			//reduce by 1
			$this->session->set_userdata($id, $this->session->userdata($id) - 1);
			
			if ($this->session->userdata($id) == 0) {
				//remove from the cart
				$this->session->unset_userdata($id);
			}
		}
		redirect("cart/index","refresh");
	}

	function checkout() {
		//Checkout. This function should collect payment information (credit card number and expiry date) and display a printable receipt (a simple example that shows how to print from JavaScript is available here).
	}

	function deletecandy($id) {
		if($this->session->userdata($id)) {
			$this->session->unset_userdata($id);
		}
		redirect("cart/index","refresh");
	}

	function gotocheckout() {
		$this->load->view('checkout/checkout.php');
	}
}
