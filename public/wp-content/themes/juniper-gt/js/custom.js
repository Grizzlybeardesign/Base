(function() {
    tinymce.PluginManager.add('custom_button', function( editor, url ) {


        editor.addButton( 'custom_button', {
            text: 'Blank Portion',
            icon: false,
            onclick: function() {
                editor.insertContent('<h3 class="blank">Blank Portion</h3>');
            }
        });
        editor.on('change', function(e) {

            // Get the editor content (html)
            get_ed_content = tinymce.activeEditor.getContent();
            jQuery('#copyright_text').val(get_ed_content).trigger("change");
            jQuery('#404_error_message').val(get_ed_content).trigger("change");
            
	
        });

    });

    
    

    current_template = jQuery('#page_template').val();

    if(current_template != 'templates/home.php')
        jQuery('#gallery-images').hide();

    jQuery('#page_template').on('change',function(){

        current_template = jQuery(this).val();
        
        if( current_template != 'templates/home.php' )
            jQuery('#gallery-images').hide();        
        else
            jQuery('#gallery-images').show();

    });

    



})();