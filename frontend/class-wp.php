<?php
/**
 * @package Comment System Type: WordPress
 */
class INCOM_WordPress extends INCOM_Frontend {

	function __construct() {
		parent::addActions();
		$this->addActions();
	}

	function addActions() {
		$this->get_comments_php();
		// add_action( "wp_ajax_get_comments_php", array( $this, 'get_comments_php' ) );
		// add_action( "wp_ajax_nopriv_get_comments_php", array( $this, 'get_comments_php' ) );
	}

	function get_comments_php() {
		require_once( 'class-comments.php' );
		$comments = new INCOM_Comments();
		// $comments_php = $comments->getCode();
		// return $comments_php;
		// die();
	}

	/**
	 * Add Scripts into Footer
	 */
	function load_incom() { ?>
		<script>
			var $ind = jQuery.noConflict();

			$ind(document).ready(function() {
				incom.init({
					selectors: '<?php if (get_option("multiselector") == '') { echo "p"; } else { echo get_option("multiselector"); } ?>',
					moveSiteSelector: '<?php if (get_option("moveselector") == '') { echo "body"; } else { echo get_option("moveselector"); } ?>',
	            	countStatic: <?php if (get_option("bubble_static") == "1") { echo "false"; } else { echo "true"; } ?>,
	            	bubbleStyle: '<?php if (get_option("select_bubble_style") == "") { echo "plain"; } else { echo get_option("select_bubble_style"); } ?>',
				  // defaultBubbleText: '+',
	              // highlighted: false,
	            	position: '<?php if (get_option("select_align") == "") { echo "right"; } else { echo get_option("select_align"); } ?>',
	              	background: '<?php if (get_option("set_bgcolour") == "") { echo "#fff"; } else { echo get_option("set_bgcolour"); } ?>',
				});
			});
		</script>
	<?php }

	/**
	 * Add scripts (like JS)
	 */
	function incom_enqueue_scripts() {
		wp_enqueue_script('ajax-script', plugins_url( 'js/min/inline-comments-ck.js' , plugin_dir_path( __FILE__ ) ), array( 'jquery' ) );
		//wp_localize_script('ajax-script', 'ajax_script_vars', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'comments_php' => $this->get_comments_php() ) );
	}

	/**
	 * Add stylesheet
	 */
	function load_incom_style() {
		wp_register_style( 'incom-style', plugins_url('css/min/style-wp.css', plugin_dir_path( __FILE__ ) ) );
		wp_enqueue_style( 'incom-style' );
	}


	/**
	 * Add Custom CSS
	 */
	function load_incom_custom_css(){
		echo '<style type="text/css">';
		if (stripslashes(get_option('custom_css')) != '') {
			echo stripslashes(get_option('custom_css'));
		}
		echo '</style>';
	}

}

function initialize_incom_wp() {
	$incom_wp = new INCOM_WordPress();
}
add_action( 'init', 'initialize_incom_wp' );