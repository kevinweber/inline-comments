<?php
/**
 * Functions that are used independent from the options panel
 * @package Admin
 */

class INCOM_Admin {

	function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}

	function admin_init() {
	}

}

function initialize_incom_admin() {
	$incom_admin = new INCOM_Admin();
}
add_action( 'init', 'initialize_incom_admin' );
?>