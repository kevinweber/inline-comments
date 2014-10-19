<?php
/**
 * Create options panel (http://codex.wordpress.org/Creating_Options_Pages)
 * @package Admin
 */

class INCOM_Admin_Options {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'incom_create_menu' ));	
		add_action( 'admin_init', array( $this, 'admin_init_options' ) );
	}

	function admin_init_options() {
		if ( isset( $_GET['page'] ) && ( $_GET['page'] == 'incom.php') ) {
			add_action( 'admin_footer', array( $this, 'incom_admin_css' ) );
			add_action( 'admin_footer', array( $this, 'incom_admin_js' ) );
		}
		$plugin = plugin_basename( INCOM_FILE ); 
		add_filter("plugin_action_links_$plugin", array( $this, 'incom_settings_link' ) );
		$this->register_incom_settings();
	}

	/**
	 * Add settings link on plugin page
	 */
	function incom_settings_link($links) { 
	  $settings_link = '<a href="options-general.php?page=incom.php">'.esc_html__( 'Settings', INCOM_TD ).'</a>'; 
	  array_unshift($links, $settings_link); 
	  return $links; 
	}

	function incom_create_menu() {
		add_options_page( esc_html__( 'Inline Comments', INCOM_TD ), esc_html__( 'Inline Comments', INCOM_TD ), 'manage_options', 'incom.php', array( $this, 'incom_settings_page'));
	}

	function register_incom_settings() {
		$arr = array(
			// Basics
			'select_comment_type',
			'multiselector',
			INCOM_OPTION_KEY.'_support_for_ajaxify_comments',
			INCOM_OPTION_KEY.'_reply',
			'moveselector',
			
			// Styling
			'custom_css',
			INCOM_OPTION_KEY.'_select_align',
			INCOM_OPTION_KEY.'_avatars_display',
			INCOM_OPTION_KEY.'_avatars_size',
			'select_bubble_style',
			'set_bgcolour',
			INCOM_OPTION_KEY.'_set_bgopacity',
			'bubble_static',

			// Advanced
			INCOM_OPTION_KEY.'_content_comments_before',
			'select_bubble_fadein',
			'select_bubble_fadeout',
			'comment_permalink',
			'cancel_x',
			'cancel_link',
			'incom_field_url',
			'incom_bubble_static_always',
		);
		foreach ( $arr as $i ) {
			register_setting( 'incom-settings-group', $i );
		}
		do_action( 'register_incom_settings_after' );
	}

	function incom_settings_page()	{ ?>

		<div id="tabs" class="ui-tabs">
			<h2><?php esc_html_e( 'Inline Comments', INCOM_TD ); ?> <span class="subtitle">by <a href="http://kevinw.de/ic" target="_blank" title="<?php esc_html_e( 'Website by Kevin Weber', INCOM_TD ); ?>">Kevin Weber</a> (<?php esc_html_e( 'Version', INCOM_TD ); ?> <?php echo INCOM_VERSION; ?>)</span>
				<br><span class="claim" style="font-size:15px;font-style:italic;position:relative;top:-7px;"><?php esc_html_e( '&hellip; revolutionise the way we comment online!', INCOM_TD ); ?></span>
			</h2>

			<ul class="ui-tabs-nav">
		        <li><a href="#basics"><?php esc_html_e( 'Basics', INCOM_TD ); ?> <span class="newred_dot">&bull;</span></a></li>
		    	<li><a href="#styling"><?php esc_html_e( 'Styling', INCOM_TD ); ?> <span class="newred_dot">&bull;</span></a></li>
				<li><a href="#advanced"><?php esc_html_e( 'Advanced', INCOM_TD ); ?> <span class="newred_dot">&bull;</span></a></li>
		    	<?php do_action( 'incom_settings_page_tabs_link_after' ); ?>
		    </ul>

			<form method="post" action="options.php">
			    <?php settings_fields( 'incom-settings-group' ); ?>
			    <?php do_settings_sections( 'incom-settings-group' ); ?>

			    <div id="basics">

					<h3><?php esc_html_e( 'Basic Settings', INCOM_TD ); ?></h3>

				    <table class="form-table">
					    <tbody>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Comment System', INCOM_TD ); ?> <span class="newred"><?php esc_html_e( 'Updated', INCOM_TD ); ?></span></th>
						        <td>
									<select class="select" typle="select" name="select_comment_type">
										<option value="wp"<?php if (get_option('select_comment_type') === 'wp') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'WordPress Comments', INCOM_TD ); ?></option>
									</select>
									<span><br>
										<span style="color:#f60;">Notice:</span> Disqus integration is no longer supported, but you can still use the previous versions 1.2 or below from <a href="https://wordpress.org/plugins/inline-comments/developers/" target="_blank" title="Inline Comments for Developers">here</a>. This update makes Inline Comments even more lightweight and allows to simplify this options page.</span>
									</span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Selectors', INCOM_TD ); ?></th>
					        	<td>
					        		<textarea rows="3" cols="70" type="text" name="multiselector" placeholder="selector1, selector2, selectorN"><?php echo get_option('multiselector'); ?></textarea><br>
					        		<span><?php esc_html_e( 'Insert selectors in order to control beside which sections the comment bubbles should be displayed.', INCOM_TD ); ?><br><br><?php esc_html_e( 'You can insert selectors like that:', INCOM_TD ); ?> <i><?php esc_html_e( 'selector1, selector2, selectorN', INCOM_TD ); ?></i><br><?php esc_html_e( 'Example:', INCOM_TD ); ?> <i><?php esc_html_e( 'h1, .single-post .entry-content p, span, blockquote', INCOM_TD ); ?></i></span>
					        	</td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Use Ajaxify (no page reload)', INCOM_TD ); ?><br>
						        	<span class="description thin">
										<?php printf( esc_html__( 'Requires %1$sthat plugin%2$s.', INCOM_TD ),
											'<a href="http://wordpress.org/extend/plugins/wp-ajaxify-comments/" title="WP-Ajaxify-Comments" target="_blank">',
											'</a>'
										); ?>
									</span>
					        	</th>
						        <td>
									<input name="<?php echo INCOM_OPTION_KEY; ?>_support_for_ajaxify_comments" type="checkbox" value="1" <?php checked( '1', get_option( INCOM_OPTION_KEY.'_support_for_ajaxify_comments' ) ); ?> />

									<span><?php
									printf( esc_html__( 'Empower %1$sWP-Ajaxify-Comments%2$s (version 0.24.0 or higher) to add Ajax functionality to Inline Comments and improve the user experience: Your page will not reload after a comment is submitted.', INCOM_TD ),
										'<a href="http://wordpress.org/extend/plugins/wp-ajaxify-comments/" title="WP-Ajaxify-Comments" target="_blank">',
										'</a>'
									); ?> <b><?php esc_html_e( 'Recommended.', INCOM_TD ); ?></b></span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Enable Inline Replies', INCOM_TD ); ?> <span class="newred"><?php esc_html_e( 'New!', INCOM_TD ); ?></span></th>
						        <td>
									<input name="incom_reply" type="checkbox" value="1" <?php checked( '1', get_option( 'incom_reply' ) ); ?> /><span><?php esc_html_e( 'If checked, a reply link will be added below each inline comment and users can reply directly.', INCOM_TD ); ?></span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( '"Slide Site" Selector', INCOM_TD ); ?></th>
					        	<td>
					        		<?php 
					        			$arr_selectors = array( ".site-main", ".site-inner", ".site" );
					        			$selectors = implode( '<br>' , $arr_selectors );
					        		?>
					        		<input type="text" name="moveselector" placeholder="body" value="<?php echo get_option('moveselector'); ?>" />
					        			<br>
					        			<span><?php esc_html_e( 'This selector defines which content should slide left/right when the user clicks on a bubble. This setting depends on your theme\'s structure.', INCOM_TD ); ?> <?php esc_html_e( 'Default is', INCOM_TD ); ?> <i>body</i>.
					        				<br><br><?php esc_html_e( 'You might try one of these selectors:', INCOM_TD ); ?>
					        				<br><span class="italic"><?php echo $selectors; ?></span>
					        			</span>
					        	</td>
					        </tr>
					    </tbody>
				    </table>

			    </div>

			    <div id="styling">

					<h3><?php esc_html_e( 'Styling', INCOM_TD ); ?></h3>

				    <table class="form-table">
					    <tbody>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Custom CSS', INCOM_TD ); ?> <span class="description thin"><br><?php esc_html_e( 'Add additional CSS. This should override any other stylesheets.', INCOM_TD ); ?></span></th>
					        	<td>
					        		<textarea rows="14" cols="70" type="text" name="custom_css" placeholder="selector { property: value; }"><?php echo get_option('custom_css'); ?></textarea>
					        		<span>
					        			<?php esc_html_e( 'For example:', INCOM_TD ); ?><br>
					        			<i>.incom-bubble-dynamic a.incom-bubble-link { color: red; }</i><br>
					        			<i>.incom-active { background: #f3f3f3; }</i><br>
										<?php printf( esc_html__( '(You don\'t know CSS? Try the %1$shttp://kevinw.de/css-tutorial%2$sCSS Tutorial%3$s on W3Schools.)', INCOM_TD ),
											'<a href="',
											'" target="_blank">',
											'</a>'
										); ?>
					        		</span>
					        	</td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Position', INCOM_TD ); ?></th>
						        <td>
						        	<input id="<?php echo INCOM_OPTION_KEY; ?>_select_align_left" class="radio" type="radio" name="<?php echo INCOM_OPTION_KEY; ?>_select_align" value="left"<?php if (get_option( INCOM_OPTION_KEY.'_select_align') === 'left') { echo ' checked'; } ?> /><label class="label-radio" for="<?php echo INCOM_OPTION_KEY; ?>_select_align_left"><?php esc_html_e( 'Left', INCOM_TD ); ?></label>
						        	<input id="<?php echo INCOM_OPTION_KEY; ?>_select_align_right" class="radio" type="radio" name="<?php echo INCOM_OPTION_KEY; ?>_select_align" value="right"<?php if (get_option( INCOM_OPTION_KEY.'_select_align') !== 'left') { echo ' checked'; } ?> /><label class="label-radio" for="<?php echo INCOM_OPTION_KEY; ?>_select_align_right"><?php esc_html_e( 'Right', INCOM_TD ); ?></label>
							    </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Display Avatars', INCOM_TD ); ?><span class="newred"><?php esc_html_e( 'New!', INCOM_TD ); ?></span><br><span class="description thin"><?php esc_html_e( 'next to each comment', INCOM_TD ); ?></span></th>
						        <td>
									<input name="<?php echo INCOM_OPTION_KEY; ?>_avatars_display" type="checkbox" value="1" <?php checked( '1', get_option( INCOM_OPTION_KEY.'_avatars_display' ) ); ?> /><span><?php esc_html_e( 'If checked, avatars will be displayed next to each comment.', INCOM_TD ); ?></span><br><br>
						        	<input type="number" name="<?php echo INCOM_OPTION_KEY; ?>_avatars_size" placeholder="15" value="<?php echo get_option( INCOM_OPTION_KEY.'_avatars_size' ); ?>" /><span><?php esc_html_e( 'Define avatar size (in px). Insert an integer higher than 0.', INCOM_TD ); ?></span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Bubble Style', INCOM_TD ); ?> <span class="description thin"><br><?php esc_html_e( 'for sections with no comments yet', INCOM_TD ); ?></span></th>
						        <td>
									<select class="select" typle="select" name="select_bubble_style">
										<option value="bubble"<?php if (get_option('select_bubble_style') === 'bubble') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Bubble', INCOM_TD ); ?></option>
										<option value="plain"<?php if (get_option('select_bubble_style') === 'plain') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Plain +', INCOM_TD ); ?></option>
									</select>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Background Colour', INCOM_TD ); ?> <span class="description thin"><br><?php esc_html_e( 'for comment threads', INCOM_TD ); ?></span></th>
					        	<td>
					        		<input id="incom_picker_input_bgcolor" class="picker-input" type="text" name="set_bgcolour" placeholder="#ffffff" value="<?php if (get_option("set_bgcolour") == "") { echo "#ffffff"; } else { echo get_option("set_bgcolour"); } ?>" />
					        		<div id="incom_picker_bgcolor" class="picker-style"></div>
					        	</td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Background Opacity', INCOM_TD ); ?><span class="description thin"><br><?php esc_html_e( 'for comment threads', INCOM_TD ); ?></span></th>
					        	<td>
					        		<input type="text" name="incom_set_bgopacity" placeholder="1" value="<?php echo get_option('incom_set_bgopacity'); ?>" /><br><span><?php esc_html_e( 'Insert a value from 0 to 1 where "1" means maximum covering power. Insert 0.7 to make the opacity 70%.', INCOM_TD ); ?></span>
					        	</td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Hide Static Bubbles', INCOM_TD ); ?></th>
						        <td>
									<input name="bubble_static" type="checkbox" value="1" <?php checked( '1', get_option( 'bubble_static' ) ); ?> /><span><?php esc_html_e( 'This checkbox only affects bubbles that indicate a paragraph/element with at least one comment. If checked, the comment count bubbles will only be visible when the user hovers the specific paragraph. (By default, bubbles that indicate at least one comment are always visible.)', INCOM_TD ); ?></span>
						        </td>
					        </tr>
				        </tbody>
				    </table>

				</div>

			    <div id="advanced">

					<h3><?php esc_html_e( 'Advanced Settings', INCOM_TD ); ?></h3>

				    <table class="form-table">
					    <tbody>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Content Before', INCOM_TD ); ?><span class="newred"><?php esc_html_e( 'New!', INCOM_TD ); ?></span><br><span class="description thin"><?php esc_html_e( 'Insert HTML above the list of comments', INCOM_TD ); ?></span></th>
					        	<td>
					        		<textarea rows="5" cols="70" type="text" name="<?php echo INCOM_OPTION_KEY; ?>_content_comments_before" placeholder=""><?php echo get_option(INCOM_OPTION_KEY.'_content_comments_before'); ?></textarea>
					        	</td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Bubble Fade In', INCOM_TD ); ?></th>
						        <td>
									<select class="select" typle="select" name="select_bubble_fadein">
										<option value="default"<?php if (get_option('select_bubble_fadein') === 'default') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'No animation', INCOM_TD ); ?></option>
										<option value="fadein"<?php if (get_option('select_bubble_fadein') === 'fadein') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Basic animation', INCOM_TD ); ?></option>
									</select>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Bubble Fade Out', INCOM_TD ); ?></th>
						        <td>
									<select class="select" typle="select" name="select_bubble_fadeout">
										<option value="default"<?php if (get_option('select_bubble_fadeout') === 'default') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'No animation', INCOM_TD ); ?></option>
										<option value="fadeout"<?php if (get_option('select_bubble_fadeout') === 'fadeout') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Basic animation', INCOM_TD ); ?></option>
									</select>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Remove Closing "x"', INCOM_TD ); ?></th>
						        <td>
									<input name="cancel_x" type="checkbox" value="1" <?php checked( '1', get_option( 'cancel_x' ) ); ?> /><span><?php esc_html_e( 'If checked, the "x" at the right top of the comments wrapper will not be displayed.', INCOM_TD ); ?></span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Remove Permalinks', INCOM_TD ); ?></th>
						        <td>
									<input name="comment_permalink" type="checkbox" value="1" <?php checked( '1', get_option( 'comment_permalink' ) ); ?> /><span><?php esc_html_e( 'If checked, the permalink icon next to each comment will not be displayed.', INCOM_TD ); ?></span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Remove Field "Website"', INCOM_TD ); ?> <span class="newred"><?php esc_html_e( 'New!', INCOM_TD ); ?></span></th>
						        <td>
									<input name="incom_field_url" type="checkbox" value="1" <?php checked( '1', get_option( 'incom_field_url' ) ); ?> /><span><?php esc_html_e( 'If checked, users cannot submit an URL/Website when they comment inline.', INCOM_TD ); ?></span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Remove Link "Cancel"', INCOM_TD ); ?></th>
						        <td>
									<input name="cancel_link" type="checkbox" value="1" <?php checked( '1', get_option( 'cancel_link' ) ); ?> /><span><?php esc_html_e( 'If checked, the "cancel" link at the left bottom of the comments wrapper will not be displayed.', INCOM_TD ); ?></span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row"><?php esc_html_e( 'Always Display Bubbles', INCOM_TD ); ?></th>
						        <td>
									<input name="bubble_static_always" type="checkbox" value="1" <?php checked( '1', get_option( 'bubble_static_always' ) ); ?> /><span><?php esc_html_e( 'If checked, the comment count bubbles will always be visible (and not only on hover). Bubbles will not fade.', INCOM_TD ); ?></span>
						        </td>
					        </tr>
					    </tbody>
				    </table>

				</div>

				<?php do_action( 'incom_settings_page_tabs_after' ); ?>

			    <?php submit_button(); ?>
			</form>

			<?php if ( INCOM_ESSENTIAL ) {
				require_once( 'inc/signup.php' );
			} ?>

		    <table class="form-table">
		        <tr valign="top">
		        <th scope="row" style="width:100px;"><a href="http://kevinw.de/ic" target="_blank"><img src="http://www.gravatar.com/avatar/9d876cfd1fed468f71c84d26ca0e9e33?d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536&s=100" style="-webkit-border-radius:50%;-moz-border-radius:50%;border-radius:50%;"></a></th>
		        <td style="width:200px;">
		        	<p><a href="http://kevinw.de/ic" target="_blank">Kevin Weber</a> &ndash; <?php esc_html_e( 'that\'s me.', INCOM_TD ); ?><br>
		        	<?php esc_html_e( 'I\'m the developer of this plugin. Love it!', INCOM_TD ); ?></p></td>
			        <td>
						<p>
							<b><?php esc_html_e( 'It\'s free!', INCOM_TD ); ?></b> 
							<?php printf( esc_html__( 'Support me with %1$sa delicious lunch%2$s or give this plugin a 5 star rating %3$son WordPress.org%4$s.', INCOM_TD ),
								'<a href="http://kevinw.de/donate/InlineComments/" title="Pay me a delicious lunch" target="_blank">',
								'</a>',
								'<a href="http://wordpress.org/support/view/plugin-reviews/inline-comments?filter=5" title="Vote for Inline Comments" target="_blank">',
								'</a>'
							); ?>
						</p>
			        </td>       
		        <td style="width:300px;">
					<p>
						<b><?php esc_html_e( 'Personal tip: Must use plugins', INCOM_TD ); ?></b>
						<ol>
							<li><a href="http://kevinw.de/ic-ll" title="Lazy Load for Videos" target="_blank"><?php esc_html_e( 'Lazy Load for Videos', INCOM_TD ); ?></a> <?php esc_html_e( '(on my part)', INCOM_TD ); ?></li>
							<li><a href="https://yoast.com/wordpress/plugins/seo/" title="WordPress SEO by Yoast" target="_blank"><?php esc_html_e( 'WordPress SEO', INCOM_TD ); ?></a> <?php esc_html_e( '(by Yoast)', INCOM_TD ); ?></li>
							<li><a href="http://kevinw.de/ic-wb" title="wBounce" target="_blank"><?php esc_html_e( 'wBounce', INCOM_TD ); ?></a> <?php esc_html_e( '(on my part)', INCOM_TD ); ?></li>
							<li><a href="https://wordpress.org/plugins/broken-link-checker/" title="Broken Link Checker" target="_blank"><?php esc_html_e( 'Broken Link Checker', INCOM_TD ); ?></a> <?php esc_html_e( '(by Janis Elsts)', INCOM_TD ); ?></li>
						</ol>
					</p>
		        </td>
		        </tr>
			</table>
		</div>

	<?php
	}

	function incom_admin_js() {
	    wp_enqueue_script( 'incom_admin_js', plugins_url( '../js/min/admin-ck.js' , __FILE__ ), array( 'jquery', 'jquery-ui-tabs', 'farbtastic' ) );
	}

	function incom_admin_css() {
		wp_enqueue_style( 'incom_admin_css', plugins_url('../css/min/admin.css', __FILE__) );
		wp_enqueue_style( 'farbtastic' );	// Required for colour picker
	}

}

function initialize_incom_admin_options() {
	$incom_admin_options = new INCOM_Admin_Options();
}
add_action( 'init', 'initialize_incom_admin_options' );
?>