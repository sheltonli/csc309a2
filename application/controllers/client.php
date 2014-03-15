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
		$this->load->view('checkout/checkout.php');
	}

        function read($id) {
                $this->load->model('product_model');
                $product = $this->product_model->get($id);
                $data['product']=$product;
                $this->load->view('product/clientread.php',$data);
        }

}
