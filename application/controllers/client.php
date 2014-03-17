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
		if ($this->session->userdata("loggedin")) {
			$this->load->model('product_model');
			$products = $this->product_model->getAll();
			$data['products']=$products;
			$this->load->view('product/clientlist.php',$data);
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
		redirect("client/index","refresh");
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
		redirect("client/index","refresh");
	}

	function checkout() {
		//Checkout. This function should collect payment information (credit card number and expiry date) and display a printable receipt (a simple example that shows how to print from JavaScript is available here).
	}

	function gotocheckout() {
		$this->load->view('checkout/checkout.php');
	}

	function viewcart() {
		redirect('cart/index', 'refresh');
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
		$this->form_validation->set_rules('ccexpmonth', 'Expiry Month', 'required|callback_ccmonth_check');
		$this->form_validation->set_rules('ccexpyear', 'Expiry Year', 'required|callback_ccexp_check');

		if ($this->form_validation->run() == false){
			$this->load->view('checkout/checkout.php');
		} else {
			redirect("client", "refresh");
		}
	}

	public function ccmonth_check($ccexpmonth){
		if ($ccexpmonth <= 0){
			$this->form_validation->set_message('ccmonth_check', 'Invalid month.');
			return false;
		} else if ($ccexpmonth > 12){
			$this->form_validation->set_message('ccmonth_check', 'Invalid month.');
			return false;
		}
		return true;
	}

	public function ccexp_check(){
		$date = getdate();
		$month = $date['mon'];
		$year = $date['year'];

		$ccmonth = $this->input->post('ccexpmonth');
   		$ccyear = $this->input->post('ccexpyear');

		if (($year % 100) > $ccyear){
			$this->form_validation->set_message('ccexp_check', 'Your card is expired.');
			return false;
		} else if (($year % 100) == $ccyear) {
			if ($month > $ccmonth){
				$this->form_validation->set_message('ccexp_check', 'Your card is expired.');
				return false;
			}
		}
		return true;
	}
}
