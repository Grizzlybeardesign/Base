<?php
/**
 * Share Post/Page/Job
 *
 * @package Grizzly_Base_Theme
 * @since Grizzly_Base_Theme 1.0
 */
global $post;

$message = apply_filters('grizzlytheme_share_message', sprintf(_x('Check out %1$s on %2$s! %3$s', '1: Article title 2: Site Name 3: Site URL', 'grizzlytheme'), get_the_title(), get_bloginfo('name'), get_permalink()));

$post_type = get_post_type();


$social_sharing = gt_get_option('enable_social_sharing_for_posts', 'yes');
if($post_type == 'page')
{
  $social_sharing = gt_get_option('enable_social_sharing_for_page', 'yes');
}

if($social_sharing == 'yes')
{
?>
<div class="entry-share">
    <script>
        function fbs_click() {
            u = location.href;
            t = document.title;
            window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(u) + '&t=' + encodeURIComponent(t), 'sharer', 'toolbar=0,status=0,width=626,height=436');
            return false;
        }</script>

    <ul>
<?php do_action('grizzlytheme_share_before', $message); ?>
        <li class="twitter-share"><a target="_blank" href="<?php echo esc_url(sprintf('http://www.twitter.com?status=%s', urlencode($message))); ?>"
                                     onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
                                             return false;"><i class="fa fa-twitter"></i></a></li>
        <li class="facebook-share"><a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" onclick="return fbs_click()"><i class="fa fa-facebook"></i></a></li>
        <li class="gplus-share"><a target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"
                                   onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
                                           return false;"><i class="fa fa-google-plus"></i></a></li>
        <li class="linkedin-share"><a target="_blank" href="http://www.linkedin.com/shareArticle?url=<?php the_permalink(); ?>"
                                      onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');
                                              return false;"><i class="fa fa-linkedin"></i></a></li>
        <li class="whatsapp-share"><a data-text="Take a look at this awesome website:" data-link="<?php the_permalink(); ?>" class="whatsapp w3_whatsapp_btn w3_whatsapp_btn_large"><i class="fa fa-whatsapp" aria-hidden="true">
</i></a></li>		
<?php do_action('grizzlytheme_share_after', $message); ?>
    </ul>
</div>
<?php
}
?>