<?php
/*
  Template Name: Gallery Template Two
 */
get_header();
?>
<section id="content">
    <div class="container">
        <div class="row">

            <div class="gallery-content col-lg-12">
                <div class="gt-page-title">
                    <h1><?php the_title(); ?></h1>
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
                    'posts_per_page' => 6,
                    'orderby' => 'post_date',
                    'order' => 'DESC',
                    'post_type' => 'gallery',
                    'post_status' => 'publish',
                    'paged' => $paged,
                    'suppress_filters' => true);

                $posts = get_posts($args);
                ?>

                <?php $the_query = new WP_Query($args); ?>
                <?php foreach ($posts as $post) : setup_postdata($post); ?>
                    <!-- Column number required to be implemented in a function to be based off the Gallery layout option -->
                    <div class="<?php echo gallery_column_layout() ?>">
                        <!-- Figure class to be decided by styling settings -->
                        <figure class="">
                            <a href="<?php the_permalink(); ?>">
                                <?php echo the_post_thumbnail('medium'); ?>
                                <figcaption>
                                    <h2><?php the_title(); ?></h2>
                                </figcaption>   
                            </a>
                        </figure>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- pagination -->
            <?php
            $big = 999999999; // need an unlikely integer

            $pageNumbers = paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $the_query->max_num_pages,
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

                $temp = get_next_posts_link('Next &gt;', $the_query->max_num_pages);

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