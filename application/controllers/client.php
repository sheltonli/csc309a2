<?php
 
class Client extends CI_Controller {


	function __construct() {
		// Call the Controller constructor
		parent::__construct();
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

		}
		redirect("client/index","refresh");
	}

	function deletecandy($id) {
		if($this->session->userdata($id)) {
			$this->session->unset_userdata($id);
		}
		redirect("client/index","refresh");
	}

	function viewcart() {
		redirect('cart/index', 'refresh');
	}

	function go_to_logout(){
		$this->load->model('user_model');
		$this->user_model->logout();
		redirect("candystore", "refresh");
	}

    function read($id) {
        $this->load->model('product_model');
        $product = $this->product_model->get($id);
        $data['product']=$product;
        $this->load->view('product/clientread.php',$data);
    }

}
