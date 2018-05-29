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
			'name' => __( 'Contact Details', 'grizzlytheme' ),
			'type' => 'heading'
		);
		$options[] = array(
		'name' => __( 'Contact Email', 'grizzlytheme' ),
		'id' => 'contact_email',
		'std' => '',
		'type' => 'text'
		);	
		$options[] = array(
		'name' => __( 'Contact Phone', 'grizzlytheme' ),
		'id' => 'contact_phone',
		'std' => '',
		'type' => 'text'
		);						
	  	$options[] = array(
			'name' => __( 'Location Details', 'grizzlytheme' ),
			'type' => 'heading'
		);
		$options[] = array(
			'name' => __( 'Google API Key', 'grizzlytheme' ),
			'id' => 'google_api_key',
			'type' => 'textarea'
		);

	  	$options[] = array(
			'name' => __( 'Contact Page Template Email Settings', 'grizzlytheme' ),
			'type' => 'heading'
		);	
		$users_email_address = array(
			'yes' => __( 'Yes', 'grizzlytheme' ),
			'no' => __( 'No', 'grizzlytheme' ),
		);		
		$options[] = array(
			'name' => __( "Use The User's Email Address In The 'Form' Field", 'grizzlytheme' ),
			'id' => 'users_email_address_in_the_form',
			'std' => 'yes',
			'type' => 'radio',
			'class' => 'mini', 
			'desc' => __("We recommended to enable this option. But on some hosting providers, if this option is enabled, then contact form emails may not be sent from some email addreses, in this case disable this option.",'grizzlytheme'),
			'options' => $users_email_address
		);		
	  	$options[] = array(
			'name' => __( 'Social Links Manager', 'grizzlytheme' ),
			'type' => 'heading'
		);
		
		$options[] = array(
		'name' => __( 'Facebook Profile ID', 'grizzlytheme' ),
		'id' => 'facebook_profile_id',
		'std' => 'https://www.facebook.com/pages/Grizzly-Bear-Design/116252151755804',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Twitter ID', 'grizzlytheme' ),
		'id' => 'twitter_id',
		'std' => 'https://twitter.com/grizzbeardesign',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Instagram Public Profile URL', 'grizzlytheme' ),
		'id' => 'instagram_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Pinterest Public Profile URL', 'grizzlytheme' ),
		'id' => 'pinterest_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'G+ Public Profile URL', 'grizzlytheme' ),
		'id' => 'gplus_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Dribble Public Profile URL', 'grizzlytheme' ),
		'id' => 'dribble_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Linkedin Public Profile URL', 'grizzlytheme' ),
		'id' => 'linkedin_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Vimeo Public Profile URL', 'grizzlytheme' ),
		'id' => 'vimio_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Youtube Public Profile URL', 'grizzlytheme' ),
		'id' => 'youtube_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Tumblr Public Profile URL', 'grizzlytheme' ),
		'id' => 'tumblr_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Delicious Public Profile URL', 'grizzlytheme' ),
		'id' => 'delicius_public_profile_url',
		'std' => '',
		'type' => 'text'
		);		
		$options[] = array(
		'name' => __( 'Flickr Public Profile URL', 'grizzlytheme' ),
		'id' => 'flicker_public_profile_url',
		'std' => '',
		'type' => 'text'
		
		);		
		$options[] = array(
		'name' => __( 'Skype Name', 'grizzlytheme' ),
		'id' => 'skype_name',
		'std' => '',
		'type' => 'text'
		);		
							
	 	 $options[] = array(
				'name' => __( 'Show Social Icons ', 'grizzlytheme' ),
				'id' => 'show_social_icons',
				'std' => 'header',
				'type' => 'select',
				'class'=>'mini',
				'options' =>  array(
				'none' => __( 'None', 'grizzlytheme' ),
				'header' => __( 'Header', 'grizzlytheme' ),
				'footer' => __( 'Footer', 'grizzlytheme' ),
				'header_and_footer' => __( 'Header / Footer', 'grizzlytheme' ),
				)
		 );
		return $options;

  }
}  	