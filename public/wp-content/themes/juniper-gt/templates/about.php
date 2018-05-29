<?php
/*
  Template Name: About Template
 */
get_header();
?>
<?php while (have_posts()) : the_post(); ?>
    <!--Banner & Content-->
    <div id="content">
                <?php the_post_thumbnail('full'); ?>
                <h1 class="page-title"><?php the_title(); ?></h1>
                <img class="heading-bdr" src="<?php echo get_template_directory_uri(); ?>/images/blue-line-01-01.png">
            <?php the_content(); ?>
    </div>
    <?php
endwhile;
rewind_posts();
?>
<?php echo get_template_part('parts/content', 'portfolio'); ?>

<?php get_footer(); ?>