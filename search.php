<?php
/**
* Template Name: Search Results Template
* Description: Optimized Search/Browse page for Categories/Episodes. 
*/


function genesis_do_search_title() {

	$title = sprintf( '<div class="archive-description"><h1 class="archive-title">%s %s</h1></div>', apply_filters( 'genesis_search_title_text', __( 'Search results for: ', 'genesis' ) ), get_search_query() );

	echo apply_filters( 'genesis_search_title_output', $title ) . "\n";

}


/**
 * Add widget support for Search results. If no widgets active, display the default loop.
 *
 */

add_action( 'genesis_meta', 'mpp_search_results_genesis_meta' );

function mpp_search_results_genesis_meta() {

	if ( is_active_sidebar( 'category-search' ) ) {

		// Force content-sidebar layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		// Add mpp-screencasts body class
		add_filter( 'body_class', 'mpp_body_class' );

		//* Remove the entry meta in the entry header
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
		remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
		remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

		//* Remove the entry image
		remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

		// Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// * Add search widget
		add_action( 'genesis_before_content', 'mpp_search_widget', 5 );
		add_action( 'genesis_before_loop', 'genesis_do_search_title' );

		//* Add the default Genesis loop
		add_action( 'genesis_loop', 'genesis_do_loop' );

		//* Add Header Markup & Post Info 
		add_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5);
		add_action( 'genesis_entry_header', 'genesis_post_info', 8  );
		add_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

	}

}




function mpp_body_class( $classes ) {

	$classes[] = 'mpp-search-results';
	return $classes;
	
}


function mpp_search_widget() {

	genesis_widget_area( 'category-search', array(
	'before' => '<div id="category-search"><div class="wrap">',
	'after'  => '</div></div>',
) );

}




//* Run the Genesis loop
genesis();


