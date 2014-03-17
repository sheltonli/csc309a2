<?php

class CandyStore extends CI_Controller {


	function __construct() {
		// Call the Controller constructor
		parent::__construct();
		$config['upload_path'] = './images/product/';
		$config['allowed_types'] = 'gif|jpg|png';
		$this->load->library('upload', $config);
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

		$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[20]');
		$this->form_validation->set_rules('first', 'First Name', 'required|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('last', 'Last Name', 'required|min_length[1]|max_length[30]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|min_length[6]|max_length[30]|matches[password]');

		if ($this->form_validation->run() == false){
			$this->load->view('welcome/signup.php');
		} else {
			//check to make certain values are unique (email, username)
			//if they are then add this new client to the db with all the required fields
			//store that the user is logged in in the session
			$this->session->set_userdata("loggedin", true);
			//go to the client page
			redirect("client", "refresh");
			//otherwise
				//start again (give an error)
		}
	}

	function login(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == false){
			$this->load->view('welcome/signin.php');
		} else {
			//store that the user is logged in in the session
			$this->session->set_userdata("loggedin", true);
			//go to the client page
			redirect("client", "refresh");
		}
	}
}
