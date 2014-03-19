<?php

class Cart extends CI_Controller {


	function __construct() {
		// Call the Controller constructor
		parent::__construct();
		$this->load->model('user_model');

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
			$total = 0;
			$this->load->model('product_model');
			$products = $this->product_model->getAll();
			$data['products'] = $products;
			foreach ($products as $product) {
                if ($this->session->userdata($product->id)) {
					$total += ($product->price * $this->session->userdata($product->id));
                }
            }
            $this->session->set_userdata('total', $total);
			$this->user_model->confirm_order();
			$this->send_email();
			$this->load->view('checkout/receipt.php', $data);	
		}
	}

	function send_email(){
		
		$email = $this->session->userdata('email');
		$this->load->library('email');

		$this->email->from('slwacandystore@gmail.com', 'SL & WA Candy Co.');
		$this->email->to($email);

		$this->email->subject('Candystore - Receipt');

		$message = "Your receipt:\n\n";
		
		$this->load->model('product_model');
		$products = $this->product_model->getAll();

		foreach ($products as $product) {
      		if ($this->session->userdata($product->id)) {
        		$message .= "Product: " . $product->name . " - $" . $product->price . " x " . $this->session->userdata($product->id) . "\n";
      		}
    	}

    	$message .= "Total: $" . $this->session->userdata('total') . "\n\n";

    	$message .= "Thank you for your purchase. Please come back for all your candy needs!";
		

		$this->email->message($message);
		
		$this->email->send();
		
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
		$this->load->model('product_model');
		$products = $this->product_model->getAll();
		$count = 0;
		foreach ($products as $product) {
      		if ($this->session->userdata($product->id)) {
      			$count += 1;
      		}
    	}
    	if ($count > 0){
    		$this->load->view('checkout/checkout.php');
    	} else {
    		redirect("cart/index","refresh");
    	}

	}
}
