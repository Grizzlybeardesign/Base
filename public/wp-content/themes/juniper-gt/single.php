<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Grizzly_Base_Theme
 * @since Grizzly_Base_Theme 1.0
 * 
 */
get_header();
?>

<div id="primary" class="content-area <?php echo gt_get_option('single_post_layout') ?>">
    <main id="main" class="site-main">
        <?php while (have_posts()) : the_post(); ?>

            <div class="row">
                <?php
                get_template_part('parts/content', get_post_type());

                the_post_navigation();

                get_template_part('parts/content', 'share');

                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            </div>
        </main>
    </div>
<?php endwhile; ?>

<?php
get_footer();
