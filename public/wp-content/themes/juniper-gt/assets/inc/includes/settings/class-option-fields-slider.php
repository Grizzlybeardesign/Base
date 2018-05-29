<?php
/**
* Option_Fields_General
* 
* 
* @package    Wordpress
* @subpackage fields
* @author     grizzlybear
*/
class Option_Fields_Slider{

  public static function options(){
		$options = array();
	  	$options[] = array(
			'name' => __( 'Create Slider', 'theme-textdomain' ),
			'type' => 'heading'
		);
		$options[] = array(
		'name' => __( 'Full width', 'theme-textdomain' ),
		'id' => 'full_width',
		'std' => '1',
		'type' => 'checkbox'
	  );
		return $options;	

  }
}  	