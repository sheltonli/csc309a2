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

		return $this->db->insert('customer',$data);
	}

	function login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->db->where('login', $username);
        $this->db->where('password', $password);
        
        $query = $this->db->get('customer');

        if (isset($query) && $query->num_rows > 0){
        	return true;
        }
       	return false;
	}
}
?>