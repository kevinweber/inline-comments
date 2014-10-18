<?php
/**
 * @package Frontend
 */
class INCOM_Frontend {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_jquery' ) );
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
	$incom_frontend = new INCOM_Frontend();
}
add_action( 'init', 'initialize_incom_frontend' );