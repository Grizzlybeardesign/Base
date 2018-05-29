<?php
/**
* Option_Fields_General
* 
* 
* @package    Wordpress
* @subpackage fields
* @author     grizzlybear
*/
class Option_Fields_Seo{

  public static function options(){
  	$options = array();
    $options[] = array(
		'name' => __( 'Titles For The Site', 'theme-textdomain' ),
		'type' => 'heading'
	);	

	$options[] = array(
		'name' => __( 'Blog Page Title', 'theme-textdomain' ),
		'id' => 'blog_page_title',
		'std' => 'Welcome to the blog',
		'type' => 'text'
	);
	$options[] = array(
		'name' => __( 'Category Page Title', 'theme-textdomain' ),
		'id' => 'category_page_title',
		'std' => 'Category archives: %',
		'desc'=>__('The "%" will be replaced with the actual category name, for example "Uncategorized"','theme-textdomain' ),
		'type' => 'text'
	);
	$options[] = array(
		'name' => __( 'Tags Page Title', 'theme-textdomain' ),
		'id' => 'tags_page_title',
		'std' => 'Tags archives: %',
		'desc'=>__('The "%" will be replaced with the actual tag name, for example "tag1"','theme-textdomain' ),		
		'type' => 'text'
	);
	$options[] = array(
		'name' => __( 'Author Page Title', 'theme-textdomain' ),
		'id' => 'author_page_title',
		'desc'=>__('The "%" will be replaced with the author name, for example "Bob"','theme-textdomain' ),
		'std' => 'Author archives: %',
		'type' => 'text'
	);	
	$options[] = array(
		'name' => __( 'Search Page Title', 'theme-textdomain' ),
		'id' => 'search_page_title',
		'desc'=>__('The "%" will be replaced with the searching string, for example "Lorem ipsum"','theme-textdomain' ),
		'std' => 'Search results: %',
		'type' => 'text'
	);
	$options[] = array(
		'name' => __( 'Daily Archives Page Title', 'theme-textdomain' ),
		'id' => 'daily_archive_page_title',
		'desc'=>__('The "%" will be replaced with the date , for example "September 10, 2013"','theme-textdomain' ),
		'std' => 'Daily archives: %',
		'type' => 'text'
	);	
	$options[] = array(
		'name' => __( 'Monthly Archives Page Title', 'theme-textdomain' ),
		'id' => 'monthly_archive_page_title',
		'desc'=>__('The "%" will be replaced with the year and month name , for example "September 2013"','theme-textdomain' ),
		'std' => 'Monthly archives: %',
		'type' => 'text'
	);	
	$options[] = array(
		'name' => __( 'Yearly Archives Page Title', 'theme-textdomain' ),
		'id' => 'yearly_archive_page_title',
		'desc'=>__('The "%" will be replaced with the year, for example "2013"','theme-textdomain' ),
		'std' => 'Yearly archives: %',
		'type' => 'text'
	);
	$options[] = array(
		'name' => __( 'Post Format Archives Page Title', 'theme-textdomain' ),
		'id' => 'post_format_archive_page_title',
		'desc'=>__('The "%" will be replaced with the post format name, for example "audio"','theme-textdomain' ),
		'std' => 'Post format archives: %',
		'type' => 'text'
	);


	$options[] = array(
		'name' => __( 'Gallery Page Title', 'theme-textdomain' ),
		'id' => 'gallery_page_title',
		'std' => 'Galleries',
		'type' => 'text'
	);
	$options[] = array(
		'name' => __( 'Other Custom Posts Type Archive Page Title', 'theme-textdomain' ),
		'id' => 'other_custom_post_type_archive_page_title',
		'desc'=>__('The "%" will be replaced with the custom post type name, for example "testimonial" if you are using a plugin that adds custom post type "testimonial"','theme-textdomain' ),
		'std' => '% archive',
		'type' => 'text'
	);	
	$options[] = array(
		'name' => __( 'Other Archives Page Title', 'theme-textdomain' ),
		'id' => 'other_archives_page_title',
		'desc'=>__('This is the generat tile for the pages that were not covered in the above settings','theme-textdomain' ),
		'std' => 'Blog archives',
		'type' => 'text'
	);	
	$options[] = array(
		'name' => __( 'No Posts Found Message', 'theme-textdomain' ),
		'id' => 'no_post_found_message',
		'desc'=>__('This message will appear for example when you are looking at a category or an author page that has no posts.','theme-textdomain' ),
		'std' => 'Sorry, no posts were found.',
		'type' => 'text'
	);
 	$options[] = array(
		'name' => __( 'Share Post Label', 'theme-textdomain' ),
		'id' => 'share_post_label',
		'std' => 'SHARE POST',
		'type' => 'text'
	);
	$options[] = array(
		'name' => __( 'Share Gallery Label', 'theme-textdomain' ),
		'id' => 'share_gallery_label',
		'std' => 'SHARE GALLERY',
		'type' => 'text'
	);
	$options[] = array(
		'name' => __( 'Back To Galleries Label', 'theme-textdomain' ),
		'id' => 'back_to_galleries_label',
		'std' => 'BACK TO GALLERIES',
		'type' => 'text'
	);

  	return $options;
  }
}