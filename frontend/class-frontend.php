<?php
/**
 * @package Frontend
 */
class INCOM_Frontend {

	function __construct() {
		add_filter( 'body_class' , array( $this, 'body_class' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_jquery' ) );
        require_once( INCOM_PATH . 'frontend/class-wp.php' );
        new INCOM_WordPress();
        require_once( INCOM_PATH . 'frontend/class-comments.php' );
        new INCOM_Comments();
	}

	/**
	 * Add class to <body> that identifies the usage of this plugin
	 * @since 2.1
	 */
	function body_class( $classes ) {
		$classes[] = 'inline-comments';
		return $classes;
	}

	/**
 	 * Enable jQuery (comes with WordPress)
 	 */
 	function enqueue_jquery() {
     	wp_enqueue_script( 'jquery' );
 	}

	/**
	 * Handle avatar size
	 */
	protected function get_avatar_size() {
		if ( get_option( 'incom_avatars_display' ) != 1 )
			return '0';

		$input = get_option( 'incom_avatars_size' );
		if ( (int) $input > 0 ) {
			return $input;
		}
		else {
			return '15';
		}
	}
}

function initialize_incom_frontend() {
  new INCOM_Frontend();
}
add_action( 'init', 'initialize_incom_frontend' );
