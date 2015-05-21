<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'mpp', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'mpp' ) );


//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Modern Portfolio Pro', 'mpp' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/modern-portfolio/' );
define( 'CHILD_THEME_VERSION', '2.0.0' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Lato Google fonts
add_action( 'wp_enqueue_scripts', 'mpp_google_fonts' );
function mpp_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700,900,400italic,700italic', array(), CHILD_THEME_VERSION );
	
}


//* Enqueue Responsive Menu Script
add_action( 'wp_enqueue_scripts', 'mpp_enqueue_responsive_script' );
function mpp_enqueue_responsive_script() {

	wp_enqueue_script( 'mpp-responsive-menu', get_bloginfo( 'stylesheet_directory' ) . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0' );

}



//* Add new image sizes
add_image_size( 'blog', 340, 140, TRUE );
add_image_size( 'portfolio', 340, 230, TRUE );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header_image'    => '',
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 180,
	'width'           => 600,
) );

//* Add support for additional color style options
add_theme_support( 'genesis-style-selector', array(
	'modern-portfolio-pro-blue'   => __( 'Modern Portfolio Pro Blue', 'mpp' ),
	'modern-portfolio-pro-orange' => __( 'Modern Portfolio Pro Orange', 'mpp' ),
	'modern-portfolio-pro-red'    => __( 'Modern Portfolio Pro Red', 'mpp' ),
	'modern-portfolio-pro-purple' => __( 'Modern Portfolio Pro Purple', 'mpp' ),
) );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

//* Add metabox for site initial option
add_action( 'genesis_theme_settings_metaboxes', 'mpp_theme_settings_metaboxes', 10, 1 );
function mpp_theme_settings_metaboxes( $pagehook ) {

    add_meta_box( 'mpp-custom-initial', __( 'Modern Portfolio - Site initial', 'mpp' ), 'mpp_custom_initial_metabox', $pagehook, 'main', 'high' );

}

//* Content for the site initial metabox
function mpp_custom_initial_metabox() {

    $val = ( $opt = genesis_get_option( 'mpp_custom_initial' ) ) ? $opt[0] : '';

    printf( '<p><label for="%s[%s]" />' . __( 'Enter custom site initial:', 'mpp') . '<br />', GENESIS_SETTINGS_FIELD, 'mpp_custom_initial' );
    printf( '<input type="text" name="%1$s[%2$s]" id="%1$s[%1$s]" size="6" value="%3$s" /></p>', GENESIS_SETTINGS_FIELD, 'mpp_custom_initial', $val );
    printf( '<p><span class="description">' . __( 'This will be displayed beside the site title and is limited to 1 character', 'mpp') . '</span></p>' );

}

//* Add custom site initial CSS
add_action( 'wp_enqueue_scripts', 'modern_portfolio_set_icon' );
function modern_portfolio_set_icon() {

    $handle  = defined( 'CHILD_THEME_NAME' ) && CHILD_THEME_NAME ? sanitize_title_with_dashes( CHILD_THEME_NAME ) : 'child-theme';

    $icon = genesis_get_option( 'mpp_custom_initial' );

    if( empty( $icon ) || get_header_image() )
        return;

    $css = sprintf( '.site-title a::before{ content: \'%s\'; }', $icon[0] );

    wp_add_inline_style( $handle, $css );

}

//* Hook after post widget after the entry content
add_action( 'genesis_after_entry', 'mpp_after_entry', 5 );
function mpp_after_entry() {

	if ( is_singular( 'post' ) )
		genesis_widget_area( 'after-entry', array(
			'before' => '<div class="after-entry widget-area">',
			'after'  => '</div>',
		) );

}

