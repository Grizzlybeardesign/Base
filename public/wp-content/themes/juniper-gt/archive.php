<?php get_header(); ?>
<section id="content" class="<?php echo gt_get_option( 'other_page_layout' ) ?>">
    <div class="row">
        <div class="col-lg-12">
                <?php if (have_posts()) : ?>
                        <?php if (is_category()) { ?>
                        <h1 class="title">
                        <?php single_cat_title(); ?>
                        </h1>
                        <?php } elseif (is_tag()) { ?>
                        <h1 class="title">
                        <?php single_tag_title(); ?>
                        </h1>
                        <?php } elseif (is_author()) { ?>
                        <h1 class="title">
                        <?php get_the_author_meta('display_name'); ?>
                        </h1>
                        <?php } elseif (is_day()) { ?>
                        <h1 class="title">
                        <?php the_time('l, F j, Y'); ?>
                        </h1>
                        <?php } elseif (is_month()) { ?>
                        <h1 class="title">
                        <?php the_time('F Y'); ?>
                        </h1>
                        <?php } elseif (is_year()) { ?>
                        <h1 class="title">
                        <?php the_time('Y'); ?>
                        </h1>
                        <?php
                    };
                endif;
                ?>
            </div>
            <section class="section">
                <div class="container">
                    <div class="row">
                        <?php if (have_posts()) : ?>
                            <?php while (have_posts()) : the_post(); ?>
                                <div class="col-md-6">
                                    <div class="post-content sidebar-blocks clearfix">
                                        <?php the_post_thumbnail('large'); ?>
                                        <h2><?php the_title(); ?></h2>
                                        <p><?php the_excerpt(); ?></p>
                                        <a class="button" href="<?php the_permalink(); ?>">READ MORE ty</a>
                                    </div>
                                </div>
                           <?php endwhile; ?>
                        <?php endif; // end have_posts() check ?>
                    </div>
                </div>
            </section>
            <?php
            if (function_exists('gt_pagination')) {
                gt_pagination();
            } else if (is_paged()) {
                ?>
                <nav id="post-nav">
                    <div class="post-previous"><?php next_posts_link(__('&larr; Older posts', 'grizzlybear')); ?></div>
                    <div class="post-next"><?php previous_posts_link(__('Newer posts &rarr;', 'grizzlybear')); ?></div>
                </nav>
            <?php } ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>