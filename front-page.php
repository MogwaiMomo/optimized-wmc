<?php
/**
 * Controls the homepage output.
 */

add_action( 'wp_enqueue_scripts', 'mpp_enqueue_scripts' );
/**
 * Enqueue Scripts
 */
function mpp_enqueue_scripts() {

	if ( is_active_sidebar( 'home-control-about' ) || is_active_sidebar( 'home-portfolio' ) || is_active_sidebar( 'home-services' ) || is_active_sidebar( 'home-blog' )  ||

		// add treatment page widget areas
		is_active_sidebar( 'home-about' ) || is_active_sidebar( 'home-main-testi' ) || is_active_sidebar( 'home-benefits' ) || is_active_sidebar( 'home-derick' ) || is_active_sidebar( 'home-final-cta' )  ) {
		wp_enqueue_script( 'scrollTo', get_stylesheet_directory_uri() . '/js/jquery.scrollTo.min.js', array( 'jquery' ), '1.4.5-beta', true );
		wp_enqueue_script( 'localScroll', get_stylesheet_directory_uri() . '/js/jquery.localScroll.min.js', array( 'scrollTo' ), '1.2.8b', true );
		wp_enqueue_script( 'scroll', get_stylesheet_directory_uri() . '/js/scroll.js', array( 'localScroll' ), '', true );
	}
}

add_action( 'genesis_meta', 'mpp_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function mpp_home_genesis_meta() {

	if (is_active_sidebar( 'home-control-about' ) || is_active_sidebar( 'home-portfolio' ) || is_active_sidebar( 'home-services' ) || is_active_sidebar( 'home-blog' )  ||

		// add treatment page widget areas
		is_active_sidebar( 'home-about' ) || is_active_sidebar( 'home-main-testi' ) || is_active_sidebar( 'home-benefits' ) || is_active_sidebar( 'home-derick' ) || is_active_sidebar( 'home-final-cta' ) ) {

		// Force content-sidebar layout setting
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

		// Add mpp-home body class
		add_filter( 'body_class', 'mpp_body_class' );

		// Remove the navigation menus
		remove_action( 'genesis_after_header', 'genesis_do_nav' );
		remove_action( 'genesis_after_header', 'genesis_do_subnav' );

		// Remove the default Genesis loop
		remove_action( 'genesis_loop', 'genesis_do_loop' );

		// Add homepage widgets
		add_action( 'genesis_loop', 'mpp_homepage_widgets' );

		// Remove Footer
		 remove_action('genesis_footer', 'genesis_do_footer');
		 remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
		 remove_action('genesis_footer', 'genesis_footer_markup_close', 15);
	}

}

function mpp_body_class( $classes ) {

	$classes[] = 'mpp-home';
	return $classes;
	
}

function mpp_homepage_widgets() {

	genesis_widget_area( 'home-about', array(
		'before' => '<div id="about"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-main-testi', array(
		'before' => '<div id="main-testi"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-benefits', array(
		'before' => '<div id="benefits"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-skills', array(
		'before' => '<div id="skills"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-derick', array(
		'before' => '<div id="derick"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-final-cta', array(
		'before' => '<div id="final-cta"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	// OLD WIDGETS: 

	// genesis_widget_area( 'home-control-about', array(
	// 	'before' => '<div id="control-about"><div class="wrap">',
	// 	'after'  => '</div></div>',
	// ) );

	// genesis_widget_area( 'home-portfolio', array(
	// 	'before' => '<div id="portfolio"><div class="wrap">',
	// 	'after'  => '</div></div>',
	// ) );

	// genesis_widget_area( 'home-services', array(
	// 	'before' => '<div id="services"><div class="wrap">',
	// 	'after'  => '</div></div>',
	// ) );

	// genesis_widget_area( 'home-blog', array(
	// 	'before' => '<div id="blog"><div class="wrap">',
	// 	'after'  => '</div></div>',
	// ) );

}

genesis();
