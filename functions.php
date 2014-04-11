<?php
/*
 * Plugin Name: Inline Comments
 * Plugin URI: http://kevinw.de/inline-comments.php
 * Description: Inline Comments adds the great Disqus Comment System to the side of paragraphs and other specific sections (like headlines and images) of your post. The comment area is shown when you click the comment count bubbles (left or right) beside any section.
 * Author: Kevin Weber
 * Version: 0.8
 * Author URI: http://kevinw.de/
 * License: MIT
 * Text Domain: inline-comments
*/

/***** Part 1: Enable jQuery (comes with WordPress) */
	function indisq_enqueue_jquery() {
    	wp_enqueue_script('jquery');
	}
	add_action( 'wp_enqueue_scripts', 'indisq_enqueue_jquery' );

/***** Part 2: Add Scripts into Footer */
	function load_indisq() {
			echo '<script src="' . plugins_url( 'js/inlineDisqussions.js' , __FILE__ ) . '"></script>';
		?>
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
				$slidewidth = "30%";
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
	add_action('wp_footer', 'load_indisq');

/***** Part 3: Add stylesheet and Custom CSS */
	function load_indisq_style() {
		wp_register_style( 'indisq-style', plugins_url('style.css', __FILE__) );
		wp_enqueue_style( 'indisq-style' );
	}
	add_action( 'wp_enqueue_scripts', 'load_indisq_style' );

	function indisq_custom_css(){ ?>
		<style type="text/css">	
			<?php if (get_option("check_rmode") == "1") { ?>

				#disqus_thread.positioned {
					position:fixed!important;
					width:30%!important;	/* Should be the same as $slidewidth */
					height: 100%;
					left:0%!important;
					top:0!important;
					overflow-y: scroll;
					<?php if (get_option("select_align") == "right") { ?>
						left:70%!important;
					<?php } ?>
				}

				@media all and (max-width: 1200px) {
					#disqus_thread.positioned {
						width:40%!important;
						<?php if (get_option("select_align") == "right") { ?>
							left:60%!important;
						<?php } ?>
					}
				}
				@media all and (max-width: 980px) {
					#disqus_thread.positioned {
						width:55%!important;
						<?php if (get_option("select_align") == "right") { ?>
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
	<?php	}
	add_action( 'wp_head', 'indisq_custom_css' );

/***** Part 4: Create options panel (http://codex.wordpress.org/Creating_Options_Pages) */
	function indisq_create_menu() {
		add_options_page('Inline Comments', 'Inline Comments', 'manage_options', 'indisq.php', 'indisq_settings_page');
	}

	function register_indisq_settings() {
		$arr = array('disqus_shortname', 'identifier', 'multiselector', 'display_count', 'check_highlight', 'select_align', 'set_bgcolour', 'set_maxwidth', 'custom_css', 'check_rmode');
		foreach ( $arr as $i ) {
			register_setting( 'indisq-settings-group', $i );
		}
	}

	function indisq_settings_page() { ?>
	<div class="wrap">
	<h2>Inline Comments</h2>
	<form method="post" action="options.php">
	    <?php settings_fields( 'indisq-settings-group' ); ?>
	    <?php do_settings_sections( 'indisq-settings-group' ); ?>
	    <table class="form-table">
	        <tr valign="top">
	        	<th scope="row">Disqus Shortname (required!)</th>
	        	<td>
	        		<input type="text" name="disqus_shortname" placeholder="your_disqus_shortname" value="<?php echo get_option('disqus_shortname'); ?>" /> <span>This plugin requires a <a href="http://disqus.com" target="_blank" title="Disqus">Disqus</a> shortname. (<a href="http://help.disqus.com/customer/portal/articles/466208-what-s-a-shortname-" target="_blank" title="What's a Shortname?">What's a shortname?</a>)</span>
	        	</td>
	        </tr>
	        <tr valign="top">
	        	<th scope="row">Insert Selectors</th>
	        	<td>
	        		<textarea rows="3" cols="70" type="text" name="multiselector"><?php echo get_option('multiselector'); ?></textarea><br>
	        		<span>Insert selectors in order to control beside which sections the comment bubbles should be displayed. You can insert selectors like that: <i>selector1, selector2, selectorN</i>. Example: <i>h1, .single-post p, span, blockquote</i></span>
	        	</td>
	        </tr>
	        <tr valign="top">
	        	<th scope="row">Identifier</th>
	        	<td>
	        		<input type="text" name="identifier" placeholder="disqussion" value="<?php echo get_option('identifier'); ?>" /> <span>Set a string to be used, together with an index number, as the disqus_identifier string. Defaults: disqussion.</span>
	        	</td>
	        </tr>
	        <tr valign="top">
	        	<th scope="row">Display Count</th>
		        <td>
					<input name="display_count" type="checkbox" value="1" <?php checked( '1', get_option( 'display_count' ) ); ?> /> <span>If checked, the comment count inside the icon is disabled. Default: Unchecked (count is visible).</span>
		        </td>
	        </tr>
	        <tr valign="top">
	        	<th scope="row">Highlighting</th>
		        <td>
					<input name="check_highlight" type="checkbox" value="1" <?php checked( '1', get_option( 'check_highlight' ) ); ?> /> <span>If checked, the highlighting of the active section is enabled. Default: Unchecked (no highlighting).</span>
		        </td>
	        </tr>
	        <tr valign="top">
	        	<th scope="row">Position</th>
		        <td>
					<select class="select" typle="select" name="select_align">
						<option value="left"<?php if (get_option('select_align') == 'left') { echo ' selected="selected"'; } ?>>Left</option>
						<option value="right"<?php if (get_option('select_align') == 'right') { echo ' selected="selected"'; } ?>>Right</option>
					</select>
			    </td>
	        </tr>
	        <tr valign="top">
	        	<th scope="row">Background Colour</th>
	        	<td>
	        		<input type="text" name="set_bgcolour" placeholder="#ffffff" value="<?php echo get_option('set_bgcolour'); ?>" /> <span>CSS background-color for comment threads.</span>
	        	</td>
	        </tr>
	        <tr valign="top">
	        	<th scope="row">Max Disqussion Width</th>
	        	<td>
	        		<input type="text" name="set_maxwidth" placeholder="9999" value="<?php echo get_option('set_maxwidth'); ?>" /> <span>Maximum width, in pixels, for comment threads.</span>
	        	</td>
	        </tr>
	        <tr valign="top">
	        	<th scope="row">Responsive Mode (Beta)</th>
		        <td>
					<input name="check_rmode" type="checkbox" value="1" <?php checked( '1', get_option( 'check_rmode' ) ); ?> /> <span>If checked, the plugin reacts different on smaller/larger screens.</span>
		        </td>
	        </tr>
	        <tr valign="top">
	        	<th scope="row">Custom CSS</th>
	        	<td>
	        		<textarea rows="14" cols="70" type="text" name="custom_css"><?php echo get_option('custom_css'); ?></textarea>
	        	</td>
	        </tr>
	    </table>
	    <?php submit_button(); ?>
	</form>

	    <table class="form-table">
	        <tr valign="top">
	        <th scope="row" style="width:100px;"><a href="http://kevinw.de/ind" target="_blank"><img src="http://www.gravatar.com/avatar/9d876cfd1fed468f71c84d26ca0e9e33?d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536&s=100" style="-webkit-border-radius:50%;-moz-border-radius:50%;border-radius:50%;"></a></th>
	        <td style="width:200px;">
	        	<p><a href="http://kevinw.de/ind" target="_blank">Kevin Weber</a> &ndash; that's me.<br>
	        	I'm the developer of this plugin. I hope you enjoy it!</p></td>
	        <td>
				<p><b>It's free!</b> Support me with <a href="http://kevinw.de/donate/InlineComments/" title="Pay me a delicious lunch" target="_blank">a delicious lunch</a> or give this plugin a 5 star rating <a href="http://wordpress.org/support/view/plugin-reviews/inline-comments?filter=5" title="Vote for Inline Comments" target="_blank">on WordPress.org</a>.</p>
	        </td>
	        </tr>
		</table>
	</div>
	<?php }
	add_action('admin_menu', 'indisq_create_menu');
	add_action('admin_init', 'register_indisq_settings');

/***** Plugin by Kevin Weber || kevinw.de *****/
?>