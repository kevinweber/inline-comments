<?php
/**
 * @package WordPress Comment System
 */
class INCOM_WordPress extends INCOM_Frontend {

	function __construct() {
		parent::__construct();
	}

	/**
	 * Add Scripts into Footer
	 */
	function load_incom() {
			echo '<script src="' . plugins_url( 'js/min/inline-comments-ck.js' , plugin_dir_path( __FILE__ ) ) . '"></script>';
		?>
	<?php }    
	

	/**
	 * Add stylesheet
	 */
	function load_incom_style() {
		wp_register_style( 'incom-style', plugins_url('css/style-wp.css', plugin_dir_path( __FILE__ )) );
		wp_enqueue_style( 'incom-style' );
	}


	/**
	 * Add Custom CSS
	 */
	function load_incom_custom_css(){ ?>
		<style type="text/css">	
		</style>
	<?php
	}

}

function initialize_incom_wp() {
	$incom_wp = new INCOM_WordPress();
}
add_action( 'init', 'initialize_incom_wp' );
?>