<?php 
require_once 'settings/class-option-fields.php';
/**
 * create admin menu pages
 *
 *
 * @package WordPress
 * @subpackage Grizzly theme
 */

Class Options_Framework_Grizzly_Admin_Options{
   /**
    * get page name from the url
    */
   public static function get_page(){
   	    $page = '';
   		if(isset($_GET['page'])){
		 $page =  sanitize_text_field( $_GET['page'] );	
		}else if(isset($_POST['page'])){
		 $page =  sanitize_text_field( $_POST['page'] );	
		}
		if(self::valid_settings_page($page)==false){
			$page = '';
		}
		return $page;
   }
   /**
    * Set array for theme menu
    */
   public static function theme_menu_settings(){
	$submenu   = array();
	
	$submenu[] = array('label'=>__('General'),
						'page'=>'grizzly_settings_general');

	$submenu[] = array('label'=>__('Layout'),
						'page'=>'grizzly_settings_layout');

	$submenu[] = array('label'=>__('SEO'),
						'page'=>'grizzly_settings_seo');

	$submenu[] = array('label'=>__('Typography'),
						'page'=>'grizzly_settings_typography');

	$submenu[] = array('label'=>__('Styling'),
						'page'=>'grizzly_settings_styling');

	$submenu[] = array('label'=>__('Posts & Pages'),
						'page'=>'grizzly_settings_post_and_pages');

	$submenu[] = array('label'=>__('Footer'),
						'page'=>'grizzly_settings_footer');

	$submenu[] = array('label'=>__('Galleries'),
						'page'=>'grizzly_settings_galleries');

	$submenu[] = array('label'=>__('Testimonials'),
						'page'=>'grizzly_settings_testimonials');

	$submenu[] = array('label'=>__('Contact & social'),
						'page'=>'grizzly_settings_contact_and_social');

	$submenu[] = array('label'=>__('Custom css'),
						'page'=>'grizzly_settings_custom_css');

	$submenu[] = array('label'=>__('Import & Export'),
						'page'=>'grizzly_settings_import_and_export');

	$submenu[] = array('label'=>__('Slider'),
						'page'=>'grizzly_settings_slider');

  $submenu[] = array('label'=>__('Updater'),
            'page'=>'grizzly_theme_updater');
  

	return $submenu;																								
  }
/**
 * get options for the page
 */
  public static function get_options(){
  	$page = self::get_page();
  	if($page!=''){
  	$option_object = new Option_Fields($page);
  	return $option_object->options();  		
  	}else{
  		return array();
  	}

  }
/**
 * get page settings list
 */
  private static function valid_settings_page($page){
  	$pages[] = 'grizzly_settings_general';
  	$pages[] = 'grizzly_settings_layout';
  	$pages[] = 'grizzly_settings_seo';
  	$pages[] = 'grizzly_settings_typography';
  	$pages[] = 'grizzly_settings_styling';
  	$pages[] = 'grizzly_settings_post_and_pages';
  	$pages[] = 'grizzly_settings_footer';
  	$pages[] = 'grizzly_settings_galleries';
  	$pages[] = 'grizzly_settings_testimonials';
  	$pages[] = 'grizzly_settings_contact_and_social';
  	$pages[] = 'grizzly_settings_custom_css';
  	$pages[] = 'grizzly_settings_import_and_export';
  	$pages[] = 'grizzly_settings_slider'; 	 
    $pages[] = 'grizzly_theme_updater';    
     	
    
    if(in_array($page, $pages)){
    	return true;
    }else{
    	return false;
    }

  }
}