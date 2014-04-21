<?php
/*
 * Plugin Name: Inline Comments
 * Plugin URI: http://kevinw.de/inline-comments.php
 * Description: Inline Comments adds the great Disqus Comment System to the side of paragraphs and other specific sections (like headlines and images) of your post. The comment area is shown when you click the comment count bubbles (left or right) beside any section.
 * Author: Kevin Weber
 * Version: 0.8
 * Author URI: http://kevinw.de/
 * License: MIT
 * Text Domain: inline-comments
*/

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

	if ( get_option("select_comment_type") === "wp" ) {
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