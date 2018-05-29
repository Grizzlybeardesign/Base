<?php
/**
* Option_Fields_General
* 
* 
* @package    Wordpress
* @subpackage fields
* @author     grizzlybear
*/
class Option_Fields_General{

  public static function options(){
  	    $options = array();

    	$options[] = array(
			'name' => __( 'Logos Style', 'grizzlytheme' ),
			'type' => 'heading'
		);

		$options[] = array(
			'name' => __( 'Custom Logo URL', 'grizzlytheme' ),
			'id'   => 'logo_url',
			'type' => 'upload'
		);
		$options[] = array(
			'name' => __( 'Custom Mobile Logo URL', 'grizzlytheme' ),
			'id'   => 'mobile_logo_url',
			'type' => 'upload'
		);
		$options[] = array(
			'name' => __( 'Custom Footer Logo URL', 'grizzlytheme' ),
			'id'   => 'footer_logo_url',
			'type' => 'upload'
		);
		$options[] = array(
			'name' => __( 'Favicon', 'grizzlytheme' ),
			'id'   => 'favicon',
			'type' => 'upload',
			'desc' =>__("Please select 'ico' type media file. If you don't have a favicon, you can generate one using this site",'grizzlytheme')
		);	

		$options[] = array(
			'name' => __( 'Site', 'grizzlytheme' ),
			'type' => 'heading'
		);	

		$options[] = array(
			'name' => __( 'Tracking Code', 'grizzlytheme' ),
			'desc' => __( 'Paste your Google Analytics or other tracking code here.  It will be added into the footer of this theme', 'grizzlytheme' ),
			'id' => 'tracking_code',
			'std' => '',
			'type' => 'textarea'
		);

		$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress,wplink' )
		);

		$options[] = array(
			'name' => __( 'Copyright Text', 'grizzlytheme' ),
			'desc' => __( 'Type here the Copyright text that will appear in the footer.  To display the current year use "%year%"' ),
			'id' => 'copyright_text',
			'type' => 'editor',
			'std'=>'Copyright © %year% <a href="http://grizzlybeardesign.co.uk" target="_blank">Grizzly Bear Design</a>.',
			'settings' => $wp_editor_settings
		);

		$affileate_array = array(
			'yes' => __( 'Yes', 'grizzlytheme' ),
			'no' => __( 'No', 'grizzlytheme' ),
		);
		$options[] = array(
			'name' => __( 'Enable Afflicate Link', 'grizzlytheme' ),
			'id' => 'enable_affileate_link',
			'std' => 'yes',
			'type' => 'radio',
			'class' => 'mini', 
			'options' => $affileate_array
		);

		$options[] = array(
		'name' => __( 'Back to Top', 'grizzlytheme' ),
		'id' => 'back_to_top',
		'std' => '1',
		'type' => 'checkbox'
	  );
			
    return $options;
  }
}