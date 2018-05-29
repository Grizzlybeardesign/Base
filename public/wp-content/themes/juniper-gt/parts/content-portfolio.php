<!--Gallery Feed-->
<section id="recent-portfolio">
    <div class="container">
        <h2 class="heading-2" data-ix="slide-up">Recent Work</h2>
        <div class="row">
            <?php
            /*$query = array(
                'post_type' => 'gallery',
                'posts_per_page' => 3,
                'orderby' => 'date',
                'order' => 'ASC'
            );
            //print_r($query);
            $queryObject = new WP_Query($query);
            if ($queryObject->have_posts()) {
                while ($queryObject->have_posts()) {
                    $queryObject->the_post();
                    ?>
                    <div class="col-md-4">
                        <a href="<?php the_permalink();?>">
                            <figure class="effect-salmon">
                                <?php the_post_thumbnail('large'); ?>
                                <figcaption>
                                    <h3><span class="inn"><?php the_title(); ?></span></h3>
                                </figcaption>
                            </figure>
                        </a>
                    </div>
                    <?php
                }
            };
            rewind_posts();*/
            ?>












            <?php


            $args = array( 
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'post_type' => 'gallery',
                    'post_status' => 'publish',
                    'paged' => $paged,
                    'suppress_filters' => true
                    );

                $posts = get_posts($args);
                ?>

                <?php //$the_query = new WP_Query($args); ?>


                <?php 

                    $gallery = array();

                    $i = 0;
                    foreach ($posts as $post) : setup_postdata($post); ?>
                    <!-- Column number required to be implemented in a function to be based off the Gallery layout tion -->
                    <?php 
                    
                    $post_id = get_the_ID();

                    $post_meta = get_post_meta($post_id, '_grizzly_gallery_image_list');
                    
                    foreach($post_meta as $post_meta_value) {

                        $serialize = unserialize($post_meta_value);        
                        
                        foreach ($serialize as $key => $gallery_post_id) {

                            if($i>2)
                                continue;

                            ?>
                                
                           <div class="col-md-4">
                                <!-- Figure class to be decided by styling settings -->
                                <figure class="effect-salmon">
                                    <a href="<?php echo get_attachment_link($gallery_post_id); ?>">
                                        <?php echo wp_get_attachment_image( $gallery_post_id, 'medium' ) ?>
                                        <figcaption>
                                            <h3><span class="inn"><?php the_title(); ?></span></h3>
                                        </figcaption>   
                                    </a>
                                </figure>
                            </div>       
                            <?php
                            
                            $i++;
                        }
                
                    }
                
                    ?>
                <?php endforeach; ?>

        </div>
        <a class="button-2" data-ix="slide-up" href="<?php echo get_bloginfo('url');?>/portfolio/">SEE MY PORTFOLIO</a>
        <div class="bdr"></div>
    </div>
</section>