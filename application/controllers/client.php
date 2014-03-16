<?php

class Client extends CI_Controller {


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
		$this->load->model('product_model');
		$products = $this->product_model->getAll();
		$data['products']=$products;
		$this->load->view('product/clientlist.php',$data);
	}

	function add() {

	}

	function remove() {

	}

	function checkout() {
		//Checkout. This function should collect payment information (credit card number and expiry date) and display a printable receipt (a simple example that shows how to print from JavaScript is available here).
	}

	function gotocheckout() {
		$this->load->view('checkout/checkout.php');
	}

	function viewcart() {
		$this->load->view('checkout/cart.php');
	}

    function read($id) {
        $this->load->model('product_model');
        $product = $this->product_model->get($id);
        $data['product']=$product;
        $this->load->view('product/clientread.php',$data);
    }

    function paymentconf(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('ccnum', 'Credit Card Number', 'required|exact_length[16]|numeric');
		$this->form_validation->set_rules('ccexp', 'Expiry Date (MM/YY)', 'required|callback_ccexp_check');

		if ($this->form_validation->run() == false){
			$this->load->view('checkout/checkout.php');
		} else {
			redirect("client", "refresh");
		}
	}

	public function ccexp_check($ccexp){
		if (preg_match("/\d{2}-\d{2}/", $ccexp) == 0){
			$this->form_validation->set_message('ccexp_check', 'Invalid Expiry Date, should be MM-YY');
			return false;
		}
		return true;
	}
}