//* Modify the size of the Gravatar in author box
add_filter( 'genesis_author_box_gravatar_size', 'mpp_author_box_gravatar_size' );
function mpp_author_box_gravatar_size( $size ) {

	return 80;
	
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'mpp_remove_comment_form_allowed_tags' );
function mpp_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Register widget areas

	//* MP: Widgets for Screencasts Page

	genesis_register_sidebar( array(
		'id' => 'category-search',
		'name' => __( 'Search Widget', 'mpp' ),
		'description' =>  __( 'Display Search Before Episodes Loop', 'mpp' ),
	) );



	// MP: Widgets for Pricing Page
	genesis_register_sidebar( array(
		'id'          => 'pricing-subscriptions',
		'name'        => __( 'Pricing - Subscriptions','mpp' ),
		'description' => __( 'This is the Subscription section of the pricing page.','mpp' ),
	) );


	genesis_register_sidebar( array(
		'id'          => 'pricing-bundles',
		'name'        => __( 'Pricing - Bundles','mpp' ),
		'description' => __( 'This is the Bundles section of the pricing page.','mpp' ),
	) );

	genesis_register_sidebar( array(
		'id'          => 'pricing-guarantee',
		'name'        => __( 'Pricing - Guarantee','mpp' ),
		'description' => __( 'This is the Guarantee section of the pricing page.','mpp' ),
	) );






	// MP: Widgets for New Homepage
	genesis_register_sidebar( array(
		'id'          => 'home-about',
		'name'        => __( 'Home - About','mpp' ),
		'description' => __( 'This is the about section of the homepage.','mpp' ),
	) );

	genesis_register_sidebar( array(
		'id'          => 'home-main-testi',
		'name'        => __( 'Home - Main-Testimonial','mpp' ),
		'description' => __( 'This is a centered, full-width testimonial on the homepage.','mpp' ),
	) );

	genesis_register_sidebar( array(
		'id'          => 'home-benefits',
		'name'        => __( 'Home - Benefits','mpp' ),
		'description' => __( 'This is the benefits section of the homepage.','mpp' ),
	) );

	genesis_register_sidebar( array(
		'id'          => 'home-skills',
		'name'        => __( 'Home - Skills','mpp' ),
		'description' => __( 'This is the Skills section of the homepage.','mpp' ),
	) );

	genesis_register_sidebar( array(
		'id'          => 'home-derick',
		'name'        => __( 'Home - Derick','mpp' ),
		'description' => __( 'This is the About Derick Bailey section of the homepage.','mpp' ),
	) );

	genesis_register_sidebar( array(
		'id'          => 'home-final-cta',
		'name'        => __( 'Home - Final Call to Action','mpp' ),
		'description' => __( 'This is the Final CTA section of the homepage.','mpp' ),
	) );



// MP: Widgets for Control Homepage

// genesis_register_sidebar( array(
// 	'id'          => 'home-control-about',
// 	'name'        => __( 'Home A - About','mpp' ),
// 	'description' => __( 'This is the about section of the homepage.','mpp' ),
// ) );

// genesis_register_sidebar( array(
// 	'id'          => 'home-portfolio',
// 	'name'        => __( 'Home A - Portfolio','mpp' ),
// 	'description' => __( 'This is the portfolio section of the homepage.','mpp' ),
// ) );
// genesis_register_sidebar( array(
// 	'id'          => 'home-services',
// 	'name'        => __( 'Home A - Services','mpp' ),
// 	'description' => __( 'This is the Services section of the homepage.','mpp' ),
// ) );
// genesis_register_sidebar( array(
// 	'id'          => 'home-blog',
// 	'name'        => __( 'Home A - Blog','mpp' ),
// 	'description' => __( 'This is the Blog section of the homepage.','mpp' ),
// ) );

// genesis_register_sidebar( array(
// 	'id'          => 'after-entry',
// 	'name'        => __( 'After Entry', 'mpp' ),
// 	'description' => __( 'This is the after entry widget area.', 'mpp' ),
// ) );


