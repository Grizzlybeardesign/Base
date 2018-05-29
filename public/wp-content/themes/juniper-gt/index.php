<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Grizzly_Base_Theme
 * @since Grizzly_Base_Theme 1.0
 * 
 */
get_header();
?>

<section id="content" class="<?php echo gt_get_option('other_page_layout') ?>">
    <div class="row">
        <div class="col-lg-12">
            <div class="container"><img src="<?php echo get_template_directory_uri(); ?>/images/Header-Image.jpg">
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">

            <?php if (have_posts()) : ?>
            
                if ( is_home() && ! is_front_page() ) : ?>
                
                <header>
                    <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                </header>

                <?php
            endif;
            /* Start the Loop */
            while (have_posts()) : the_post();
                ?>

                <div class="col-md-6">
    <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>'); ?>
                    <div class="post-content sidebar-blocks clearfix">
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?></a>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <?php the_excerpt(); ?>
                        <a class="button-2" href="<?php the_permalink(); ?>">READ MORE</a>
                    </div>
                </div>
                <?php
            endwhile;

            the_posts_navigation();

            else:

            get_template_part('template-parts/content', 'none');

            endif; // end have_posts() check 
            ?>
        </div>
</section>
<?php
if (function_exists('grizzlytheme_pagination')) {
    grizzlytheme_pagination();
} else if (is_paged()) {
    ?>
    <nav id="post-nav">
        <div class="post-previous"><?php next_posts_link(__('&larr; Older posts', 'grizzlybear')); ?></div>
        <div class="post-next"><?php previous_posts_link(__('Newer posts &rarr;', 'grizzlybear')); ?></div>
    </nav>
<?php } ?>
<?php get_footer(); ?>