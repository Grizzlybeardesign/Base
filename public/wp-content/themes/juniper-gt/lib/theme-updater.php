<?php


function get_current_version(){
	return json_decode(file_get_contents(get_template_directory().'/version.json'));
}

function get_update_version(){
	return json_decode(file_get_contents('http://yourdevelopmentupdate.co.uk/grizzly/theme_version.json'));
}


$current_version = get_current_version();

$update_version  = get_update_version();


function grizzly_get_notification(){

	$update_version  = get_update_version();
	
	return '<div class="notice notice-warning is-dismissible">
         <p>There is a new version of Grizzly Themes available. Version '.$update_version->version.'.  
         <a href="admin.php?page=grizzly_theme_updater">Update now</a>.</p>
     </div>';

}

function grizzly_update_notification(){
    $page = $_GET['page'];
    echo grizzly_get_notification();    
}



if($current_version->version < $update_version->version ){
	add_action('admin_notices', 'grizzly_update_notification');
}

function theme_settings_page(){
 	?>
    <div class="wrap">
    <h1>Theme Panel</h1>
    <form method="post" action="options.php">
        <?php
            settings_fields("section");
            do_settings_sections("theme-options");      
            submit_button(); 
        ?>          
    </form>
	</div>
	<?php
}


add_action("admin_menu", "add_theme_menu_item");


function grizzly_update_theme_callback(){

    check_admin_referer('grizzly-update-theme-nce');
	
    $update_version  = get_update_version();
	$zip = 'http://gbd-test.biz/grizzlytheme/theme-update/'.$update_version->file;
	$folder = trailingslashit(get_template_directory()."/inc-download");
	$new_folder = trailingslashit(get_template_directory());
	$filename = $folder.'inc.zip';
	$tmpfile = download_url( $zip, $timeout = 300 );
 	$a = copy( $tmpfile, $filename );
	unlink( $tmpfile ); // must unlink afterwards
	
	if($a)
	{

	$content = "<?php \$upgrading = time(); ?>";
	
	$fp = fopen("../.maintenance","wb");
	fwrite($fp,$content);
	fclose($fp);

	$version_content = '{"version":"'.$update_version->version.'"}';
	
	
	$fp = fopen(get_template_directory()."/version.json","wb");
	fwrite($fp,$version_content);
	fclose($fp);


	rename(get_template_directory().'/inc', get_template_directory().'/inc-old');
	$opening_file =  $new_folder.'inc';

	$zip = new ZipArchive;

	$res = $zip->open($filename, ZipArchive::CREATE);
		if ($res === TRUE){
		$zip->extractTo($new_folder);
		$zip->close();
	  	chmod($opening_file , 0755);
	  	unlink("../.maintenance");
	  	unlink($filename);
	  	wp_redirect('admin.php?page=grizzly_theme_updater&theme-updated=true');
		} 
		else {
			unlink("../.maintenance");
		}
	}
}
add_action('admin_post_grizzly_update_theme', 'grizzly_update_theme_callback');