// On Homepage: [signup_button text="foo bar"]
function signup_button_fn( $atts ) {
  extract( shortcode_atts( array(

  	// MP: changed text attr for optimized version:
    'text' => '￼Get FULL Access to <br>75+ Game-Changing Screencasts',
    'url' => get_bloginfo('url') . '/pricing-plans/',
    'icon' => ""
  ), $atts ) );

  $iconImage = "";
  if ($icon != "") { 
    $iconImage = "<i class='fa fa-lg fa-${icon}'>&nbsp;</i>"; 
  }

  return "<a class='button' href='${url}'>${iconImage}{$text}</a>"; 
}
add_shortcode( 'signup_button', 'signup_button_fn' );



// On Pricing Page: [link-to-indie-signup-form text="foo bar"]
function link_to_indie_signup_form_fn( $atts ) {
  extract( shortcode_atts( array(

    'text' => 'Start Conquering Javascript',
    'url' => get_bloginfo('url') . '/indie-signup/',
  ), $atts ) );


  return "<a class='button' href='${url}'>${text}</a>"; 
}
add_shortcode( 'link_to_indie_signup_form', 'link_to_indie_signup_form_fn' );

// On Pricing Page: [link-to-team-signup-form text="foo bar"]
function link_to_team_signup_form_fn( $atts ) {
  extract( shortcode_atts( array(

    'text' => 'Start Conquering Javascript',
    'url' => get_bloginfo('url') . '/teams/',
  ), $atts ) );


  return "<a class='button' href='${url}'>${text}</a>"; 
}
add_shortcode( 'link_to_team_signup_form', 'link_to_team_signup_form_fn' );





// On Pricing Page: [link-to-screencasts text="foo bar"]
function link_to_catalog_fn( $atts ) {
  extract( shortcode_atts( array(

    'text' => 'Explore the full screencast catalog',
    'url' => get_bloginfo('url') . '/categories/episodes/',
  ), $atts ) );


  return "<a href='${url}'><p>${text}</p></a>"; 
}
add_shortcode( 'link_to_catalog', 'link_to_catalog_fn' );





add_filter('rcp_registration_choose_subscription', 'rcp_choose_sub_level_title');
function rcp_choose_sub_level_title(){
  return "Your subscription level";
}

function show_categories_fn(){
  return wp_list_categories("echo=0&title_li");
}
add_shortcode('show_categories', 'show_categories_fn');

// override the default password reset message, to correct for html encoded weirdness in link
add_action('retrieve_password_message', 'some_email_thing', 10, 4);
function some_email_thing($message, $key, $user_login, $user_data){
	$message = __('A password reset request was sent for the following account:') . "\r\n\r\n";
	$message .= network_home_url( '/' ) . "\r\n\r\n";
	$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
	$message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
	$message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
	$message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "\r\n";
	return $message;
}

/* SECURE RSS */
//function my_check_feed_auth() {
//    if (!isset($_SERVER['PHP_AUTH_USER'])) {
//        header('WWW-Authenticate: Basic realm="RSS Feeds"');
//        header('HTTP/1.0 401 Unauthorized');
//        echo 'Feeds from this site are private';
//        exit;
//    } else {
//        if (is_wp_error(wp_authenticate($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']))) {
//            header('WWW-Authenticate: Basic realm="RSS Feeds"');
//            header('HTTP/1.0 401 Unauthorized');
//            echo 'Username and password were not correct';
//            exit;
//        }
//    }
//}
//
//add_action('do_feed_rss2', 'my_check_feed_auth', 1);
//add_action('do_feed_atom', 'my_check_feed_auth', 1);
//add_action('do_feed_rss', 'my_check_feed_auth', 1);
//add_action('do_feed_rdf', 'my_check_feed_auth', 1);

add_filter( 'get_the_content_more_link', 'sp_read_more_link' );
function sp_read_more_link() {
	return '... <a class="more-link" href="' . get_permalink() . '">[Continue Reading]</a>';
}


function ntg_get_custom_field( $field, $wrap = '%value%', $echo = false ){
 
    $custom_wrap = false;
 
    if( $value = genesis_get_custom_field( $field ) )
        $custom_wrap = str_replace( '%value%', $value, $wrap );
 
        if( $echo && $custom_wrap )
            echo $custom_wrap;
 
        return $custom_wrap;
 
}


