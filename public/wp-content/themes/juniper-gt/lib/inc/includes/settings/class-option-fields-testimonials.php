<?php
/**
* Option_Fields_General
* 
* 
* @package    Wordpress
* @subpackage fields
* @author     grizzlybear
*/
class Option_Fields_Testimonials{

  public static function options(){
		$options = array();
	  	$options[] = array(
			'name' => __( 'Testimonial Settings', 'grizzlytheme' ),
			'type' => 'heading'
		);
		$click_to_full_testimonial = array(
			'yes' => __( 'Yes', 'grizzlytheme' ),
			'no' => __( 'No', 'grizzlytheme' ),
		);		
		$options[] = array(
			'name' => __( 'Click To Full Testimonial.', 'grizzlytheme' ),
			'id' => 'click_to_full_testimonial',
			'std' => 'yes',
			'type' => 'radio',
			'class' => 'mini', 
			'options' => $click_to_full_testimonial
		);

		$show_featured_image = array(
			'yes' => __( 'Yes', 'grizzlytheme' ),
			'no' => __( 'No', 'grizzlytheme' ),
		);		
		$options[] = array(
			'name' => __( 'Show Featured Image On Single Testimonial Page.', 'grizzlytheme' ),
			'id' => 'show_featured_image_on_single_testimonial_page',
			'std' => 'yes',
			'type' => 'radio',
			'class' => 'mini', 
			'options' => $show_featured_image
		);	
		$options[] = array(
		'name' => __( 'View More Image Text', 'grizzlytheme' ),
		'id' => 'view_more_image_text',
		'std' => '',
		'type' => 'text'
		);	
		$options[] = array(
		'name' => __( 'Testimonial Slug', 'grizzlytheme' ),
		'id' => 'testimonial_slug',
		'std' => '',
		'type' => 'text'
		);	                
		$random_testimonial = array(
			'yes' => __( 'Yes', 'grizzlytheme' ),
			'no' => __( 'No', 'grizzlytheme' ),
		);		
		$options[] = array(
			'name' => __( 'Enable Random Testimonials', 'grizzlytheme' ),
			'id' => 'enable_random_testimonials',
			'std' => 'yes',
			'type' => 'radio',
			'class' => 'mini', 
			'options' => $random_testimonial
		);						
		return $options;

  }
}  	