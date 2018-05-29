<?php
/**
* Option_Fields_General
* 
* 
* @package    Wordpress
* @subpackage fields
* @author     grizzlybear
*/
class Option_Fields_Typography{

  public static function options(){
  	$options = array();
  		// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '' );

  	$options[] = array( 'name' => __( 'Body Text', 'theme-textdomain' ),
		'id' => "typography_body_text",
		'std' => $typography_defaults,
		'type' => 'typography'
	);

  	$options[] = array( 'name' => __( 'H1', 'theme-textdomain' ),
		'id' => "typography_h1",
		'std' => $typography_defaults,
		'type' => 'typography'
	);
  	$options[] = array( 'name' => __( 'H2', 'theme-textdomain' ),
		'id' => "typography_h2",
		'std' => $typography_defaults,
		'type' => 'typography'
	);	
  	$options[] = array( 'name' => __( 'H3', 'theme-textdomain' ),
		'id' => "typography_h3",
		'std' => $typography_defaults,
		'type' => 'typography'
	);
  	$options[] = array( 'name' => __( 'H4', 'theme-textdomain' ),
		'id' => "typography_h4",
		'std' => $typography_defaults,
		'type' => 'typography'
	);
  	$options[] = array( 'name' => __( 'H5', 'theme-textdomain' ),
		'id' => "typography_h5",
		'std' => $typography_defaults,
		'type' => 'typography'
	);
  	$options[] = array( 'name' => __( 'H6', 'theme-textdomain' ),
		'id' => "typography_h6",
		'std' => $typography_defaults,
		'type' => 'typography'
	);

  	return $options;
  }
}