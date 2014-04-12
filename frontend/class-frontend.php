<?php
/**
 * @package Frontend
 */
class INCOM_Frontend {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'incom_enqueue_jquery' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'incom_enqueue_scripts' ) );
		add_action( 'wp_footer', array( $this, 'load_incom'), 15, 'functions' );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_incom_style') );
		add_action( 'wp_head', array( $this, 'load_incom_custom_css') );

//add_action('wp_enqueue_scripts', array( $this, 'pw_load_scripts'));
		// add_action('template_redirect', 'your_function_name');
		// add_action("wp_ajax_nopriv_get_my_option", "get_my_option");

	}

	/**
	 * Enable jQuery (comes with WordPress)
	 */
	function incom_enqueue_jquery() {
    	wp_enqueue_script('jquery');
	}

	function incom_enqueue_scripts() {}
	function load_incom() {}
	function load_incom_style() {}
	function load_incom_custom_css() {}






	// function your_function_name() 
	// {
	// 	wp_localize_script( 'functions', 'my_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	// }

	// function get_my_option()
	// {
	//      //$var = get_option('select_align');
	//      echo 'testdataecho';//json_encode($var);
	//      die();
	// }

}


function initialize_incom_frontend() {
	$incom_frontend = new INCOM_Frontend();
}
add_action( 'init', 'initialize_incom_frontend' );
?>