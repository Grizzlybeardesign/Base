<?php
/*
  Template Name: Contact Template
 */
get_header();
?>
<?php while (have_posts()) : the_post(); ?>

<?php echo get_template_part ('parts/content', 'banner');?>
<!--Contact Page Form-->
  <section class="contact section">
    <?php the_content();?>
      <!-- Here is where the social links will go -->
      <!-- Here is where the contact email and contact phone options will display -->
      <!-- Here is where the google Maps will go linking to the google API Key -->
  </section>
<!---->
    <?php
endwhile;
rewind_posts();
?>
<?php get_footer(); ?>