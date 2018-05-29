<?php
get_header();
?>
<section id="content">
    <div class="container">
        <div class="row">

            <div class="gallery-content col-lg-12">
                <div class="gt-page-title">
                    <h1>
                    <?php 
                    
                    $recent = get_posts(array(
                        'author'=>1,
                        'orderby'=>'date',
                        'order'=>'desc',
                        'numberposts'=>1,
                        'post_type'=>'gallery'
                    ));

                    if( $recent ){
                      $title = get_the_title($recent[0]->ID);
                      echo $title;
                    }
                    ?>
                    </h1>
                    <img class="heading-bdr line" src="<?php echo get_template_directory_uri(); ?>/images/blue-line-01.png"  width="415">
                </div>
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</section>
<main id="gallery">
    <div class="container">
        <div class="row">
            <div class="grid">
                <!-- get gallery post type gallery featured image -->
                <?php
                $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;

                $args = array( 
                    'posts_per_page' => GALLERY_PER_PAGE,
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

                    foreach ($posts as $post) : setup_postdata($post); ?>
                    <!-- Column number required to be implemented in a function to be based off the Gallery layout tion -->
                    <?php 
                    
                    $post_id = get_the_ID();

                    $post_meta = get_post_meta($post_id, '_grizzly_gallery_image_list');
                    
                    foreach($post_meta as $post_meta_value) {

                        $serialize = unserialize($post_meta_value);        
                        
                        foreach ($serialize as $key => $gallery_post_id) {

                            

                            ?>
                            
                           <div class="<?php echo gallery_column_layout() ?>">
                                <!-- Figure class to be decided by styling settings -->
                                <figure class="">
                                    <a href="<?php echo get_attachment_link($gallery_post_id); ?>">
                                        <?php echo wp_get_attachment_image( $gallery_post_id, 'medium' ) ?>
                                        <figcaption>
                                            <h2><?php the_title(); ?></h2>
                                        </figcaption>   
                                    </a>
                                </figure>
                            </div>       
                            <?php
                            

                        }
                
                    }
                
                    ?>
                <?php endforeach; ?>

                <?php
                /*//echo (($paged-1)*GALLERY_PER_PAGE);
                //echo (($paged)*GALLERY_PER_PAGE);
                echo sizeof($gallery)
                $maximum_pages = ( sizeof($gallery)/GALLERY_PER_PAGE );

                for ( $i=(($paged-1)*GALLERY_PER_PAGE) ; $i<($paged*GALLERY_PER_PAGE) ; $i++ )
                {
                    ?>
                    <div class="<?php echo gallery_column_layout() ?>">
                        <!-- Figure class to be decided by styling settings -->
                        <figure class="">
                            <a href="<?php echo $gallery[$i]['link']; ?>">
                                <?php echo $gallery[$i]['image']; ?>
                                <figcaption>
                                    <h2><?php echo $gallery[$i]['title']; ?></h2>
                                </figcaption>   
                            </a>
                        </figure>
                    </div>
                <?php
                }*/
                ?>
            </div>

            <!-- pagination -->
            <?php
            $big = 999999999; // need an unlikely integer

            $pageNumbers = paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $maximum_pages,
                'prev_text' => __(''),
                'next_text' => __(''),
            ));

            if ($pageNumbers != NULL) {

                $temp = get_previous_posts_link('&lt; Previous', 0);

                echo '<div class="pagination-container">';

                if (!$temp) {
                    echo '<div id="previous-link inactive">';
                    echo "<span class='inactive'>&lt; Previous</span>";
                } else {
                    echo '<div id="previous-link">';
                    echo $temp;
                }

                echo '</div><div id="number-links">';

                echo $pageNumbers;

                $temp = get_next_posts_link('Next &gt;', $maximum_pages);

                if (!$temp) {
                    echo '</div><div id="next-link inactive">';
                    echo "<span class='inactive'>Next &gt;</span>";
                } else {
                    echo '</div><div id="next-link">';
                    echo $temp;
                }

                echo '</div></div><div class="clearfix"></div>';
            }
            ?>
            <!-- pagination - end -->
        </div>
    </div>
</main>
<?php get_footer(); ?>