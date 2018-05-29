/**
 * Custom scripts needed for the colorpicker, image button selectors,
 * and navigation tabs.
 */

jQuery(document).ready(function($) {

	// Loads the color pickers
	var colorpicker = $('.of-color').wpColorPicker({
		selected:function(){
			autoSaveOptions(this);
		// console.log("changed");
		}
	});

	$('.save-button').click(function(){
		autoSaveOptions(this);
	});
	//console.log(colorpicker);
	// Image Options
	$('.of-radio-img-img').click(function(){
		$(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		$(this).addClass('of-radio-img-selected');
	});

	$('.of-radio-img-label').hide();
	$('.of-radio-img-img').show();
	$('.of-radio-img-radio').hide();

	// Loads tabbed sections if they exist
	if ( $('.nav-tab-wrapper').length > 0 ) {
		options_framework_tabs();
	}

	function options_framework_tabs() {

		var $group = $('.group'),
			$navtabs = $('.nav-tab-wrapper a'),
			active_tab = '';

		// Hides all the .group sections to start
		$group.hide();

		// Find if a selected tab is saved in localStorage
		if ( typeof(localStorage) != 'undefined' ) {
			active_tab = localStorage.getItem('active_tab');
		}

		// If active tab is saved and exists, load it's .group
		if ( active_tab != '' && $(active_tab).length ) {
			$(active_tab).fadeIn();
			$(active_tab + '-tab').addClass('nav-tab-active');
		} else {
			$('.group:first').fadeIn();
			$('.nav-tab-wrapper a:first').addClass('nav-tab-active');
		}

		// Bind tabs clicks
		$navtabs.click(function(e) {

			e.preventDefault();

			// Remove active class from all tabs
			$navtabs.removeClass('nav-tab-active');

			$(this).addClass('nav-tab-active').blur();

			if (typeof(localStorage) != 'undefined' ) {
				localStorage.setItem('active_tab', $(this).attr('href') );
			}

			var selected = $(this).attr('href');

			$group.hide();
			$(selected).fadeIn();

		});
	}

			var file_frame;
			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
			var set_to_post_id = 15; // Set this
			jQuery('#upload_image_button').on('click', function( event ){
				event.preventDefault();
				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					// Set the post ID to what we want
					file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
					// Open frame
					file_frame.open();
					return;
				} else {
					// Set the wp.media post id so the uploader grabs the ID we want when initialised
					wp.media.model.settings.post.id = set_to_post_id;
				}
				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Add image to Gallery',
					button: {
						text: 'Use this image',
					},
					multiple: true	// Set to true to allow multiple files to be selected
				});
				//jQuery('.gallery-images').sortable();

				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					// We set multiple to false so only get one image from the uploader

					attachment = file_frame.state().get('selection').first().toJSON();

					//console.log(file_frame.state().get('selection'));
					var selection =file_frame.state().get('selection').toJSON();
					$.each(selection,function(index,attachment){
						var $preview = $('.image-preview-wrapper').find('li:first').clone(true).show();

						$preview.find('img').attr('src',attachment.url);
						$preview.find('input').val(attachment.id);
						$('.image-preview-wrapper').append($preview);


					});
					// Do something with attachment.id and/or attachment.url here
					// $( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
					// $( '#image_attachment_id' ).val( attachment.id );
					// // Restore the main post ID
					// wp.media.model.settings.post.id = wp_media_post_id;
					//file_frame.close();
				});
					// Finally, open the modal
					file_frame.open();
			});
			// Restore the main ID when the add media button is pressed
			jQuery( 'a.add_media' ).on( 'click', function() {
				wp.media.model.settings.post.id = wp_media_post_id;
				
			});


			jQuery('.gallery-images').sortable({
                items: 'li.image',
                cursor: 'move',
                scrollSensitivity: 40,
                forcePlaceholderSize: true,
                forceHelperSize: false,
                helper: 'clone',
                opacity: 0.65,
                placeholder: 'gallery-metabox-sortable-placeholder',
                start: function (event, ui) {
                    ui.item.css('background-color', '#f6f6f6');
                },
                stop: function (event, ui) {
                    ui.item.removeAttr('style');
                },
                update: function (event, ui) {
                    var attachment_ids = '';

				
                    // $('#post_images_container ul li.image').css('cursor', 'default').each(function () {
                    //     var attachment_id = jQuery(this).attr('data-attachment_id');
                    //     attachment_ids = attachment_ids + attachment_id + ',';
                    // });

                    // $image_gallery_ids.val(attachment_ids);
                }
            });

     jQuery('.btn-gellery-remove').on('click',function(){
     	jQuery(this).closest('li').remove();
     });      
