<?php 
/**
 * Class option fields
 *
 *
 * @package WordPress
 * @subpackage Grizzly theme
 */
Class Option_Fields{

   var $option_object;
   var $page;
   public function __construct($page){
   	$this->page = $page;
   	$this->set_object_type();	
   }
   /**
    * set the type of object
    */
   function set_object_type(){
   	  switch($this->page){
    		case 'grizzly_settings_general':
    		 	$this->option_object   = new Option_Fields_General();
    		break;
    		case 'grizzly_settings_layout':
    		    $this->option_object = new Option_Fields_Layout();
    		break;
    		case 'grizzly_settings_seo':
    		    $this->option_object = new Option_Fields_Seo();
    		break;
    		case 'grizzly_settings_typography':
    		    $this->option_object = new Option_Fields_Typography();	
    		break;
    		case 'grizzly_settings_styling':
    		    $this->option_object = new Option_Fields_Styling();
    		break; 
    		case 'grizzly_settings_post_and_pages':
    			$this->option_object   = new Option_Fields_Posts_And_Pages();
    		break; 	
    		case 'grizzly_settings_footer':
  			$this->option_object     = new Option_Fields_Footer();
    		break;	
    		case 'grizzly_settings_galleries':
    		    $this->option_object = new Option_Fields_Galleries();
    		break;	
    		case 'grizzly_settings_testimonials':  
    		   $this->option_object  = new Option_Fields_Testimonials();
    		break; 
    		case 'grizzly_settings_contact_and_social':  
    		  $this->option_object   = new Option_Fields_Contact_And_Social();
    		break;  
    		case 'grizzly_settings_custom_css':  
    		  $this->option_object   = new Option_Fields_Custom_Css();
    		break;  
    		case 'grizzly_settings_import_and_export': 
    	 	  $this->option_object   = new Option_Fields_Import_And_Export();
    		break;    		 		  		
    		case 'grizzly_settings_slider': 
    		  $this->option_object   = new Option_Fields_Slider();
    		break;   
        case 'grizzly_theme_updater': 
          $this->option_object   = new Option_Theme_Update();
        break;   
        
  	}	
   }
  /**
   * Retun its options
   */
   public function options(){
   	return $this->option_object->options();
   }

}

spl_autoload_register(function ($class_name) {
	$class_file = str_replace('_','-',strtolower($class_name));
    @include_once 'class-'.$class_file . '.php';
});