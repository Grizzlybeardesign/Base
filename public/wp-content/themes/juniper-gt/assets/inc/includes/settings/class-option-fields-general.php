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
			'name' => __( 'Logos Style', 'theme-textdomain' ),
			'type' => 'heading'
		);

		$options[] = array(
			'name' => __( 'Custom Logo URL', 'theme-textdomain' ),
			'id'   => 'logo_url',
			'type' => 'upload'
		);
		$options[] = array(
			'name' => __( 'Custom Mobile Logo URL', 'theme-textdomain' ),
			'id'   => 'mobile_logo_url',
			'type' => 'upload'
		);
		$options[] = array(
			'name' => __( 'Custom Footer Logo URL', 'theme-textdomain' ),
			'id'   => 'footer_logo_url',
			'type' => 'upload'
		);
		$options[] = array(
			'name' => __( 'Favicon', 'theme-textdomain' ),
			'id'   => 'favicon',
			'type' => 'upload',
			'desc' =>__("Please select 'ico' type media file. If you don't have a favicon, you can generate one using this site",'theme-textdomain')
		);	

		$options[] = array(
			'name' => __( 'Site', 'theme-textdomain' ),
			'type' => 'heading'
		);	

		$options[] = array(
			'name' => __( 'Tracking Code', 'theme-textdomain' ),
			'desc' => __( 'Paste your Google Analytics or other tracking code here.  It will be added into the footer of this theme', 'theme-textdomain' ),
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
			'name' => __( 'Copyright Text', 'theme-textdomain' ),
			'desc' => __( 'Type here the Copyright text that will appear in the footer.  To display the current year use "%year%"' ),
			'id' => 'copyright_text',
			'type' => 'editor',
			'std'=>'Copyright © %year% <a href="http://grizzlybeardesign.co.uk" target="_blank">Grizzly Bear Design</a>.',
			'settings' => $wp_editor_settings
		);

		$affileate_array = array(
			'yes' => __( 'Yes', 'theme-textdomain' ),
			'no' => __( 'No', 'theme-textdomain' ),
		);
		$options[] = array(
			'name' => __( 'Enable Afflicate Link', 'theme-textdomain' ),
			'id' => 'enable_affileate_link',
			'std' => 'yes',
			'type' => 'radio',
			'class' => 'mini', 
			'options' => $affileate_array
		);

		$options[] = array(
		'name' => __( 'Back to Top', 'theme-textdomain' ),
		'id' => 'back_to_top',
		'std' => '1',
		'type' => 'checkbox'
	  );
			
    return $options;
  }
}