<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Grizzly_Base_Theme
 * @since Grizzly_Base_Theme 1.0
 * 
 */

?>
<!-- If is fullwidth need conditional to disable this section -->
</div>
</div>
<!-- END NOT FULLWIDTH CONDITIONAL -->
<footer id="footer">
    <div class="container">
        <div class="row">
            <!-- Dynamic sidebar -->
            <?php footer_widgets_display();?>
        </div>
    </div>
</footer>
<footer id="copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <!-- COPYRIGHT NOTICE HERE FROM THEME OPTIONS -->
                <?php grizzly_copyright();?>
            </div>
            <!-- AFFILIATION LINK HERE - NEEDS TO BE HARDCODED INTO A FUNCTION SO CAN'T BE ALTERED -->
            <div class="col-md-6">
                <?php grizzly_affiliation();?>
            </div>
        </div>
    </div>
</footer>
<?php if(gt_get_option('enable_social_sharing_for_page', 'yes') == 'yes'):?>
    <span class="gototop">
        <div><i class="fa fa-chevron-up"></i></div>
    </span>
<?php endif;?>
<!-- Tracking Code option to go here -->
<?php echo gt_get_option('tracking_code') ?>
<?php wp_footer(); ?>
</body>
</html>
