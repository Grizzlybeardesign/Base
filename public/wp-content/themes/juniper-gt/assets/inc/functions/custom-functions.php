<?php


function footer_widgets_init() {

	register_sidebar( array(
		'name'          => 'Footer',
		'id'            => 'footer',
		'before_widget' => '<div class="col-md-3">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'footer_widgets_init' );
add_action('wp_ajax_import_grizzly_theme_settings', 'import_grizzly_theme_settings_callback');
function import_grizzly_theme_settings_callback(){
	$import = new Option_Import_And_Export();
	$import->import_grizzly_theme_settings_callback();
	die;
}
?>