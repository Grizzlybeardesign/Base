<?php
/*
  Template Name: Gallery Template One
 */
get_header();
?>
<!-- THE GALLERY PAGES ARE ONLY EXAMPLES OF HOW EACH ONE AND SHOULD NOT BE INDIVIDAL. THIS IS REFERENCED VIA THE OPTIONS GALLERY -->
        <?php
$args = array(
    'posts_per_page' => 1,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'gallery',
    'post_status' => 'publish',
    'suppress_filters' => true);

$posts = get_posts($args);
?>

<!-- GALLERY IMAGES FROM UPLOADER-->
<?php $the_query = new WP_Query($args); ?>
<!-- NEEDS CONDITIONAL FOR IF NOTHING IS AVAILABLE BEFORE FOREACH -->
<main id="slider">
    <div class="slickSlider slick">
        <?php foreach ($posts as $post) : setup_postdata($post); ?>
        <!-- Link to gallery uploader -->
        <?php the_post_thumbnail('full'); ?>

<?php endforeach;?>
    </div>
</main>
<?php wp_reset_query();?>
    <!-- THE AREA BELOW NEEDS TO PULL IN THE PAGES INFORMATION AND NOT THE GALLERIES TITLE AND CONTENT -->
<?php while (have_posts()) : the_post(); ?>
    <section class="content">
        <h1><?php the_title(); ?></h1>
        <img class="heading-bdr line" src="<?php echo get_template_directory_uri(); ?>/images/blue-line-01.png"  width="415">
        </div>
        <?php the_content(); ?>
    </section>
    <?php
endwhile;
rewind_posts();
?>
<?php get_footer(); ?>