/*Range Slider*/ 


 $('#grizzly-settings-wrap input[type="range"]').rangeslider({     	
    polyfill:false,
    rangeClass:'rangeslider',
    fillClass:'rangeslider__fill',
    handleClass:'rangeslider__handle',
     onSlideEnd: function(position, value) {
	   this.$element.closest('.controls').find('.range-value-display').text(value);   
     },
     onInit:function(position, value) {
	   this.$element.closest('.controls').find('.range-value-display').text(value);   
     }
});
 


// function remove_gallery_image(ele){
//  jQuery(ele).closest('li').remove();
// }

 jQuery('#grizzly-settings-wrap input,#grizzly-settings-wrap select,#grizzly-settings-wrap textarea,#grizzly-settings-wrap .wp-color-result,#grizzly-settings-wrap #background_pattern,#grizzly-settings-wrap #logo_url,#grizzly-settings-wrap #mobile_logo_url,#grizzly-settings-wrap #footer_logo_url').change(function(){
 	//console.log("hi test");
 	autoSaveOptions(this);
 });
jQuery('.section-images img').click(function(){
    autoSaveOptions(this);
});

// jQuery('#grizzly-settings-wrap input,#grizzly-settings-wrap select,#grizzly-settings-wrap textarea,#grizzly-settings-wrap .wp-color-result,#grizzly-settings-wrap #background_image,#grizzly-settings-wrap #background_pattern,#grizzly-settings-wrap #logo_url,#grizzly-settings-wrap #mobile_logo_url,#grizzly-settings-wrap #footer_logo_url').click(function(){
//     autoSaveOptions(this);
// });


 function autoSaveOptions(ele){
	 	if(jQuery(ele).attr('id')=='import_data')
	 	{
	 	  return false;
	 	}
 	 var data = jQuery(ele).closest('form').serialize();
 	 var href = window.location.href;
 	 var url  = href.split('wp-admin/')[0];
 	 url      = url+"wp-admin/options.php";

	 	 jQuery.ajax({
			  url: url,
			  type:'post',
			  data:data,
			  dataType:'html',
			  success:function(){

			  	grizzly_notify("Settings saved",'success');			  	 
			  	

			  }
			});
 }

});

jQuery(function(){
   if(jQuery('#import_data').length>0){
   	jQuery('#export_data').prop('readonly',true);
   	jQuery('#import_data').after('<div class="import-options" ><a id="import-data-button" href="javascript:void(0)">Import</a><a id="clear-import-data-button" href="javascript:void(0)">Clear</a></div>');
   	jQuery('#import_data').val('');
   }

   jQuery('#clear-import-data-button').click(function(){
   	  jQuery('#import_data').val('');
   });
   jQuery('#import-data-button').click(function(){
   	if(confirm("you will lose all your current settings.do you want to continue?")){
       var import_data = jQuery.trim(jQuery('#import_data').val());
   	   var href = window.location.href;
	   var url  = href.split('wp-admin/')[0];
 	   url      = url+"wp-admin/admin-ajax.php";
       jQuery.ajax({
			  url: url,
			  type:'post',
			  data:{action:'import_grizzly_theme_settings',import_data:import_data},
			  dataType:'json',
			  success:function(result){
			  	jQuery('#import_data').val('');
			  	grizzly_notify(result.message,result.status);
			  }
		}); 		
   	}

   });

});

function grizzly_notify(text,status){
	 jQuery('.option-update-status').remove();
	  if(status=='success'){
	  	var status_class = 'success-status';
	  	var icon_class= 'dashicons-yes';
	  }else if(status=='error'){
	  	var status_class = 'error-status';
	  	var icon_class= 'dashicons-no';
	  }
	 jQuery('#grizzly-settings-wrap').prepend('<div style="display:none;" class="option-update-status '+status_class+'"><span class="dashicons '+icon_class+'"></span>'+text+'</div>');
	 jQuery('.option-update-status').fadeIn('slow',function(){
	 	setTimeout(function(){ jQuery('.option-update-status').fadeOut('slow'); }, 4000); 
	 });
  	 jQuery('.option-update-status').click(function(){
  	 	jQuery(this).remove();
  	 });	 	
}
