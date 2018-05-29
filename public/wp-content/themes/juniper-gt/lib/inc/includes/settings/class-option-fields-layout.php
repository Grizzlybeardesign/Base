<?php
/**
* Option_Fields_General
* 
* 
* @package    Wordpress
* @subpackage fields
* @author     grizzlybear
*/
class Option_Fields_Layout{

  public static function options(){
        $options = array();
        $imagepath =  get_template_directory_uri() . '/lib/inc/images/';
		$options[] = array(
			'name' => __( 'General', 'grizzlytheme' ),
			'type' => 'heading'
		);	

		$site_width_array = array(
			'yes' => __( 'Yes', 'grizzlytheme' ),
			'no' => __( 'No', 'grizzlytheme' ),
		);
		$options[] = array(
			'name' => __( 'Site Full Width', 'grizzlytheme' ),
			'id' => 'site_full_width',
			'std' => 'yes',
			'type' => 'radio',
			'class' => 'mini', 
			'options' => $site_width_array
		);
		$options[] = array(
			'name' => __( 'Header Settings', 'grizzlytheme' ),
			'type' => 'heading'
		);
		$sticky_menu_array = array(
			'yes' => __( 'Yes', 'grizzlytheme' ),
			'no' => __( 'No', 'grizzlytheme' ),
		);		
		$options[] = array(
			'name' => __( 'Enable Sticky Menu', 'grizzlytheme' ),
			'id' => 'enable_sticky_menu',
			'std' => 'no',
			'type' => 'radio',
			'class' => 'mini', 
			'options' => $sticky_menu_array
		);

		$options[] = array(
				'name' => "Logo & Navigation",
				'desc' =>'Choose your Logo and Navigation layout.',
				'id' => "logos_and_navigation",
				'std' => "header-style-1",
				'type' => "images",
				'options' => array(
					'header-style-1' => $imagepath . 'header-style-1.png',
					'header-style-2' => $imagepath . 'header-style-2.png',
				)
	   );
		$options[] = array(
			'name' => __( '404 Settings', 'grizzlytheme' ),
			'type' => 'heading'
		);
	   	$options[] = array(
		'name' => "404 Layout",
		'desc' => "Layout for 404 page",
		'id' => "404_layout",
		'std' => "layout-right",
		'type' => "images",
		'options' => array(
			'layout-left' =>  $imagepath . 'layout-left.png',
			'layout-right' => $imagepath . 'layout-right.png',
			'layout-full' =>  $imagepath . 'layout-full.png'
			)
		);
		$options[] = array(
			'name' => __( '404 Image', 'grizzlytheme' ),
			'id'   => '404_image',
			'type' => 'upload',
			
		);	
	   	$options[] = array(
		'name' => "404 Image Alignment",
		'id' => "404_image_alignment",
		'std' => "layout-right",
		'type' => "images",
		'options' => array(
			'layout-left' =>  $imagepath . 'layout-left.png',
			'layout-right' => $imagepath . 'layout-right.png',
			'layout-full' =>  $imagepath . 'layout-full.png'
			)
		);	

		$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress,wplink' )
		);

		$options[] = array(
			'name' => __( '404 Error Message', 'grizzlytheme' ),
			'id' => '404_error_message',
			'type' => 'editor',
			'std'=>'',
			'settings' => $wp_editor_settings
		);
		$options[] = array(
			'name' => __( 'Layout Page Settings', 'grizzlytheme' ),
			'type' => 'heading'
		);	
		
	   $options[] = array(
		'name' => "Pages",
		'desc' => "Layout for pages",
		'id' => "pages_layout",
		'std' => "layout-right",
		'type' => "images",
		'options' => array(
			'layout-left' =>  $imagepath . 'layout-left.png',
			'layout-right' => $imagepath . 'layout-right.png',
			'layout-full' =>  $imagepath . 'layout-full.png'
			)
		);	
	   $options[] = array(
		'name' => "Single Posts",
		'desc' => "Layout for single post",
		'id' => "single_post_layout",
		'std' => "layout-full",
		'type' => "images",
		'options' => array(
			'layout-left' =>  $imagepath . 'layout-left.png',
			'layout-right' => $imagepath . 'layout-right.png',
			'layout-full' =>  $imagepath . 'layout-full.png'
			)
		);
	   $options[] = array(
		'name' => "Front / Blog Page / Search / Archive / Category / Tags / Author",
		'desc' => "Layout for front page",
		'id' => "other_page_layout",
		'std' => "layout-right",
		'type' => "images",
		'options' => array(
			'layout-left' =>  $imagepath . 'layout-left.png',
			'layout-right' => $imagepath . 'layout-right.png',
			'layout-full' =>  $imagepath . 'layout-full.png'
			)
		);
	   $options[] = array(
		'name' => "Attachment Page",
		'desc' => "Layout for attachment page",
		'id' => "attachment_layout",
		'std' => "layout-full",
		'type' => "images",
		'options' => array(
			'layout-left' => $imagepath . 'layout-left.png',
			'layout-right' => $imagepath . 'layout-right.png',
			'layout-full' => $imagepath . 'layout-full.png'
			)
		);	   
        return $options;  
  }
}