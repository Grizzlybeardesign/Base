<?php
require_once dirname( __FILE__ ) . '/includes/class-options-framework-grizzly-admin.php';



/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
function optionsframework_option_name() {
	return Options_Framework_Grizzly_Admin_Options::get_page();
	
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'grizzlytheme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {
	return Options_Framework_Grizzly_Admin_Options::get_options();  
}

///////////////////////////////////CUSTOM PAGE ///////////////
// create custom plugin settings menu
add_action('admin_menu', 'grizzly_admin_create_menu');



function grizzly_admin_create_menu() {
 $submenu =  Options_Framework_Grizzly_Admin_Options::theme_menu_settings();
			add_menu_page( 
			    __('Grizzly Themes'), 
			    __('Grizzly Themes'), 
			    'manage_options', 
			    'grizzly_settings_general' 
			  );

	foreach ( $submenu as $key => $menu) {
				add_submenu_page( 
				    'grizzly_settings_general' ,
				    $menu['label'],
				    $menu['label'], 
				    'manage_options', 
				     $menu['page'] ,
				    'grizzly_settings_page' 
				);
	}
							
}			


function grizzly_settings_page(){

	 $page = Options_Framework_Grizzly_Admin_Options::get_page();
	 $submenu = Options_Framework_Grizzly_Admin_Options::theme_menu_settings();
		?>
		<div id="grizzly-settings-wrap" class="wrap">

	    <?php settings_errors( 'options-framework' ); ?>

	    <div id="optionsframework-metabox" class="metabox-holder">
         
         <div class="theme-settings-header">

         <div class="logo"> 
            <img src="<?php echo get_template_directory_uri(); ?>/lib/inc/images/grizzly-logo.png" />
         </div>

          <div class="info"> 
             <?php $theme = wp_get_theme();  ?>
            <p><?php echo $theme->get('Name'); ?></p>
            <p><?php echo $theme->get('Version'); ?></p>
            <p><?php echo $theme->get('Description'); ?></p>
          </div> 	
         </div>	
	     <ul class="options-menu" >
	     <?php foreach($submenu as $key => $menu){
	     	$href = admin_url( 'admin.php?page=' . $menu['page'] );
	      ?>
	      <li class="<?php if($page==$menu['page']){ echo 'active'; } ?> <?php  echo 'icon-'.$menu['page']; ?>"><a href="<?php echo $href; ?>"><?php echo $menu['label'] ?></a></li>
	     <?php } ?> 
	    </ul>
	     <div  id="optionsframework" class="postbox">
	    <?php  
				if( $page != 'grizzly_theme_updater' ){
				?>

		   
				<form action="options.php" method="post">
				<input type="hidden" name="page" value="<?php echo $page ?>">
				<?php settings_fields( 'optionsframework' ); ?>
				<?php Options_Framework_Interface::optionsframework_fields(); /* Settings */ ?>
				<div class="group">

				
		  		<div class="section">	
					<button type="button" id="save-button" class="button save-button" />Save</button>
				</div>	
			  	

				</div>
				</form>
			

			<?php 
			  	}
			  	else
			  	{

			  		if(isset($_GET['theme-updated']) && $_GET['theme-updated']=='true')
			  		{
			  			?>
			  			<div class="notice notice-success is-dismissible">
         				
	         				<p>
	         					Grizzly theme updated successfully. 
	         				</p>
	     					<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>

     					</div>
			  			<?php
			  		}
			  	?>

			  	<?php 

			  	$current_version = get_current_version();
			  	$update_version = get_update_version();
			  	
			  	Options_Framework_Interface::optionsframework_fields(); /* Settings */

				if($current_version->version != $update_version->version ){
				?>

			  	<form action="<?php echo admin_url('admin-post.php') ?>" method="post">
			  		<?php  ?>
			  		<p style="font-size:14px;">
			  		It is advised to backup your theme files before updating the Grizzly Theme.
			  		</p>
					<input type="hidden" name="action" value="grizzly_update_theme">
					<?php echo wp_nonce_field('grizzly-update-theme-nce'); ?>
					
					<button type="submit"  class="button">Update Theme Now</button>
					
				</form>


			  	<?php 
			  	}
			  	else{
		  		?>
		  			
	         				<p style="font-size:14px;">
	         					Your Grizzly theme is up to date.
	         				</p>
	     			
		  		<?php 
			  	}
			  }

			  ?>
			  </div> <!-- / #container -->
		</div>
		<?php do_action( 'optionsframework_after' ); ?>
		</div> <!-- / .wrap -->
<?php		
}

function admin_style() {
       wp_enqueue_style('admin-styles', get_template_directory_uri().'/lib/inc/css/grizzly.css');

  		wp_enqueue_script(
			'options-grizzlytheme',
			OPTIONS_FRAMEWORK_DIRECTORY . 'js/application.js',
			array( 'jquery','wp-color-picker' ),
			Options_Framework::VERSION
		);
		wp_enqueue_style( 'wp-color-picker' );

		if ( function_exists( 'wp_enqueue_media' ) )
			wp_enqueue_media();


		wp_localize_script( 'options-grizzlytheme', 'optionsframework_l10n', array(
			'upload' => __( 'Upload', 'grizzlytheme' ),
			'remove' => __( 'Remove', 'grizzlytheme' )
		) );

}
add_action('admin_enqueue_scripts', 'admin_style');