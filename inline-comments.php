<?php
/*
 * Plugin Name: Inline Comments
 * Plugin URI: http://kevinw.de/inline-comments/
 * Description: Inline Comments adds your comment system to the side of paragraphs and other sections (like headlines and images) of your post. It performs native with WordPress comments.
 * Author: Kevin Weber
 * Version: 2.0.1
 * Author URI: http://kevinw.de/
 * License: GPL v3
 * Text Domain: inline-comments
 * Domain Path: /languages
*/

if ( !defined( 'INCOM_VERSION' ) ) {
	define( 'INCOM_VERSION', '2.0.1' );
}

if ( !defined( 'INCOM_VERSION_NAME' ) ) {
	define( 'INCOM_VERSION_NAME', 'Essential' );
}

if ( !defined( 'INCOM_ESSENTIAL' ) ) {
	define( 'INCOM_ESSENTIAL', true );	// Should be false if this is the 'Lifetime' version
}

if ( !defined( 'INCOM_OPTION_KEY' ) ) {
	define( 'INCOM_OPTION_KEY', 'incom' ); // used to save options in version >= 0.9.0
}

if ( !defined( 'INCOM_TD' ) ) {
	define( 'INCOM_TD', 'inline-comments' ); // = text domain (used for translations)
}

if ( !defined( 'INCOM_FILE' ) ) {
	define( 'INCOM_FILE', __FILE__ );
}

if ( !defined( 'INCOM_PATH' ) )
	define( 'INCOM_PATH', plugin_dir_path( INCOM_FILE ) );



/**
 * Load plugin textdomain.
 * @since 2.0
 */
function incom_load_textdomain() {
  load_plugin_textdomain( 'inline-comments', false, dirname( plugin_basename( INCOM_FILE ) ) . '/languages/' ); 
}
add_action( 'plugins_loaded', INCOM_OPTION_KEY.'_load_textdomain' );


define( 'INCOM_NEWS_TEXT', 'To suggest and vote for new features: Let the developer come into contact with you.' );
define( 'INCOM_NEWS_BUTTON', 'Get contacted' );

require_once( INCOM_PATH . 'admin/class-register.php' );

function incom_admin_init() {
	// require_once( INCOM_PATH . 'admin/class-admin.php' );
	require_once( INCOM_PATH . 'admin/class-admin-options.php' );

	if ( INCOM_ESSENTIAL ) {
		require_once( INCOM_PATH . 'admin/inc/class-no-premium.php'); 
	}
}

function incom_frontend_init() {
	require_once( INCOM_PATH . 'frontend/class-frontend.php' );

	if ( get_option("select_comment_type") !== "disqus" ) {
		require_once( INCOM_PATH . 'frontend/class-wp.php' );
	}
	else {
		require_once( INCOM_PATH . 'frontend/class-indisq.php' );
	}
}

if ( is_admin() ) {
	add_action( 'plugins_loaded', 'incom_admin_init', 15 );
}
else {
	add_action( 'plugins_loaded', 'incom_frontend_init', 15 );
}

// Feature: Support for WP-Ajaxify-Comments
if ( (get_option( INCOM_OPTION_KEY.'_support_for_ajaxify_comments' ) == true) && !is_admin() ) {
	require_once( INCOM_PATH . 'frontend/inc/class-wpac.php'); 
}


/***** Plugin by Kevin Weber || kevinw.de *****/