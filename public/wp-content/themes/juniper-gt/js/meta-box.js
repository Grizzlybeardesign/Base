jQuery(function(){
	jQuery('select[name=gallery_post_id]').on('change',function(){
		
		val = jQuery(this).val();
		jQuery('input[name=gallery_post_id_hidden]').val(val);

	});
});
