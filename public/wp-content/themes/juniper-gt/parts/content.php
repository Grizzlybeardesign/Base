<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Grizzly_Base_Theme
 * @since Grizzly_Base_Theme 1.0
 * 
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
                <a class="back-blog button" href="<?php echo get_bloginfo('url'); ?>/blog">Back to Blog</a>

		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
                
                $post_type = get_post_type();

                if ($post_type == 'testimonials' && gt_get_option('show_featured_image_on_single_testimonial_page', 'yes') == 'yes') {
                    the_post_thumbnail('full');
                } else if ($post_type != 'testimonials' && gt_get_option('show_featured_image_on_single_blog_post_page', 'yes') == 'yes') {
                    the_post_thumbnail('full');
                }
                
                if ($post_type != 'testimonials' && gt_get_option('show_entry_meta', 'yes') == 'yes'):
                    ?>
                    <div class="entry-meta">
                        <ul>
                            <li><a class="post-archive"><?php the_date(); ?></a></li>
                            <li><a class="post-archive"><?php the_category(); ?></a></li>
                        </ul>
                    </div>
                    <?php
                endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'grizzlytheme' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'grizzlytheme' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php grizzlytheme_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
