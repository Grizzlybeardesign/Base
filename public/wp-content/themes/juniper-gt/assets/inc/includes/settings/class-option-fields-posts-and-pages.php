<?php
/**
* Option_Fields_General
* 
* 
* @package    Wordpress
* @subpackage fields
* @author     grizzlybear
*/
class Option_Fields_Posts_And_Pages{

  public static function options(){
  	$options 		= array();
  	$options[] = array(
		'name' => __( 'Post Settings', 'theme-textdomain' ),
		'type' => 'heading'
	);

	$featured_image_option = array(
		'yes' => __( 'Yes', 'theme-textdomain' ),
		'no' => __( 'No', 'theme-textdomain' ),
	);		
	$options[] = array(
		'name' => __( 'Show Featured Image On Single Blog Post Page', 'theme-textdomain' ),
		'id' => 'show_featured_image_on_single_blog_post_page',
		'std' => 'yes',
		'type' => 'radio',
		'class' => 'mini', 
		'options' => $featured_image_option
	);
	
	$show_entry_meta = array(
		'yes' => __( 'Yes', 'theme-textdomain' ),
		'no' => __( 'No', 'theme-textdomain' ),
	);		
	$options[] = array(
		'name' => __( 'Show Entry Meta', 'theme-textdomain' ),
		'id' => 'show_entry_meta',
		'std' => 'yes',
		'type' => 'radio',
		'class' => 'mini', 
		'options' => $show_entry_meta
	);


	$options[] = array(
		'name' => __( 'Entry Meta Display Options', 'theme-textdomain' ),
		'id' => 'example_select_wide',
		'std' => '',
		'type' => 'select',
		'class'=>'mini',
		'options' =>  array(
		'one' => __( 'One', 'theme-textdomain' ),
		'two' => __( 'Two', 'theme-textdomain' ),
		'three' => __( 'Three', 'theme-textdomain' ),
		'four' => __( 'Four', 'theme-textdomain' ),
		'five' => __( 'Five', 'theme-textdomain' )
	)
	);

	$social_sharing = array(
		'yes' => __( 'Yes', 'theme-textdomain' ),
		'no' => __( 'No', 'theme-textdomain' ),
	);		
	$options[] = array(
		'name' => __( 'Enable Social Sharing For Posts', 'theme-textdomain' ),
		'id' => 'enable_social_sharing_for_posts',
		'std' => 'yes',
		'type' => 'radio',
		'class' => 'mini', 
		'options' => $social_sharing
	);

	$options[] = array(
		'name' => __( 'Similar Post ', 'theme-textdomain' ),
		'id' => 'similar_post',
		'std' => 'categories',
		'type' => 'select',
		'class'=>'mini',
		'options' =>  array(
		'categories' => __( 'Categories', 'theme-textdomain' ),
		'tags' => __( 'Tags', 'theme-textdomain' ),
	)
	);	
  	$options[] = array(
		'name' => __( 'Page Settings', 'theme-textdomain' ),
		'type' => 'heading'
	);	
	$social_sharing = array(
		'yes' => __( 'Yes', 'theme-textdomain'),
		'no' => __( 'No', 'theme-textdomain'),
	);		
	$options[] = array(
		'name' => __( 'Enable Social Sharing For Page', 'theme-textdomain' ),
		'id' => 'enable_social_sharing_for_page',
		'std' => 'yes',
		'type' => 'radio',
		'class' => 'mini', 
		'options' => $social_sharing
	);

  	return $options;
  }
}