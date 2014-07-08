<?php
/*
 * Plugin Name: Inline Comments
 * Plugin URI: http://kevinw.de/inline-comments
 * Description: Inline Comments adds your comment system to the side of paragraphs and other sections (like headlines and images) of your post. It performs native with WordPress comments.
 * Author: Kevin Weber
 * Version: 1.0.6
 * Author URI: http://kevinw.de/
 * License: GPL v3
 * Text Domain: inline-comments
*/

if ( !defined( 'INCOM_VERSION' ) ) {
	define( 'INCOM_VERSION', '1.0.6' );
}

if ( !defined( 'INCOM_VERSION_NAME' ) ) {
	define( 'INCOM_VERSION_NAME', 'Essential' );
}

if ( !defined( 'INCOM_ESSENTIAL' ) ) {
	define( 'INCOM_ESSENTIAL', true );	// Should be false if this is the 'Lifetime' version
}

if ( !defined( 'INCOM_FILE' ) ) {
	define( 'INCOM_FILE', __FILE__ );
}

if ( !defined( 'INCOM_PATH' ) )
	define( 'INCOM_PATH', plugin_dir_path( __FILE__ ) );

define( 'INCOM_NEWS_TEXT', 'To suggest and vote for new features: Let the developer come into contact with you.' );
define( 'INCOM_NEWS_BUTTON', 'Get contacted' );

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


	/**
	 * My Ajax function
	 */
	function incom_do_ajax_wp() {
		/* this area is very simple but being serverside it affords the possibility of retreiving data from the server and passing it back to the javascript function */
		$name = get_option("multiselector");
		echo "$name";// this is passed back to the javascript function
		die();// wordpress may print out a spurious zero without this – can be particularly bad if using json
	}

		//AJAX
		add_action("wp_ajax_nopriv_incom_do_ajax_wp", 'incom_do_ajax_wp' );
		//AJAX
		add_action("wp_ajax_incom_do_ajax_wp", 'incom_do_ajax_wp' );
		// The 'template_redirect' tells WP to run this function before loading the template file and ensures the admin-ajax.php file and .js will be properly added to the ‹head› portion of your site.



/***** Plugin by Kevin Weber || kevinw.de *****/