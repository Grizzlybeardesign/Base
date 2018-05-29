<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
    <main id="slider"> 
        <div class="slickSlider slick">
            <!-- This is where the gallery uploader images will go -->
            <?php the_post_thumbnail(); ?>
        </div>
        <?php get_template_part('parts/content', 'share'); ?>
    </main>
    <section id="content">
        <h1><?php the_title(); ?></h1>
        <img class="heading-bdr" src="<?php echo get_template_directory_uri(); ?>/images/blue-line-01.png" width="415">
        <?php the_content(); ?>
    </section>
    <?php
endwhile;
rewind_posts();
?>

<?php get_footer(); ?>