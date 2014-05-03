<?php
/*
 * Plugin Name: Inline Comments
 * Plugin URI: http://kevinw.de/inline-comments
 * Description: Inline Comments adds the great Disqus Comment System to the side of paragraphs and other specific sections (like headlines and images) of your post. The comment area is shown when you click the comment count bubbles (left or right) beside any section.
 * Author: Kevin Weber
 * Version: 1.0
 * Author URI: http://kevinw.de/
 * License: MIT
 * Text Domain: inline-comments
*/

/*
 * These files are not included in 'Disqus-only version':
 * frontend/class-wp.php
 * frontend/class-comments.php
 * js/inline-comments.js (and its minified version)
 */

define( 'INCOM_VERSION', '1.0' );
define( 'INCOM_DISQUS', false );	// Should be false if this is NOT the 'Disqus-only version'
define( 'INCOM_ESSENTIAL', true );	// Should be false if this is the 'Disqus-only version' or 'Lifetime'
define( 'INCOM_LIFETIME', false );	// Should be false if this is the 'Disqus-only version' or 'Essential'

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

	if ( ( !INCOM_DISQUS ) && ( get_option("select_comment_type") === "wp" ) ) {
		// Premium feature
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