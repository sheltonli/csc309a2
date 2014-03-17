<?php
class User_model extends CI_Model {

	function register() {
		$data=array(
    	'first'=>$this->input->post('first'),
    	'last'=>$this->input->post('last'),
   	 	'login'=>$this->input->post('username'),
   	 	'password'=>md5($this->input->post('password')),
   	 	'email'=>$this->input->post('email')
  		);

		return $this->db->insert('customer',$data);
	}
}
?>