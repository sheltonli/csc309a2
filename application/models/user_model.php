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
    $this->session->set_userdata("username", $this->input->post('username'));
    $this->session->set_userdata("email", $this->input->post('email'));

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
      $this->session->set_userdata("username", $username);
      
      $id = $this->get_user_id();
      $email = $this->get_user_email();
      $this->session->set_userdata("user_id", $id);
      $this->session->set_userdata("email", $email);

      
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

  function get_user_email(){
    $username = $this->input->post('username');
    $this->db->where('login', $username);
    $query = $this->db->get('customer');

    foreach ($query->result() as $row){
        $email = $row->email;
    }
    return $email;
  }

  function confirm_order() {
    $customer_id = $this->session->userdata('user_id');
    $ccnum = $this->input->post('ccnum');
    $ccmon = $this->input->post('ccexpmonth');
    $ccyear = $this->input->post('ccexpyear');
    $total = $this->session->userdata('total');
    $this->load->model('product_model');
    $products = $this->product_model->getAll();
    $sql = "INSERT INTO candystore.order (customer_id, order_date, order_time, total, creditcard_number, creditcard_month, creditcard_year) VALUES(".$customer_id.", CURRENT_DATE(), CURRENT_TIME(),".$total.",".$ccnum." ,".$ccmon.",".$ccyear.")";
    $this->db->query($sql);

    $order_id = $this->db->insert_id();
    foreach ($products as $product) {
      if ($this->session->userdata($product->id)) {
        $product_id = $product->id;
        $count = $this->session->userdata($product->id);
        $sql = "INSERT INTO candystore.order_item (order_id, product_id, quantity) VALUES (".$order_id.",".$product_id.",".$count.")";
        $this->db->query($sql);
      }
    }
    
  }

}
?>