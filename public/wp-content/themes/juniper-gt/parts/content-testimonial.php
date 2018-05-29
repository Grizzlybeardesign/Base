<!--Testimonial Feed-->
<section id="testimonials">
    <img class="image-9" data-ix="slide-in-right" sizes="(max-width: 767px) 50vw, (max-width: 991px) 300px, 415px" src="<?php echo get_template_directory_uri(); ?>/images/blue-line-01-01.png" srcset="<?php echo get_template_directory_uri(); ?>/images/blue-line-01-01-p-500.png 500w, <?php echo get_template_directory_uri(); ?>/images/blue-line-01-01-p-800.png 800w, <?php echo get_template_directory_uri(); ?>/images/blue-line-01-01-p-1080.png 1080w, <?php echo get_template_directory_uri(); ?>/images/blue-line-01-01-p-1600.png 1600w, <?php echo get_template_directory_uri(); ?>/images/blue-line-01-01.png 1797w" width="415">
    <div class="container">
        <?php

        $random_bool = gt_get_option('enable_random_testimonials','yes');

        if($random_bool == "yes") {
            $orderby = "rand";
        }
        else{
            $orderby = "date";
        }
        

        $query = array(
            'post_type' => 'testimonials',
            'posts_per_page' => 1,
            'orderby' => $orderby,
            'order' => 'ASC'
        );
        //print_r($query);
        $queryObject = new WP_Query($query);
        if ($queryObject->have_posts()) {
            while ($queryObject->have_posts()) {
                $queryObject->the_post();
                ?>
                <div class="row">
                    <div class="col-md-8 col-offset-2 centered">
                        <div class="paragraph-tab text-block">
                            <?php the_content(); ?>
                        </div>
                        <div class="signature text-block-2"><?php the_title(); ?></div>
                    </div>
                </div>
                <?php
            }
        };
        rewind_posts();
        ?>
    </div>
</section>
<!---->