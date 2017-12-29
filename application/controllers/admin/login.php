<?php 

	/**
	* 
	*/
	class Login extends CI_Controller 
	{
		function __construct() 
		{
	        parent::__construct();
			
			$this->check_session();
			
	        $this->load->model('cruddb', '', TRUE);
    	}//End function __construct() 
	
		public function check_session()
		{
			$session_data = $this->session->userdata('logged_in');
			$this->load->model('cruddb');
			if($session_data)
			{			
				if(!$this->cruddb->checkemail($session_data['email']))
				{
					$this->session->sess_destroy();
					redirect('register', 'refresh');
				}
				else if($session_data['type']=="admin")
				{
					redirect('admin', 'refresh');
				}
				else if($session_data['type']=="client")
				{
					redirect('client', 'refresh');
				}
			}
		
		}//End function check_session()

		public function index()
		{

			$data['title'] = ucfirst("Login");
		
	        //$this->load->library('form_validation');
			$this->load->library('utilities');
	        $this->form_validation->set_rules('emailaddress', 'Email', 'trim|required|xss_clean|');
	        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|md5|callback_check_email_password');
			
	        if ($this->form_validation->run() == FALSE)
	        {    
	            $this->load->view('template/header.php', $data);
	            $this->load->view('admin/login.php');
	            $this->load->view('template/footer.php');
	        } 
	        else 
	        {
	            //Go to private area
	            //echo "login passed";
	            redirect($this->user_type, 'refresh');
	        }
		}//End function index()

		/*Used in login still have to work*/
		function getToken($param)
		{
	        $url = "http://www.aeydentech.com/api/v1/example/users";
	        $ch = curl_init();
	        curl_setopt($ch,CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch,CURLOPT_POST, count($param));
	        curl_setopt($ch,CURLOPT_POSTFIELDS, $param);
	        $result =  curl_exec($ch);
	        echo "This is getToken:".$result;
	        curl_close($ch);
	        return $result;
	        print_r($result);
    	}
		

    	function check_email_password($password) 
    	{
        	//Field validation succeeded.  Validate against database      
        	//$password =  md5($password);

        	$email = $this->input->post('emailaddress');
        	//query the database
        	//print_r($email);
       		$result = $this->cruddb->checkemail($email);
        	if ($result) 
        	{
            	$result = $this->cruddb->login($email, $password);
            	if ($result) 
            	{	
               		// print_r($result);
                	$sess_array = array();
                	foreach ($result as $row)
                	{                                       
                    	$this->user_type = $row->type;
						if($row->type=='admin')
	                    {    
							$sess_array = array(
								'id' => $row->id,
								'email' => $row->email,
								'firstname' => $row->first_name,
								'lastname' => $row->last_name,
								'type' => $row->type
	                        );
	                        $param  = array(
	                            'tag' => "login",
	                            'email'=>$email,
	                            'password'=>$password,
	                            'created_at'=>date('Y-m-d H:i:s'),
	                            'updated_at'=>date('Y-m-d H:i:s')); 

	                        $result_api = $this->getToken($param);
	                       // print_r($result_api);
	                        $jsonDecode = json_decode($result_api,true);
	                        $my_token = $jsonDecode["data"]["auth_token"];
	                      //  print_r($jsonDecode['data']);
	                        $todaynp=$this->utilities->getNepaliDate(date("Y-m-d"));
	                    	$this->session->set_userdata('logged_in', $sess_array);
	                        $this->session->set_userdata('todaydate',$todaynp);
	                        $this->session->set_userdata('sms_token',$my_token);
						}
						else
						{
	                        $sess_array = array(
	                            'id' => $row->id,
	                            'member_id'=>$row->member_id,
								'email' => $row->email,
								'firstname' => $row->first_name,
								'lastname' => $row->last_name,
								'type' => $row->type
	                        );
	                        $todaynp=$this->utilities->getNepaliDate(date("Y-m-d"));
	                        $this->session->set_userdata('logged_in', $sess_array);
	                        $this->session->set_userdata('todaydate',$todaynp);
							//$this->form_validation->set_message('check_email_password', 'You havenot registered with this email');
							return true;
						}
                	}
                	return TRUE;
            	} 
	            else 
	            {
	                $this->form_validation->set_message('check_email_password', 'Wrong Password');
	                return false;
	            }
        	} 
	        else 
	        {
	            $this->form_validation->set_message('check_email_password', 'You havenot registered with this email');
	            return false;
	        }
    	}
	}
?>