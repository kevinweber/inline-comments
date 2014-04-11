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

if ( !defined( 'INCOM_PATH' ) )
	define( 'INCOM_PATH', plugin_dir_path( __FILE__ ) );

function incom_admin_init() {
	require_once( INCOM_PATH . 'admin/class-admin.php' );
}

function incom_frontend_init() {
	require_once( INCOM_PATH . 'frontend/class-frontend.php' );
}

if ( is_admin() ) {
	add_action( 'plugins_loaded', 'incom_admin_init', 15 );
}
else {
	add_action( 'plugins_loaded', 'incom_frontend_init', 15 );
}

/***** Plugin by Kevin Weber || kevinw.de *****/
?>