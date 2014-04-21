<?php
/**
 * register_activation_hook() and register_deactivation_hook() MUST NOT be called with action 'plugins_loaded' or any 'admin_init'
 * @package Admin
 */

register_activation_hook( INCOM_FILE, 'incom_plugin_activation' );
register_deactivation_hook( INCOM_FILE, 'incom_plugin_deactivation' );

function incom_plugin_activation() {
	$notices = get_option( 'incom_deferred_admin_notices', array() );
	$notices[] = 'Edit your plugin settings: <strong><a href="options-general.php?page=incom.php">Inline Comments</a></strong>';
	update_option( 'incom_deferred_admin_notices', $notices );
}

function incom_plugin_deactivation() {
	delete_option( 'incom_deferred_admin_notices' ); 
}


class INCOM_Register {

	function __construct() {
		add_action( 'admin_notices', array( $this, 'incom_plugin_notice_activation' ) );
	}

	/**
	 * Display notification when plugin is activated
	 */
	function incom_plugin_notice_activation() {
	  if ( $notices = get_option( 'incom_deferred_admin_notices' ) ) {
	    foreach ($notices as $notice) {
	      echo "<div class='updated'><p>$notice</p></div>";
	    }
	    delete_option( 'incom_deferred_admin_notices' );
	  }
	}

}

function initialize_incom_register() {
	$incom_admin = new INCOM_Register();
}
add_action( 'init', 'initialize_incom_register' );