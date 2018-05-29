<?php
/*
  Template Name: Home Template
 */
get_header();

$post_ID = get_the_ID();
//$gallery_post_id = get_post_meta($post_ID, 'gallery_post_id', true);


?>
<?php while (have_posts()) : the_post(); ?>
	<?php 
	$content = get_the_content();

                //$post = get_post($gallery_post_id);
                ?>

                <?php //$the_query = new WP_Query($args); ?>


                <?php 
              
                   /* $gallery = array();
                   
                    setup_postdata($post); */
                    ?>
                    <!-- Column number required to be implemented in a function to be based off the Gallery layout tion -->
                    <?php 
                    
                    $post_meta = get_post_meta($post_ID, '_grizzly_gallery_image_list');
                    ?>
                    <div id="slider">
                        <div class="slickSlider slick">
                        <?php
                        foreach($post_meta as $post_meta_value) {
                        $serialize = unserialize($post_meta_value);        
                            foreach ($serialize as $key => $gallery_post_id) {
                                ?>
                                <?php echo wp_get_attachment_image( $gallery_post_id,'full' ) ?>
                                <?php
                            }
                        }
                    ?>

                        </div>
                    </div> 



    <section id="content">
        <?php 
        //echo $content;
        format_wp_content($content);
        ?>
    </section>
    <?php
endwhile;
rewind_posts();
?>
<?php echo get_template_part('parts/content', 'portfolio'); ?>
<?php echo get_template_part('parts/content', 'testimonial'); ?>
<?php get_footer(); ?>