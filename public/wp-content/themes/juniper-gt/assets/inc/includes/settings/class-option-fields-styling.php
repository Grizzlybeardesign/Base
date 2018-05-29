<?php
/**
* Option_Fields_General
* 
* 
* @package    Wordpress
* @subpackage fields
* @author     grizzlybear
*/
class Option_Fields_Styling{

  public static function options(){
  	$options = array();
  	$imagepath =  get_template_directory_uri() . '/lib/inc/images/';
  	$options[] = array(
		'name' => __( 'General', 'theme-textdomain' ),
		'type' => 'heading'
	);
	$options[] = array(
		'name' => __( 'Background Image', 'theme-textdomain' ),
		'id'   => 'background_image',
		'type' => 'upload'
	);
	$options[] = array(
		'name' => __( 'Background Pattern', 'theme-textdomain' ),
		'id'   => 'background_pattern',
		'type' => 'upload'
	);	
	$options[] = array(
		'name' => __( 'Background Color', 'theme-textdomain' ),
		'id' => 'background_color',
		'std' => '',
		'type' => 'color'
	);	
  	$options[] = array(
		'name' => __( 'Styling Settings', 'theme-textdomain' ),
		'type' => 'heading'
	);
	$options[] = array(
		'name' => __( "Image Hover Effects", 'theme-textdomain' ),
		'desc' => __( "Choose your image hover effect.", 'theme-textdomain' ),
		'id' => "image_hover_effects",
		'std' => "hover_1",
		'type' => "images",
		'options' => array(
			'hover_1' => $imagepath . 'hover_1.jpg',
			'hover_2' => $imagepath . 'hover_2.jpg',
			'hover_3' => $imagepath . 'hover_3.jpg',
			'hover_4' => $imagepath . 'hover_4.jpg',
			'hover_5' => $imagepath . 'hover_5.jpg',
			'hover_6' => $imagepath . 'hover_6.jpg',			
			)
	);		
  	$options[] = array(
		'name' => __( 'Button Colour Settings', 'theme-textdomain' ),
		'type' => 'heading'
	);	

	$options[] = array(
		'name' => __( 'Buttons Background Colour', 'theme-textdomain' ),
		'id' => 'buttons_background_color',
		'std' => '',
		'type' => 'color'
	);
	$options[] = array(
		'name' => __( 'Buttons Text Colour', 'theme-textdomain' ),
		'id' => 'buttons_text_color',
		'std' => '',
		'type' => 'color'
	);	
	$options[] = array(
		'name' => __( 'Buttons Background Hover Colour', 'theme-textdomain' ),
		'id' => 'buttons_background_hover_color',
		'std' => '',
		'type' => 'color'
	);	
	$options[] = array(
		'name' => __( 'Buttons Text Hover Colour', 'theme-textdomain' ),
		'id' => 'buttons_text_hover_color',
		'std' => '',
		'type' => 'color'
	);	
  	$options[] = array(
		'name' => __( 'Menu Links BG Hover Colour', 'theme-textdomain' ),
		'type' => 'heading'
	);	
	$options[] = array(
		'name' => __( 'Menu Links Colour', 'theme-textdomain' ),
		'id' => 'menu_links_color',
		'std' => '',
		'type' => 'color'
	);	
	$options[] = array(
		'name' => __( 'Main Menu Link Hover Colour', 'theme-textdomain' ),
		'id' => 'main_menu_link_hover_color',
		'std' => '',
		'type' => 'color'
	);	
	$options[] = array(
		'name' => __( 'Main Menu Link Active Colour', 'theme-textdomain' ),
		'id' => 'main_menu_link_active_color',
		'std' => '',
		'type' => 'color'
	);	
	$options[] = array(
		'name' => __( 'Main Menu Link BG Active Colour', 'theme-textdomain' ),
		'id' => 'main_menu_link_bg_active_color',
		'std' => '',
		'type' => 'color'
	);	
	$options[] = array(
		'name' => __( 'Menu BG Colour', 'theme-textdomain' ),
		'id' => 'menu_bg_color',
		'std' => '',
		'type' => 'color'
	);	
	$options[] = array(
		'name' => __( 'Sub Menu Links Colour', 'theme-textdomain' ),
		'id' => 'sub_menu_link_color',
		'std' => '',
		'type' => 'color'
	);
	$options[] = array(
		'name' => __( 'Sub Menu BG Colour', 'theme-textdomain' ),
		'id' => 'sub_menu_bg_color',
		'std' => '',
		'type' => 'color'
	);
	$options[] = array(
		'name' => __( 'Sub Menu Links Hover Colour', 'theme-textdomain' ),
		'id' => 'sub_menu_link_hover_color',
		'std' => '',
		'type' => 'color'
	);	

  	$options[] = array(
		'name' => __( 'Footer Colour Settings', 'theme-textdomain' ),
		'type' => 'heading'
	);
	$options[] = array(
		'name' => __( 'Footer BG Colour', 'theme-textdomain' ),
		'id' => 'footer_bg_color',
		'std' => '',
		'type' => 'color'
	);	
	$options[] = array(
		'name' => __( 'Footer Widget Title Colour', 'theme-textdomain' ),
		'id' => 'footer_widget_title_color',
		'std' => '',
		'type' => 'color'
	);
	$options[] = array(
		'name' => __( 'Footer Text Colour', 'theme-textdomain' ),
		'id' => 'footer_text_color',
		'std' => '',
		'type' => 'color'
	);	
	$options[] = array(
		'name' => __( 'Footer Link Hover Colour', 'theme-textdomain' ),
		'id' => 'footer_link_hover_color',
		'std' => '',
		'type' => 'color'
	);	
	$options[] = array(
		'name' => __( 'Footer Copyright BG Colour', 'theme-textdomain' ),
		'id' => 'footer_copyright_bg_color',
		'std' => '',
		'type' => 'color'
	);	
							
  	$options[] = array(
		'name' => __( 'Global Link Colour Settings', 'theme-textdomain' ),
		'type' => 'heading'
	);	

	$options[] = array(
		'name' => __( 'Links Colour', 'theme-textdomain' ),
		'id' => 'links_color',
		'std' => '',
		'type' => 'color'
	);	
	$options[] = array(
		'name' => __( 'Links Hover Colour', 'theme-textdomain' ),
		'id' => 'links_hover_color',
		'std' => '',
		'type' => 'color'
	);	

	$options[] = array(
		'name' => __( 'Preloader Colour', 'theme-textdomain' ),
		'id' => 'preloader_color',
		'std' => '',
		'type' => 'color'
	);

	$options[] = array(
		'name' => __( 'Preloader Background Colour', 'theme-textdomain' ),
		'id' => 'preloader_bg_color',
		'std' => '',
		'type' => 'color'
	);

	$options[] = array(
		'name' => __( 'Sliders Navigation Arrows Colour', 'theme-textdomain' ),
		'id' => 'slides_navigation_arrows_color',
		'std' => '',
		'type' => 'color'
	);	


  	return $options;
  }
}