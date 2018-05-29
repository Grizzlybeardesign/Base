<?php
/**
* Option_Fields_General
* 
* 
* @package    Wordpress
* @subpackage fields
* @author     grizzlybear
*/
class Option_Fields_Contact_And_Social{

  public static function options(){
		 $options = array();
		 
	  	$options[] = array(
			'name' => __( 'Contact Details', 'theme-textdomain' ),
			'type' => 'heading'
		);
		$options[] = array(
		'name' => __( 'Contact Email', 'theme-textdomain' ),
		'id' => 'contact_email',
		'std' => '',
		'type' => 'text'
		);	
		$options[] = array(
		'name' => __( 'Contact Phone', 'theme-textdomain' ),
		'id' => 'contact_phone',
		'std' => '',
		'type' => 'text'
		);						
	  	$options[] = array(
			'name' => __( 'Location Details', 'theme-textdomain' ),
			'type' => 'heading'
		);
		$options[] = array(
			'name' => __( 'Google API Key', 'theme-textdomain' ),
			'id' => 'google_api_key',
			'type' => 'textarea'
		);

	  	$options[] = array(
			'name' => __( 'Contact Page Template Email Settings', 'theme-textdomain' ),
			'type' => 'heading'
		);	
		$users_email_address = array(
			'yes' => __( 'Yes', 'theme-textdomain' ),
			'no' => __( 'No', 'theme-textdomain' ),
		);		
		$options[] = array(
			'name' => __( "Use The User's Email Address In The 'Form' Field", 'theme-textdomain' ),
			'id' => 'users_email_address_in_the_form',
			'std' => 'yes',
			'type' => 'radio',
			'class' => 'mini', 
			'desc' => __("We recommended to enable this option. But on some hosting providers, if this option is enabled, then contact form emails may not be sent from some email addreses, in this case disable this option.",'theme-textdomain'),
			'options' => $users_email_address
		);		
	  	$options[] = array(
			'name' => __( 'Social Links Manager', 'theme-textdomain' ),
			'type' => 'heading'
		);
		
		$options[] = array(
		'name' => __( 'Facebook Profile ID', 'theme-textdomain' ),
		'id' => 'facebook_profile_id',
		'std' => 'https://www.facebook.com/pages/Grizzly-Bear-Design/116252151755804',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Twitter ID', 'theme-textdomain' ),
		'id' => 'twitter_id',
		'std' => 'https://twitter.com/grizzbeardesign',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Instagram Public Profile URL', 'theme-textdomain' ),
		'id' => 'instagram_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Pinterest Public Profile URL', 'theme-textdomain' ),
		'id' => 'pinterest_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'G+ Public Profile URL', 'theme-textdomain' ),
		'id' => 'gplus_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Dribble Public Profile URL', 'theme-textdomain' ),
		'id' => 'dribble_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Linkedin Public Profile URL', 'theme-textdomain' ),
		'id' => 'linkedin_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Vimeo Public Profile URL', 'theme-textdomain' ),
		'id' => 'vimio_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Youtube Public Profile URL', 'theme-textdomain' ),
		'id' => 'youtube_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Tumblr Public Profile URL', 'theme-textdomain' ),
		'id' => 'tumblr_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Delicious Public Profile URL', 'theme-textdomain' ),
		'id' => 'delicius_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Flickr Public Profile URL', 'theme-textdomain' ),
		'id' => 'flicker_public_profile_url',
		'std' => '',
		'type' => 'text'
		
		);		
		$options[] = array(
		'name' => __( 'Skype Name', 'theme-textdomain' ),
		'id' => 'skype_name',
		'std' => '',
		'type' => 'text'
		);		
							
	 	 $options[] = array(
				'name' => __( 'Show Social Icons ', 'theme-textdomain' ),
				'id' => 'show_social_icons',
				'std' => 'header',
				'type' => 'select',
				'class'=>'mini',
				'options' =>  array(
				'none' => __( 'None', 'theme-textdomain' ),
				'header' => __( 'Header', 'theme-textdomain' ),
				'footer' => __( 'Footer', 'theme-textdomain' ),
				'header_and_footer' => __( 'Header / Footer', 'theme-textdomain' ),
				)
		 );
		return $options;

  }
}  	