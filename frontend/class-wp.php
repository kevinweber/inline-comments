<?php
/**
 * @package Comment System Type: WordPress
 */
class INCOM_WordPress extends INCOM_Frontend {

	function __construct() {
		$this->addActions();
	}

	function addActions() {
        if ($this->test_if_status_is_off()) return;
      
		add_action( 'wp_enqueue_scripts', array( $this, 'incom_enqueue_scripts' ) );
		add_action( 'wp_footer', array( $this, 'load_incom'), 444, 'functions' );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_incom_style') );
		add_action( 'wp_head', array( $this, 'load_custom_css') );
	}

	/**
	 * Add Scripts into Footer
	 */
	function load_incom() { ?>
		<script>
		(function ( $ ) {
			var icTimer;

			$(window).on( "resize", function() {
			        clearTimeout( icTimer );

			        icTimer = setTimeout( function() {
					incom.rebuild();
			        }, 100 );
			} );

			$(window).on( "load", function() {
				incom.init({
					selectors: '<?php if (get_option("multiselector") == '') { echo "p"; } else { echo get_option("multiselector"); } ?>',
					moveSiteSelector: '<?php if (get_option("moveselector") == '') { echo "body"; } else { echo esc_js(get_option("moveselector")); } ?>',
			    	countStatic: <?php if (get_option("incom_bubble_static") == "1") { echo "false"; } else { echo "true"; } ?>,
			    	alwaysStatic: <?php if (get_option("incom_bubble_static_always") == "1") { echo "true"; } else { echo "false"; } ?>,
			    	bubbleStyle: '<?php if (get_option("select_bubble_style") == "") { echo "bubble"; } else { echo esc_js(get_option("select_bubble_style")); } ?>',
			    	bubbleAnimationIn: '<?php if (get_option("select_bubble_fadein") == "") { echo "default"; } else { echo esc_js(get_option("select_bubble_fadein")); } ?>',
			    	bubbleAnimationOut: '<?php if (get_option("select_bubble_fadeout") == "") { echo "default"; } else { echo esc_js(get_option("select_bubble_fadeout")); } ?>',
				  // defaultBubbleText: '+',
			      // highlighted: false,
			    	position: '<?php if (get_option("incom_select_align") == "") { echo "right"; } else { echo esc_js(get_option("incom_select_align")); } ?>',
			      	background: '<?php if (get_option("set_bgcolour") == "") { echo "#fff"; } else { echo esc_js(get_option("set_bgcolour")); } ?>',
					backgroundOpacity: '<?php if (get_option("incom_set_bgopacity") == "") { echo "1"; } else { echo esc_js(get_option("incom_set_bgopacity")); } ?>',
					displayBranding: <?php if (get_option("incom_attribute") == "link") { echo "true"; } else { echo "false"; } ?>,
					<?php do_action( 'incom_wp_set_options' ); ?>
				});
			});
		})(jQuery);
		</script>
	<?php }

	/**
	 * Add scripts (like JS)
	 */
	function incom_enqueue_scripts() {
		if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
			wp_enqueue_script( 'incom-js', plugins_url( 'js/inline-comments.js' , plugin_dir_path( __FILE__ ) ), array( 'jquery' ), INCOM_VERSION );
		} else {
			wp_enqueue_script( 'incom-js', plugins_url( 'js/min/inline-comments.min.js' , plugin_dir_path( __FILE__ ) ), array( 'jquery' ), INCOM_VERSION );	// In case 'wp_localize_script' is used: wp_enqueue_script must be enqueued before wp_localize_script
		}
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
	function load_custom_css(){
		echo '<style type="text/css">';

		// Set avatar size
		if ( get_option( 'incom_avatars_display' ) == 1 ) { ?>
			.incom-comments-wrapper .vcard img {
			    width: <?php echo esc_attr(parent::get_avatar_size()); ?>px;
			    height: <?php echo esc_attr(parent::get_avatar_size()); ?>px;
			}
		<?php }

		// User's custom CSS input
		if (stripslashes(get_option('custom_css')) != '') {
			echo esc_html(stripslashes(get_option('custom_css')));
		}

		echo '</style>';
	}

 	/**
 	 * Test if status is "off" for specific post/page
 	 */
 	function test_if_status_is_off() {
		global $post;
		
		$result = false;
		if (!isset($post->ID)) {
			$id = null;
		}
		else {
			$id = $post->ID;
		}

//
//		// When the individual status for a page/post is 'off', all the other setting don't matter. So this has to be tested at first. 
//		if ( get_post_meta( $id, 'wbounce_status', true ) && get_post_meta( $id, 'wbounce_status', true ) === 'off' ) {
//			$result = true;
//		}
//		else if (
//			( !get_option(WBOUNCE_OPTION_KEY.'_status_default') ) ||	// Fire when no option is defined yet
//			( get_post_meta( $id, 'wbounce_status', true ) === 'on' ) ||
//			( get_option(WBOUNCE_OPTION_KEY.'_status_default') === 'on' ) ||
//			( get_option(WBOUNCE_OPTION_KEY.'_status_default') === 'on_posts' && is_single() ) ||
//			( get_option(WBOUNCE_OPTION_KEY.'_status_default') === 'on_pages' && is_page() ) ||
//			( get_option(WBOUNCE_OPTION_KEY.'_status_default') === 'on_posts_pages' && (is_single()||is_page()) )
//		) {
//			$result = false;
//		}
//		else
//			$result = true;
//
//		// wbounce_test_if_status_is_off
//		$result = apply_filters( WBOUNCE_OPTION_KEY.'_test_if_status_is_off', $result );

		return false;
 	}

}
