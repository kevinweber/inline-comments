<?php
/**
 * @package Frontend
 */
class INCOM_Frontend {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'lazyload_enqueue_jquery' ) );
	}

	/**
	 * Called by class-wp.php and class-indisq.php
	 */
	function addActions() {
		add_action( 'wp_enqueue_scripts', array( $this, 'incom_enqueue_scripts' ) );
		add_action( 'wp_footer', array( $this, 'load_incom'), 15, 'functions' );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_incom_style') );
		add_action( 'wp_head', array( $this, 'load_incom_custom_css') );
	}

	/**
 	 * Enable jQuery (comes with WordPress)
 	 */
 	function lazyload_enqueue_jquery() {
     	wp_enqueue_script( 'jquery' );
 	}

}


function initialize_incom_frontend() {
	$incom_frontend = new INCOM_Frontend();
}
add_action( 'init', 'initialize_incom_frontend' );