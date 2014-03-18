<?php
class User_model extends CI_Model {

	function register() {
		$data=array(
    	'first'=>$this->input->post('first'),
    	'last'=>$this->input->post('last'),
   	 	'login'=>$this->input->post('username'),
   	 	'password'=>$this->input->post('password'),
   	 	'email'=>$this->input->post('email')
  		);
    $this->session->set_userdata("loggedin", true);

		return $this->db->insert('customer',$data);
	}

	function login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->db->where('login', $username);
    $this->db->where('password', $password);
        
    $query = $this->db->get('customer');

    if (isset($query) && $query->num_rows() > 0){
      $this->session->set_userdata("loggedin", true);
      
      $id = $this->get_user_id();
      $this->session->set_userdata("user_id", $id);
      
      return true;
    }
    return false;
	}

  function get_user_id(){
    $username = $this->input->post('username');
    $this->db->where('login', $username);
    $query = $this->db->get('customer');

    foreach ($query->result() as $row){
        $id = $row->id;
    }
    return $id;
  }

  function confirm_order() {
    $customer_id = $this->session->userdata('user_id');
    $ccnum = $this->input->post('ccnum');
    $ccmon = $this->input->post('ccexpmonth');
    $ccyear = $this->input->post('ccexpyear');

    
  }

}
?>