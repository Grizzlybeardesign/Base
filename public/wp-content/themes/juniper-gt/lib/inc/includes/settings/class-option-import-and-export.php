<?php
/**
 * Class import and export
 *
 *
 * @package WordPress
 * @subpackage Grizzly theme
 */
class Option_Import_And_Export{

	public function export_data(){
	  $option_groups = of_get_option_groups();
	  $data = array();
	  foreach($option_groups as $option_name){
	  	$data[$option_name] = get_option($option_name);
	  }
	 // print_r($data);
	  $encrypted = $this->encrypt($data);	
	  return $encrypted;		
	}

	/**
	 * Returns an encrypted & utf8-encoded
	 */
	public function encrypt($data) {
		$data = json_encode($data);
		$encrypted_string = base64_encode($data);
	    return $encrypted_string;
	}

	/**
	 * Returns decrypted original string
	 */
	public function decrypt($encrypted_string) {
		$decrypted_string = base64_decode($encrypted_string);
		$data             = json_decode($decrypted_string,TRUE);
	    return $data;
	}

	/**
	 * import grizzly settings callback
	 */

	function import_grizzly_theme_settings_callback() {
	    global $wpdb; 
	    $result = array();
	    $success = false;
	    $import_data = $_POST['import_data'];

	    $data = $this->decrypt($import_data) ;
	    $option_groups = of_get_option_groups();

	    foreach($option_groups as $option_name){
	      if(isset($data[$option_name])){
		   $option_data = $data[$option_name];
	  	   update_option($option_name,$option_data);
	  	   $success = true;      	
	      }	 
	 	 }	
	 	 if($success){
	 	 	$result['status']  = 'success';
	 	 	$result['message'] = "Settings imported";
	 	 }else{
	 	 	$result['status'] = 'error';
	 	 	$result['message'] = "Import failed,Please check the data uploaded";
	 	 }
	 	 echo json_encode($result);
	    die(); 
	}
}