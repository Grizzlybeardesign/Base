<?php
/**
* Option_Fields_General
* 
* 
* @package    Wordpress
* @subpackage fields
* @author     grizzlybear
*/
class Option_Fields_Custom_Css{

  public static function options(){
		$options = array();
		 $options[] = array(
			'name' => __( 'Add Your Custom CSS', 'grizzlytheme' ),
			'id' => 'custom_css',
			'std' => '/*You can add your own CSS here.*/
',
			'type' => 'textarea'
		);
		return $options;

  }
}  	