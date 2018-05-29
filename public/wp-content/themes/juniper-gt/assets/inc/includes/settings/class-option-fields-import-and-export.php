<?php
/**
* Option_Fields_General
* 
* 
* @package    Wordpress
* @subpackage fields
* @author     grizzlybear
*/
class Option_Fields_Import_And_Export{

  public static function options(){
		$options = array();
	  	$options[] = array(
			'name' => __( 'Select Demo Site From Where To Import Dummy Data', 'theme-textdomain' ),
			'type' => 'heading'
		);
		$options[] = array(
			'name' => __( 'Import ', 'theme-textdomain' ),
			'id' => 'import',
			'std' => '',
			'type' => 'select',
			'class'=>'mini',
			'options' => array()
		);	
	  	$options[] = array(
			'name' => __( 'Import/Export', 'theme-textdomain' ),
			'type' => 'heading'
		);
		 $options[] = array(
			'name' => __( 'This Is The Export Data', 'theme-textdomain' ),
			'id' => 'export_data',
			'std' => '',
			'type' => 'textarea'
		);	
		 $options[] = array(
			'name' => __( 'This Is The Import Data', 'theme-textdomain' ),
			'id' => 'import_data',
			'std' => '',
			'type' => 'textarea'
		);						
		return $options;

  }
}  	