<?php
/*
 * Plugin Name: Inline Comments
 * Plugin URI: http://kevinw.de/inline-comments
 * Description: Inline Comments adds your comment system to the side of paragraphs, headlines and other sections (like headlines and images) of your post. It performs native with WordPress comments.
 * Author: Kevin Weber
 * Version: 1.0.1
 * Author URI: http://kevinw.de/
 * License: MIT
 * Text Domain: inline-comments
*/

define( 'INCOM_VERSION', '1.0.1' );
define( 'INCOM_VERSION_NAME', 'Essential' );
define( 'INCOM_NEWS_TEXT', 'To suggest and vote for new features: Let the developer come into contact with you.' );
define( 'INCOM_NEWS_BUTTON', 'Get contacted' );
define( 'INCOM_ESSENTIAL', true );	// Should be false if this is the 'Lifetime' version
define( 'INCOM_LIFETIME', false );	// Should be false if this is the 'Essential' version

if ( ! defined( 'INCOM_FILE' ) ) {
	define( 'INCOM_FILE', __FILE__ );
}

if ( !defined( 'INCOM_PATH' ) )
	define( 'INCOM_PATH', plugin_dir_path( __FILE__ ) );

require_once( INCOM_PATH . 'admin/class-register.php' );


function incom_admin_init() {
	// require_once( INCOM_PATH . 'admin/class-admin.php' );
	require_once( INCOM_PATH . 'admin/class-admin-options.php' );
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

/***** Plugin by Kevin Weber || kevinw.de *****/