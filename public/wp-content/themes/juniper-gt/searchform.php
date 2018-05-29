<form role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
    <div class="row collapse">
        <div class="-10 ">
            <input type="text" value="" name="s" id="s" placeholder="<?php esc_attr_e('Search', 'grizzlybear'); ?>">

            <input type="hidden" name="post_type" value="post" /> 
            <div class="-2 ">
                <button type="submit">Submit</button>
            </div>
        </div>
    </div>
</form>