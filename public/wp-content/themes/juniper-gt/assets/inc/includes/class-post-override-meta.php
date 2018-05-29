<?php
/**
 * Override post meta
 *
 *
 * @package WordPress
 * @subpackage Grizzly theme
 */
Class Post_Override_Meta Extends Post_Meta_Inputs{
	var $option_name;
	var $meta_prefix;
	/**
	 * Construct functions
	 */
	public function __construct(){
	  $this->option_name  = 'grizzly_custom_post_meta';	
	  $this->meta_prefix  = '_custom_post_meta_';
	  $this->init();	
	}
    /**
     * initialize functions
     */
	private function init(){

		add_action( 'add_meta_boxes', array($this,'grizzly_register_meta_boxes') );
		add_action( 'added_post_meta', array($this,'grizzly_after_post_meta'), 10, 4 );
		add_action( 'updated_post_meta', array($this,'grizzly_after_post_meta'), 10, 4 );	
	}
	/**
	 * register meta boxes
	 */
   function grizzly_register_meta_boxes() {
        add_meta_box( 'meta-box-id', __( 'Post Settings', 'textdomain' ), array($this,'grizzly_post_meta_display_callback'), 'page','normal' );
                add_meta_box( 'meta-box-id', __( 'Post Settings', 'textdomain' ), array($this,'grizzly_post_meta_display_callback'), 'post','normal' );
    }
    /**
     * after the post meta
     */
    function grizzly_after_post_meta( $meta_id, $post_id, $meta_key, $meta_value){
	    if(isset($_POST['grizzly_custom_post_meta'])){
	      $custom_post_meta = 	 $_POST['grizzly_custom_post_meta'];
	       foreach ($custom_post_meta as $key => $value) {
	       	$field_key = $this->meta_prefix.$key;
	        update_post_meta($post_id,$field_key,maybe_serialize($value));
	       }
	    }
    }
    /**
     * display post type
     */
    function grizzly_post_meta_display_callback($post){
    		global $allowedtags;
    		$post_id   		= $post->ID;
    	  	$options 		= array();

			$social_sharing = array(
				'yes' => __( 'Yes', 'theme-textdomain'),
				'no' => __( 'No', 'theme-textdomain'),
			);		
			$options[] = array(
				'name' => __( 'Show page title', 'theme-textdomain' ),
				'id' => 'show_page_title',
				'std' => 'no',
				'type' => 'radio',
				'class' => 'mini', 
				'options' => $social_sharing
			);

			$social_sharing = array(
				'yes' => __( 'Yes', 'theme-textdomain'),
				'no' => __( 'No', 'theme-textdomain'),
			);		
			$options[] = array(
				'name' => __( 'Enable Social Sharing For Page', 'theme-textdomain' ),
				'id' => 'enable_social_sharing_for_page',
				'std' => 'no',
				'type' => 'radio',
				'class' => 'mini', 
				'options' => $social_sharing
			);

			$options_framework = '';
			$settings          = array();
			$option_name = $this->option_name;
			$show_page_title =  get_post_meta($post_id,$this->meta_prefix.'show_page_title');			
			$enable_social_sharing_for_page =  get_post_meta($post_id,$this->meta_prefix.'enable_social_sharing_for_page');
			if(isset($enable_social_sharing_for_page[0])){
			  $settings['enable_social_sharing_for_page'] = $enable_social_sharing_for_page[0];		
			}
			if(isset($show_page_title[0])){
			  	$settings['show_page_title'] = $show_page_title[0];
		    }
			$counter = 0;
			$menu = '';
			$this->grizzly_input_fields($options,$options_framework,$option_name,$settings,$counter,$menu,$allowedtags);
    }

}