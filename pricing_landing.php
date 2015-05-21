<?php

/**
* Template Name: Pricing Page Template
* Description: Used as a page template to show subscription plans, followed by a loop 
* through the "Bundles" category
*/


add_action( 'wp_enqueue_scripts', 'mpp_enqueue_scripts' );
/**
 * Enqueue Scripts
 */
function mpp_enqueue_scripts() {

	if ( is_active_sidebar( 'pricing-subscriptions' ) || is_active_sidebar( 'pricing-bundles' ) || is_active_sidebar( 'pricing-guarantee' ) ) {
		wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/js/jquery.scrollTo.min.js', array( 'jquery' ), '1.4.5-beta', true );
		wp_enqueue_script( 'localScroll', get_stylesheet_directory_uri() . '/js/jquery.localScroll.min.js', array( 'scrollTo' ), '1.2.8b', true );
		wp_enqueue_script( 'scroll', get_stylesheet_directory_uri() . '/js/scroll.js', array( 'localScroll' ), '', true );
	}
}

add_action( 'genesis_meta', 'mpp_pricing_genesis_meta' );
/**
 * Add widget support for pricing page. If no widgets active, display the default loop.
 *
 */
function mpp_pricing_genesis_meta() {

	if ( is_active_sidebar( 'pricing-subscriptions' ) || is_active_sidebar( 'pricing-bundles' ) || is_active_sidebar( 'pricing-guarantee' ) ) {

		// Force content-sidebar layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		// Add mpp-pricing body class
		add_filter( 'body_class', 'mpp_body_class' );

		// Remove the navigation menus
		remove_action( 'genesis_after_header', 'genesis_do_nav' );
		remove_action( 'genesis_after_header', 'genesis_do_subnav' );

		// Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add pricing page widgets
		add_action( 'genesis_loop', 'mpp_pricing_widgets' );

	

		// Remove Footer
		 remove_action('genesis_footer', 'genesis_do_footer');
		 remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
		 remove_action('genesis_footer', 'genesis_footer_markup_close', 15);
	}

}

function mpp_body_class( $classes ) {

	$classes[] = 'mpp-pricing';
	return $classes;
	
}


function mpp_pricing_widgets() {

	genesis_widget_area( 'pricing-subscriptions', array(
		'before' => '<div id="subscriptions"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'pricing-bundles', array(
		'before' => '<div id="bundles"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'pricing-guarantee', array(
		'before' => '<div id="guarantee"><div class="wrap">',
		'after'  => '</div></div>',
	) );


}

genesis();