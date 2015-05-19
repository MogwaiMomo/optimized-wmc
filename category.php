<?php
/**
* Template Name: Category Template
* Description: Optimized Search/Browse page for Categories/Episodes. 
*/


add_action( 'wp_enqueue_scripts', 'mpp_enqueue_scripts' );


function mpp_enqueue_scripts() {

		wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/js/jquery.scrollTo.min.js', array( 'jquery' ), '1.4.5-beta', true );
		wp_enqueue_script( 'localScroll', get_stylesheet_directory_uri() . '/js/jquery.localScroll.min.js', array( 'scrollTo' ), '1.2.8b', true );
		wp_enqueue_script( 'scroll', get_stylesheet_directory_uri() . '/js/scroll.js', array( 'localScroll' ), '', true );
}



function mpp_body_class( $classes ) {

	$classes[] = 'mpp-category';
	return $classes;
	
}


function search_widget() {
	if ( is_page_template( 'category.php' ) && is_active_sidebar( 'category-search' ) ) 
	    genesis_widget_area( 'category-search', array(
	    'before' => '<div id="category-search"><div class="wrap">',
		'after'  => '</div></div>',
	) );
}





//* Remove the entry meta in the entry header
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

//* Remove the entry image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

//* Add search widget
add_action( 'genesis_before_content', 'search_widget', 5 );

//* Add Image, Post Info, Title, Excerpt & Entry Footer Entry Meta
// add_action( 'genesis_entry_header', 'genesis_do_post_image', 2 );


//* Add Header Markup & Post Info 
add_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5);
add_action( 'genesis_entry_header', 'genesis_post_info', 8  );
add_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );





//* Run the Genesis loop
genesis();

