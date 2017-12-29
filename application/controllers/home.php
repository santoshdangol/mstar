<?php
	/**
	* 
	*/
	class Home extends CI_Controller
	{
		
		public function index()
		{
			//echo "In home->". base_url();
			$data['title'] = ucfirst("Welcome");

			$this->load->view('template/header.php', $data);
			//$this->load->view('templete/header.php');
			$this->load->view('home.php');
			$this->load->view('template/footer.php');
		}

		
	}
?>