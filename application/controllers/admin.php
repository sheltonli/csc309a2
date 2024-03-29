<?php

class Admin extends CI_Controller {


	function __construct() {
		// Call the Controller constructor
		parent::__construct();


		$config['upload_path'] = './images/product/';
		$config['allowed_types'] = 'gif|jpg|png';


		$this->load->library('upload', $config);

	}

	function index() {
		if ($this->session->userdata("loggedin") && $this->session->userdata("username") == 'admin' ) {
			$this->load->model('product_model');
			$products = $this->product_model->getAll();
			$data['products']=$products;
			$this->load->view('templates/header.php');
			$this->load->view('product/adminlist.php',$data);
			$this->load->view('templates/footer.php');
		} else {
			redirect("candystore","refresh");
		}
	}

	function newForm() {
		$this->load->view('templates/header.php');
		$this->load->view('product/newForm.php');
		$this->load->view('templates/footer.php');
	}

	function create() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required|is_unique[product.name]');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');

		$fileUploadSuccess = $this->upload->do_upload();

		if ($this->form_validation->run() == true && $fileUploadSuccess) {
			$this->load->model('product_model');

			$product = new Product();
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');

			$data = $this->upload->data();
			$product->photo_url = $data['file_name'];

			$this->product_model->insert($product);

			//Then we redirect to the index page again
			redirect('admin/index', 'refresh');
		}
		else {
			if ( !$fileUploadSuccess) {
				$data['fileerror'] = $this->upload->display_errors();
				$this->load->view('templates/header.php');
				$this->load->view('product/newForm.php',$data);
				$this->load->view('templates/footer.php');
				return;
			}

			$this->load->view('templates/header.php');
			$this->load->view('product/newForm.php');
			$this->load->view('templates/footer.php');
		}	
	}

	function read($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('templates/header.php');
		$this->load->view('product/adminread.php',$data);
		$this->load->view('templates/footer.php');
	}

	function editForm($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('templates/header.php');
		$this->load->view('product/editForm.php',$data);
		$this->load->view('templates/footer.php');
	}

	function update($id) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');

		if ($this->form_validation->run() == true) {
			$product = new Product();
			$product->id = $id;
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');

			$this->load->model('product_model');
			$this->product_model->update($product);
			//Then we redirect to the index page again
			redirect('admin/index', 'refresh');
		}
		else {
			$product = new Product();
			$product->id = $id;
			$product->name = set_value('name');
			$product->description = set_value('description');
			$product->price = set_value('price');
			$data['product']=$product;
			$this->load->view('templates/header.php');
			$this->load->view('product/editForm.php',$data);
			$this->load->view('templates/footer.php');
		}
	}

	function delete($id) {
		$this->load->model('product_model');

		if (isset($id)) 
			$this->product_model->delete($id);

		//Then we redirect to the index page again
		redirect('admin/index', 'refresh');
	}

	function viewOrders() {
		$this->db->select('*');
		$this->db->from('order');
		$this->db->join('order_item', 'order_item.order_id = order.id');

		$query = $this->db->get();

		$data['query'] = $query;
		$this->load->view('templates/header.php');
		$this->load->view('product/viewOrders.php', $data);
		$this->load->view('templates/footer.php');
	}

	function deleteAll(){
		$this->db->where('login !=', 'admin');
		$this->db->delete('customer'); 
		$this->db->empty_table('order');
		$this->db->empty_table('order_item'); 
		redirect('admin/index', 'refresh');
	}

	function go_to_logout(){
		$this->load->model('user_model');
		$this->user_model->logout();
		redirect("candystore", "refresh");
	}
}

