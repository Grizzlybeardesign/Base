<?php
/**
* Option_Fields_General
* 
* 
* @package    Wordpress
* @subpackage fields
* @author     grizzlybear
*/
class Option_Fields_Footer{

  public static function options(){
	$options = array();
	$options[] = array(
				'name' => __( 'footer', 'grizzlytheme' ),
				'type' => 'heading'
			);
	$options[] = array(
				'name' => __( 'Add Widgets', 'grizzlytheme' ),
				'id' => 'widget_count',
				'type' => 'range',
				'std' => '3',
				'min' => 1,
	   			'max' => 4,
	    		'step' =>1
				
			);



	return $options;

  }
}  	