<?php
/**
 * @package Comment System Type: Disqus
 */
class INCOM_Indisq extends INCOM_Frontend {

	function __construct() {
		parent::__construct();
	}

	/**
	 * Add Scripts into Footer
	 */
	function load_incom() {	?>
		<script>
			disqus_shortname = '<?php if (get_option("disqus_shortname") !== "") { echo get_option("disqus_shortname"); } ?>';
			var $ind = jQuery.noConflict();

			$ind(document).ready(function() {
				$ind("<?php if (get_option('multiselector') == '') { echo 'p'; } else { echo get_option('multiselector'); } ?>").inlineDisqussions({
					identifier: '<?php if (get_option("identifier") == "") { echo "disqussion"; } else { echo get_option("identifier"); } ?>',
					displayCount: <?php if (get_option("display_count") == "1") { echo "false"; } else { echo "true"; } ?>,
					highlighted: <?php if (get_option("check_highlight") == "1") { echo "true"; } else { echo "false"; } ?>,
					position: '<?php if (get_option("select_align") == "") { echo "left"; } else { echo get_option("select_align"); } ?>',
					background: '<?php if (get_option("set_bgcolour") == "") { echo "#fff"; } else { echo get_option("set_bgcolour"); } ?>',
					maxWidth: <?php if (get_option("set_maxwidth") == "") { echo "9999"; } else { echo get_option("set_maxwidth"); } ?>
				});

		/** Make Inline Comments responsive ("Responsive Mode") **/
			var $slidewidth;	// Shift page content ('body') to the left
			var $viewportW = $ind(window).width();
			var $rmode = <?php if (get_option("check_rmode") == "1") { echo "true"; } else { echo "false"; } ?>

			// Test if Screen Size is Small enough and if Responsive Mode is activated
			if ( ( $viewportW < 860 ) && ( $rmode === true ) ) {
				$slidewidth = "70%";
				activate_rmode($slidewidth);
			}
			else if ( ( $viewportW < 980 ) && ( $rmode === true ) ) {
				$slidewidth = "55%";
				activate_rmode($slidewidth);
			}
			else if ( ( $viewportW < 1200 ) && ( $rmode === true ) ) {
				$slidewidth = "40%";
				activate_rmode($slidewidth);
			}
			else if ( $rmode === true ) {
				$slidewidth = "10%";
				activate_rmode($slidewidth);
			}
			function activate_rmode($slidewidth) {
				var $tvar = 0;
				if ( $tvar = 0 ) {
					$ind('a.disqussion-link').click(
					function(){
						<?php if (get_option("select_align") === "right") { ?>
							$ind('body').css( { "position" : "relative", "right" : $slidewidth  } );
						<?php } else { ?>
							$ind('body').css( { "position" : "relative", "left" : $slidewidth  } );
						<?php } ?>
						$tvar = 1;
					});
				}
				else if ( $tvar = 1 ) {
					$ind('a.disqussion-link').click(
					function(){
						<?php if (get_option("select_align") === "right") { ?>
							$ind('body').css( { "position" : "relative", "left" : "initial", "right" : $slidewidth  } );
						<?php } else { ?>
							$ind('body').css( { "position" : "relative", "right" : "initial", "left" : $slidewidth  } );
						<?php } ?>
						$tvar = 0;
					});	
				}
			}
		/** // Make Inline Comments responsive **/

			});
		</script>
	<?php }    
	
	/**
	 * Add scripts (like JS)
	 */
	function incom_enqueue_scripts() {
		wp_enqueue_script('pw-script', plugins_url( 'js/min/inlineDisqussions-ck.js' , plugin_dir_path( __FILE__ ) ) );
	}

	/**
	 * Add stylesheet
	 */
	function load_incom_style() {
		wp_register_style( 'incom-style', plugins_url('css/style-disq.css', plugin_dir_path( __FILE__ )) );
		wp_enqueue_style( 'incom-style' );
	}


	/**
	 * Add Custom CSS
	 */
	function load_incom_custom_css(){ ?>
		<style type="text/css">	
			<?php if (get_option("check_rmode") == "1") { ?>

				#disqus_thread.positioned {
					position:fixed!important;
					width:30%!important;	/* Differs from $slidewidth only in this case */
					height: 100%;
					left:0%!important;
					top:0!important;
					overflow-y: scroll;
					<?php if (get_option("select_align") === "right") { ?>
						left:70%!important;
					<?php } ?>
				}

				@media all and (max-width: 1200px) {
					#disqus_thread.positioned {
						width:40%!important;	/* Should be the same as $slidewidth */
						<?php if (get_option("select_align") === "right") { ?>
							left:60%!important;
						<?php } ?>
					}
				}
				@media all and (max-width: 980px) {
					#disqus_thread.positioned {
						width:55%!important;
						<?php if (get_option("select_align") === "right") { ?>
							left:45%!important;
						<?php } ?>
					}
				}
				@media all and (max-width: 860px) {
					#disqus_thread.positioned {
						width:70%!important;
						<?php if (get_option("select_align") == "right") { ?>
							left:30%!important;
						<?php } ?>
					}
				}
				@media all and (max-width: 810px) {
					#disqussions_wrapper {
						display: none;
					}
				}
			<?php }
			if (stripslashes(get_option('custom_css')) != '') { ?>
				<?php echo stripslashes(get_option('custom_css')); ?>
			<?php } ?>
		</style>
	<?php
	}

}

function initialize_incom_indisq() {
	$incom_indisq = new INCOM_Indisq();
}
add_action( 'init', 'initialize_incom_indisq' );