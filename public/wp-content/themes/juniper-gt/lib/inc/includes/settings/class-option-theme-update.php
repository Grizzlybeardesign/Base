<?php
/**
* Option_Fields_General
* 
* 
* @package    Wordpress
* @subpackage fields
* @author     grizzlybear
*/
class Option_Theme_Update{

  public static function options(){
		$options = array();
	  	$options[] = array(
			'name' => __( 'Update Grizzly Theme', 'grizzlytheme' ),
			'type' => 'heading'
		);


	  	

		

		return $options;	

  }
}  	