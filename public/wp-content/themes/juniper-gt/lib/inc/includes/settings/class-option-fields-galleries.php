<?php
/**
* Option_Fields_General
* 
* 
* @package    Wordpress
* @subpackage fields
* @author     grizzlybear
*/
class Option_Fields_Galleries{

  public static function options(){
		$options = array();
		 $imagepath =  get_template_directory_uri() . '/lib/inc/images/';
		$options[] = array(
			'name' => __( 'Gallery Settings', 'grizzlytheme' ),
			'type' => 'heading'
		);
		$social_sharing = array(
		'yes' => __( 'Yes', 'grizzlytheme' ),
		'no' => __( 'No', 'grizzlytheme' ),
		);		
		$options[] = array(
			'name' => __( 'Social Sharing For Galleries', 'grizzlytheme' ),
			'id' => 'social_sharing_for_page_galleries',
			'std' => 'yes',
			'type' => 'radio',
			'class' => 'mini', 
			'options' => $social_sharing
		);	
		$options[] = array(
			'name' => __( 'Gallery Display Options', 'grizzlytheme' ),
			'type' => 'heading'
		);


		$options[] = array(
		'name' => __( 'Related Galleries', 'grizzlytheme' ),
		'id' => 'related_galleries',
		'std' => '1',
		'type' => 'checkbox'
	  );
		$options[] = array(
		'name' => __( 'Gallery Slug', 'grizzlytheme' ),
		'id' => 'gallery_slug',
		'std' => '',
		'type' => 'gallery',
                'placeholder' => 'test'
		);	
	  $options[] = array(
				'name' => "Layout",
				'desc' =>'Choose your gallery display style.',
				'id' => "layout",
				'std' => "gallery_style_3",
				'type' => "images",
				'options' => array(
					'gallery_style_1' => $imagepath . 'gallery_grid_1.jpg',
					'gallery_style_2' => $imagepath . 'gallery_grid_2.jpg',
					'gallery_style_3' => $imagepath . 'gallery_grid_3.jpg',
				)
				);		
		
		return $options;

  }
}  	