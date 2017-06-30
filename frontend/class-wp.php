<?php
/**
 * @package Comment System Type: WordPress
 */
class INCOM_WordPress extends INCOM_Frontend {

	function __construct() {
		$this->addActions();
	}

	function addActions() {
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

			$(function(){
				$(window).on( "resize", function() {
				        clearTimeout( icTimer );

				        icTimer = setTimeout( function() {
						incom.rebuild();
				        }, 100 );
				} );
			});

			$(window).on( "load", function() {
				incom.init({
					canComment: <?php echo parent::can_comment() == "" ? "false" : "true"; ?>,
					selectors: '<?php echo get_option("multiselector") == "" ? "p" : get_option("multiselector"); ?>',
					moveSiteSelector: '<?php echo get_option("moveselector") == "" ? "body" : esc_js(get_option("moveselector")); ?>',
			    countStatic: <?php echo get_option("incom_bubble_static") == "1" ? "false" : "true"; ?>,
			    alwaysStatic: <?php echo get_option("incom_bubble_static_always") == "1" ? "true" : "false"; ?>,
			    bubbleStyle: '<?php echo get_option("select_bubble_style") == "" ? "bubble" : esc_js(get_option("select_bubble_style")); ?>',
			    bubbleAnimationIn: '<?php echo get_option("select_bubble_fadein") == "" ? "default" : esc_js(get_option("select_bubble_fadein")); ?>',
			    bubbleAnimationOut: '<?php echo get_option("select_bubble_fadeout") == "" ? "default" : esc_js(get_option("select_bubble_fadeout")); ?>',
				  // defaultBubbleText: '+',
			    // highlighted: false,
			    position: '<?php echo get_option("incom_select_align") == "" ? "right" : esc_js(get_option("incom_select_align")); ?>',
			    background: '<?php echo get_option("set_bgcolour") == "" ? "#fff" : esc_js(get_option("set_bgcolour")); ?>',
					backgroundOpacity: '<?php echo get_option("incom_set_bgopacity") == "" ? "1" : esc_js(get_option("incom_set_bgopacity")); ?>',
					displayBranding: <?php echo get_option("incom_attribute") == "link" ? "true" : "false"; ?>,
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
}
