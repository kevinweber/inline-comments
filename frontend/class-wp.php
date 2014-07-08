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
	}



	function get_comments_php() {
		require_once( 'class-comments.php' );
		$comments = new INCOM_Comments();
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
	            	alwaysStatic: <?php if (get_option("bubble_static_always") == "1") { echo "true"; } else { echo "false"; } ?>,
	            	bubbleStyle: '<?php if (get_option("select_bubble_style") == "") { echo "bubble"; } else { echo get_option("select_bubble_style"); } ?>',
	            	bubbleAnimationIn: '<?php if (get_option("select_bubble_fadein") == "") { echo "default"; } else { echo get_option("select_bubble_fadein"); } ?>',
	            	bubbleAnimationOut: '<?php if (get_option("select_bubble_fadeout") == "") { echo "default"; } else { echo get_option("select_bubble_fadeout"); } ?>',
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
		wp_enqueue_script( 'function', plugins_url( 'js/min/inline-comments-ck.js' , plugin_dir_path( __FILE__ ) ), array( 'jquery' ), true);	// In case 'wp_localize_script' is used: wp_enqueue_script must be enqueued before wp_localize_script
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