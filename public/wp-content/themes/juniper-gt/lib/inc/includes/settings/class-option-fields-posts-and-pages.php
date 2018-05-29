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
		'name' => __( 'Post Settings', 'grizzlytheme' ),
		'type' => 'heading'
	);

	$featured_image_option = array(
		'yes' => __( 'Yes', 'grizzlytheme' ),
		'no' => __( 'No', 'grizzlytheme' ),
	);		
	$options[] = array(
		'name' => __( 'Show Featured Image On Single Blog Post Page', 'grizzlytheme' ),
		'id' => 'show_featured_image_on_single_blog_post_page',
		'std' => 'yes',
		'type' => 'radio',
		'class' => 'mini', 
		'options' => $featured_image_option
	);
	
	$show_entry_meta = array(
		'yes' => __( 'Yes', 'grizzlytheme' ),
		'no' => __( 'No', 'grizzlytheme' ),
	);		
	$options[] = array(
		'name' => __( 'Show Entry Meta', 'grizzlytheme' ),
		'id' => 'show_entry_meta',
		'std' => 'yes',
		'type' => 'radio',
		'class' => 'mini', 
		'options' => $show_entry_meta
	);


	$options[] = array(
		'name' => __( 'Entry Meta Display Options', 'grizzlytheme' ),
		'id' => 'example_select_wide',
		'std' => '',
		'type' => 'select',
		'class'=>'mini',
		'options' =>  array(
		'one' => __( 'One', 'grizzlytheme' ),
		'two' => __( 'Two', 'grizzlytheme' ),
		'three' => __( 'Three', 'grizzlytheme' ),
		'four' => __( 'Four', 'grizzlytheme' ),
		'five' => __( 'Five', 'grizzlytheme' )
	)
	);

	$social_sharing = array(
		'yes' => __( 'Yes', 'grizzlytheme' ),
		'no' => __( 'No', 'grizzlytheme' ),
	);		
	$options[] = array(
		'name' => __( 'Enable Social Sharing For Posts', 'grizzlytheme' ),
		'id' => 'enable_social_sharing_for_posts',
		'std' => 'yes',
		'type' => 'radio',
		'class' => 'mini', 
		'options' => $social_sharing
	);

	$options[] = array(
		'name' => __( 'Similar Post ', 'grizzlytheme' ),
		'id' => 'similar_post',
		'std' => 'categories',
		'type' => 'select',
		'class'=>'mini',
		'options' =>  array(
		'categories' => __( 'Categories', 'grizzlytheme' ),
		'tags' => __( 'Tags', 'grizzlytheme' ),
	)
	);	
  	$options[] = array(
		'name' => __( 'Page Settings', 'grizzlytheme' ),
		'type' => 'heading'
	);	
	$social_sharing = array(
		'yes' => __( 'Yes', 'grizzlytheme'),
		'no' => __( 'No', 'grizzlytheme'),
	);		
	$options[] = array(
		'name' => __( 'Enable Social Sharing For Page', 'grizzlytheme' ),
		'id' => 'enable_social_sharing_for_page',
		'std' => 'yes',
		'type' => 'radio',
		'class' => 'mini', 
		'options' => $social_sharing
	);

  	return $options;
  }
}