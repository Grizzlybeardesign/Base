<?php

if (!function_exists('grizzlytheme_enqueue_script')) {

    function grizzly_enqueue_script() {
        wp_enqueue_script('jquery', get_template_directory_uri() . '/js/vendor/jquery.js', array(), '1.0.0', true);
        wp_enqueue_script('fontawesome', 'https://use.fontawesome.com/e077424c6e.js', array(), '1.0.0', false);
        wp_enqueue_script('easing');
        wp_enqueue_script('masonry', true);
        wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array(), '1.0.0', true);
//        if (is_page_template('templates/home.php')) :
//            wp_enqueue_script('pace', get_template_directory_uri() . '/js/pace.min.js', array(), '1.0.0', true);
//        endif;
        wp_enqueue_script('app', get_template_directory_uri() . '/js/app.js', array(), '1.0.0', true);
    }

}
add_action('wp_enqueue_scripts', 'grizzlytheme_enqueue_script');
function prefix_scripts() {

		// FitVids Script conditionally enqueued from inc/extras.php
		wp_register_script(
			'prefix-fitvids',
			get_template_directory_uri() . '/js/jquery.fitvids.min.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);

}
add_action( 'wp_enqueue_scripts', 'prefix_scripts' );

/**
 * Enqueues FitVids, since the embed might be a video.
 *
 * @since 1.0.0.
 *
 * @param  string    $html    The generated HTML of the embed handler.
 * @param  string    $url     The embed URL.
 * @param  array     $attr    The attributes of the embed shortcode.
 *
 * @return string             Returned HTML.
 */
function prefix_embed_container( $html, $url, $attr ) {
	// Bail if this is the admin
	if ( is_admin() ) {
		return $html;
	}

	if ( isset( $attr['width'] ) ) {
		wp_enqueue_script( 'prefix-fitvids' );
	}

	return $html;
}
add_filter( 'embed_handler_html', 'prefix_embed_container', 10, 3 );
add_filter( 'embed_oembed_html' , 'prefix_embed_container', 10, 3 );
?>