add_shortcode( 'episode_length', 'episode_length_fn' );
function episode_length_fn() { 
    $length = get_field('episode_length'); 
    if ($length != ''){ 
        return '<span class="entry-time">Episode length: '. get_field('episode_length') . '</span>'; 
    }
} 

add_action( 'genesis_entry_footer', 'genesis_prev_next_post_nav' );





// Customize search functionality to include categories and tags:  
// Source of code: http://www.rfmeier.net/include-category-and-post-tag-names-in-the-wordpress-search/

function custom_posts_join( $join, $query )
{
    global $wpdb;

    //* if main query and search...
    if( is_main_query() && is_search() )
    {
        //* join term_relationships, term_taxonomy, and terms into the current SQL where clause
        $join .= "
        LEFT JOIN 
        ( 
            {$wpdb->term_relationships}
            INNER JOIN 
                {$wpdb->term_taxonomy} ON {$wpdb->term_taxonomy}.term_taxonomy_id = {$wpdb->term_relationships}.term_taxonomy_id 
            INNER JOIN 
                {$wpdb->terms} ON {$wpdb->terms}.term_id = {$wpdb->term_taxonomy}.term_id 
        ) 
        ON {$wpdb->posts}.ID = {$wpdb->term_relationships}.object_id ";
    }

    return $join;
}
add_filter( 'posts_join', 'custom_posts_join', 10, 2 );





function custom_posts_where( $where, $query )
{
    global $wpdb;

    if( is_main_query() && is_search() )
    {
        //* get additional where clause for the user
        $user_where = get_user_posts_where();
        
        $where .= " OR (
                        {$wpdb->term_taxonomy}.taxonomy IN( 'category', 'post_tag' ) 
                        AND
                        {$wpdb->terms}.name LIKE '%" . esc_sql( get_query_var( 's' ) ) . "%'
                        {$user_where}
                    )";
    }

    return $where;
}
add_filter( 'posts_where', 'custom_posts_where', 10, 2 );

/**
 * Get a where clause dependent on the current user's status.
 *
 * @uses get_current_user_id()
 * @link http://codex.wordpress.org/Function_Reference/get_current_user_id
 * 
 * @return string The user where clause.
 */
function get_user_posts_where()
{
    global $wpdb;

    $user_id = get_current_user_id();
    $sql     = '';
    $status  = array( "'publish'" );

    if( 0 !== $user_id )
    {
        $status[] = "'private'";
        
        $sql .= " AND {$wpdb->posts}.post_author = " . absint( $user_id );
    }

    $sql .= " AND {$wpdb->posts}.post_status IN( " . implode( ',', $status ) . " ) ";
    
    return $sql;
}





function custom_posts_groupby( $groupby, $query )
{
    global $wpdb;

    //* if is main query and a search...
    if( is_main_query() && is_search() )
    {
        //* assign the GROUPBY
        $groupby = "{$wpdb->posts}.ID";
    }

    return $groupby;
}
add_filter( 'posts_groupby', 'custom_posts_groupby', 10, 2 );



// Remove pages from Search function:
// source: http://www.wpbeginner.com/wp-tutorials/how-to-exclude-pages-from-wordpress-search-results/

function SearchFilter($query) {
	if ($query->is_search) {
	$query->set('post_type', 'post');
	}
	return $query;
}

add_filter('pre_get_posts','SearchFilter');


//* Customize search form input box text
add_filter( 'genesis_search_text', 'sp_search_text' );
function sp_search_text( $text ) {
	return esc_attr( 'Type your JavaScript topic here ...' );
}


//* Customize search form input button text
add_filter( 'genesis_search_button_text', 'sp_search_button_text' );
function sp_search_button_text( $text ) {
	return esc_attr( 'Search Episodes' );
}


