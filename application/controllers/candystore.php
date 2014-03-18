<?php

class CandyStore extends CI_Controller {


	function __construct() {
		// Call the Controller constructor
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('session');

	}

	function index() {
		$this->load->view('welcome/welcome.php');
	}

	function signup() {
		$this->load->view('welcome/signup.php');
	}

	function signin() {
		$this->load->view('welcome/signin.php');
	}

	function loadadmin() {
		redirect("admin", "refresh");
	}

	function loadclient() {
		redirect("client", "refresh");
	}

	function register(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[20]|is_unique[customer.login]');
		$this->form_validation->set_rules('first', 'First Name', 'trim|required|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('last', 'Last Name', 'trim|required|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[customer.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|min_length[6]|max_length[30]|matches[password]');

		if ($this->form_validation->run() == false){
			$this->load->view('welcome/signup.php');
		} else {
			$this->user_model->register();
			$id = $this->user_model->get_user_id();
			$this->session->set_userdata("user_id", $id);
			//go to the client page
			redirect("client", "refresh");
		}
	}

	function login(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_login');


		if ($this->form_validation->run() == false){
			$this->load->view('welcome/signin.php');
		} else {
			//store that the user is logged in in the session
			
			//go to the client page
			$name = $this->input->post('username');
			if ($name == 'admin'){
				redirect("admin", "refresh");
			} else {
				redirect("client", "refresh");
			}
			
		}
	}

	public function check_login(){
		$is_logged_in = $this->user_model->login();
		if (!$is_logged_in){
			$this->form_validation->set_message('check_login', 'Invalid Username/Password');
			return false;
		}
		return true;
	}
}
