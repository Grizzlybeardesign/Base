<?php

function grizzlytheme_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?>>
        <article id="comment-<?php comment_ID(); ?>">
            <header class="comment-author">
    <?php echo get_avatar($comment, $size = '48'); ?>
                <div class="author-meta">
    <?php printf(__('<cite class="fn">%s</cite>', 'grizzlytheme'), get_comment_author_link()) ?>
                    <time datetime="<?php echo comment_date('c') ?>"><a href="<?php echo esc_url(get_comment_link($comment->comment_ID)) ?>"><?php printf(__('%1$s', 'grizzlybear'), get_comment_date(), get_comment_time()) ?></a></time>

                </div>
            </header>

            <?php if ($comment->comment_approved == '0') : ?>
                <div class="notice">
                    <p class="bottom"><?php _e('Your comment is awaiting moderation.', 'grizzlytheme') ?></p>
                </div>
                <?php endif; ?>

            <section class="comment">
    <?php comment_text() ?>
    <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        <?php edit_comment_link(__('(Edit)', 'grizzlytheme'), '', '') ?>
            </section>

        </article>
    <?php } ?>

    <?php
// Do not delete these lines
    if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die(__('Please do not load this page directly. Thanks!', 'grizzlytheme'));

    if (post_password_required()) {
        ?>
        <section id="comments">
            <div class="notice">
                <p class="bottom"><?php _e('This post is password protected. Enter the password to view comments.', 'grizzlytheme'); ?></p>
            </div>
        </section>
        <?php
        return;
    }
    ?>
            <?php // You can start editing here. Customize the respond form below  ?>
            <?php if (have_comments()) : ?>
        <section id="comments">
            <h5><?php comments_number(__('No Responses to', 'grizzlytheme'), __('One Response to', 'grizzlytheme'), __('% Responses to', 'grizzlytheme')); ?> &#8220;<?php the_title(); ?>&#8221;</h5>
            <ol class="commentlist">
    <?php wp_list_comments('type=comment&callback=grizzlytheme_comments'); ?>

            </ol>
            <footer>
                <nav id="comments-nav">
                    <div class="comments-previous"><?php previous_comments_link(__('&larr; Older comments', 'grizzlytheme')); ?></div>
                    <div class="comments-next"><?php next_comments_link(__('Newer comments &rarr;', 'grizzlytheme')); ?></div>
                </nav>
            </footer>
        </section>
<?php else : // this is displayed if there are no comments so far  ?>
    <?php if (comments_open()) : ?>
    <?php else : // comments are closed  ?>
            <section id="comments">
                <div class="notice">
                    <p class="bottom"><?php _e('Comments are closed.', 'grizzlytheme') ?></p>
                </div>
            </section>
    <?php endif; ?>
        <?php endif; ?>
        <?php if (comments_open()) : ?>
        <section id="respond">
            <h5><?php comment_form_title(__('Leave a Reply', 'grizzlybear'), __('Leave a Reply to %s', 'grizzlytheme')); ?></h5>
            <p class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></p>
                <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
                <p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.', 'grizzlytheme'), wp_login_url(get_permalink())); ?></p>
                <?php else : ?>
                <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
        <?php if (is_user_logged_in()) : ?>
                        <p><?php printf(__('Logged in as <a href="%s/wp-admin/profile.php">%s</a>.', 'grizzlytheme'), get_option('siteurl'), $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php __('Log out of this account', 'grizzlybear'); ?>"><?php _e('Log out &raquo;', 'grizzlybear'); ?></a></p>
                        <textarea name="comment" id="comment" placeholder="<?php _e('Your message here...', 'grizzlytheme'); ?>" tabindex="4"></textarea>
        <?php else : ?>
                        <div class="row">
                            <div class="col-md-7">
                                <input type="text" class="col-md-5" name="author" id="author" placeholder="<?php _e('Name', 'grizzlytheme');
            if ($req) _e(' (required)', 'grizzlybear'); ?>" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?>>
                                <input type="text" class="col-md-5" name="email" id="email" placeholder="<?php _e('Email (will not be published)', 'grizzlybear');
            if ($req) _e(' (required)', 'grizzlybear'); ?>" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?>>
                                <input type="text" class="col-md-5" placeholder="<?php _e('Website', 'grizzlybear'); ?>" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3">
                            </div>
                            <div class="col-md-5 ">
                                <textarea name="comment" id="comment" placeholder="<?php _e('Your message here...', 'grizzlytheme'); ?>" tabindex="4"></textarea>
                            </div>
                        </div>
            <?php endif; ?>
                    <input name="submit" type="submit" id="submit" tabindex="5" value="<?php esc_attr_e('Submit Comment', 'grizzlytheme'); ?>">
        <?php comment_id_fields(); ?>
        <?php do_action('comment_form', $post->ID); ?>
                </form>
    <?php endif; // If registration required and not logged in  ?>
        </section>
<?php
endif; // if you delete this the sky will fall on your head ?>