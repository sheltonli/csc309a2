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

	function paymentconf(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('ccnum', 'Credit Card Number', 'trim|required|exact_length[16]|numeric');
		$this->form_validation->set_rules('ccexpmonth', 'Expiry Month', 'trim|required|callback_ccmonth_check');
		$this->form_validation->set_rules('ccexpyear', 'Expiry Year', 'trim|required|callback_ccexp_check');

		if ($this->form_validation->run() == false){
			$this->load->view('checkout/checkout.php');
		} else {
			//display the printable recepit
			$this->load->model('user_model');
			$this->load->model('product_model');
			$products = $this->product_model->getAll();
			$data['products']=$products;
			$total = 0;
			foreach ($products as $product) {
                if ($this->session->userdata($product->id)) {
					$total += ($product->price * $this->session->userdata($product->id));
                }
            }
            $this->session->set_userdata('total', $total);
			$this->user_model->confirm_order();
			$this->load->view('checkout/receipt.php', $data);	
			//email the receipt
			//redirect("client", "refresh");
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
