<?php

/**
* 
*/
class Login extends CI_Controller
{
	
	public function index()
	{
		$data['title'] = ucfirst("Login");


		//$this->form_validation->set_rules('email','')

		$this->form_validation->set_rules('emailaddress', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|md5|callback_check_email_password');

		$this->load->view('template/header.php',$data);
		$this->load->view('login.php');
		$this->load->view('template/footer.php');
	}
}
?>