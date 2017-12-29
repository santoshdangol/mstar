<?php

	//---------------using url_title() function helps to make human friendly title for url using '-' for space-----------
	//--------------url_decode helps to change the title in url back to its original form-------------
	function url_decode($val){
		
		return str_replace("-", " ", $val);
		
	}


/*------------Returns active if selected menu found-----------------
	* $menu_item: current menu item
	* $compare: contains menu item name to which $menu_item is to be compared
	*/
	
	function active_menu_item($menu_item="", $compare){ 
		if($menu_item == $compare){
			return "active";
		}
		else{
			return null;
		}
	}
	
	
/*---------used to set the selected value for multiselect comparing the value form the array-----------------------*/	
	function set_multiselect($value, $val_array){
		if(in_array($value, $val_array)){
			return "selected = 'selected'";
		}
	}
	
	function set_dropdown($search, $compare){
		if($search == $compare){
			return "selected = 'selected'";
		}
	}
	
//-----------------------get email verification code-----------------------------

	function email_code(){
		return md5(uniqid(rand(), true));;
	}
	
/*--------------helps to generate work code--------------------------------------*/

	function work_code($work_id, $datatype, $website_id){
		
	}

/*---------------get status of job------------------------*/

	function job_status($status){
		if(empty($status)){
			return "availabe";
		}
		else{
			return $status;
		}
	}
	
//------------Convert to date time through time()-----------------

	function to_datetime($time){
		
		return date('Y-m-d H:i:s', $time);
		
	}
	
	function get_date($datetime){
		$date = new DateTime($datetime);
		return $date->format('Y-m-d');
	}
	
	function get_time($datetime){
		$date = new DateTime($datetime);
		return $date->format('H:i:s');	
	}
	


?>