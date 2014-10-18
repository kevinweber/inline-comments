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
	  $settings_link = '<a href="options-general.php?page=incom.php">Settings</a>'; 
	  array_unshift($links, $settings_link); 
	  return $links; 
	}

	function incom_create_menu() {
		add_options_page('Inline Comments', 'Inline Comments', 'manage_options', 'incom.php', array( $this, 'incom_settings_page'));
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
			INCOM_OPTION_KEY.'_avatars_display',
			INCOM_OPTION_KEY.'_avatars_size',
			'select_align',
			'select_bubble_style',
			'set_bgcolour',
			INCOM_OPTION_KEY.'_set_bgopacity',
			'bubble_static',

			// Advanced
			'incom_content_comments_before',
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
			<h2>Inline Comments <span class="subtitle">by <a href="http://kevinw.de/ic" target="_blank" title="Website by Kevin Weber">Kevin Weber</a> (Version <?php echo INCOM_VERSION; ?>)</span>
				<br><span class="claim" style="font-size:15px;font-style:italic;position:relative;top:-7px;">&hellip; revolutionise the way we comment online!</span>
			</h2>


			<ul class="ui-tabs-nav">
		        <li><a href="#basics">Basics <span class="newred_dot">&bull;</span></a></li>
		    	<li><a href="#styling">Styling <span class="newred_dot">&bull;</span></a></li>
				<li><a href="#advanced">Advanced <span class="newred_dot">&bull;</span></a></li>
		    	<?php do_action( 'incom_settings_page_tabs_link_after' ); ?>
		    </ul>

			<form method="post" action="options.php">
			    <?php settings_fields( 'incom-settings-group' ); ?>
			    <?php do_settings_sections( 'incom-settings-group' ); ?>

			    <div id="basics">

					<h3>Basic Settings</h3>

				    <table class="form-table">
					    <tbody>
					        <tr valign="top">
					        	<th scope="row">Comment System <span class="newred">Updated!</span></th>
						        <td>
									<select class="select" typle="select" name="select_comment_type">
										<option value="wp"<?php if (get_option('select_comment_type') === 'wp') { echo ' selected="selected"'; } ?>>WordPress Comments (recommended)</option>
									</select>
									<span><br>
										<span style="color:#f60;">Notice:</span> Disqus integration is no longer supported, but you can still use the previous versions 1.2 or below from <a href="https://wordpress.org/plugins/inline-comments/developers/" target="_blank" title="Inline Comments for Developers">here</a>. This update makes Inline Comments even more lightweight and allows to simplify this options page.</span>
									</span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Selectors</th>
					        	<td>
					        		<textarea rows="3" cols="70" type="text" name="multiselector" placeholder="selector1, selector2, selectorN"><?php echo get_option('multiselector'); ?></textarea><br>
					        		<span>Insert selectors in order to control beside which sections the comment bubbles should be displayed.<br><br>You can insert selectors like that: <i>selector1, selector2, selectorN</i><br>Example: <i>h1, .single-post .entry-content p, span, blockquote</i></span>
					        	</td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Use Ajaxify (no page reload)<br><span class="description thin">Requires <a href="http://wordpress.org/extend/plugins/wp-ajaxify-comments/" title="WP-Ajaxify-Comments" target="_blank">that plugin</a>.</th>
						        <td>
									<input name="<?php echo INCOM_OPTION_KEY; ?>_support_for_ajaxify_comments" type="checkbox" value="1" <?php checked( '1', get_option( INCOM_OPTION_KEY.'_support_for_ajaxify_comments' ) ); ?> /> <span>Empower <a href="http://wordpress.org/extend/plugins/wp-ajaxify-comments/" title="WP-Ajaxify-Comments" target="_blank">WP-Ajaxify-Comments</a> (version 0.24.0 or higher) to add Ajax functionality to Inline Comments and improve the user experience: Your page will not reload after a comment is submitted. <b>Recommended.</b></span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Enable Inline Replies <span class="newred">New!</span></th>
						        <td>
									<input name="incom_reply" type="checkbox" value="1" <?php checked( '1', get_option( 'incom_reply' ) ); ?> /> <span>If checked, a reply link will be added below each inline comment and users can reply directly.</span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">"Slide Site" Selector</th>
					        	<td>
					        		<?php 
					        			$arr_selectors = array( ".site-main", ".site-inner", ".site" );
					        			$selectors = implode( '<br>' , $arr_selectors );
					        		?>
					        		<input type="text" name="moveselector" placeholder="body" value="<?php echo get_option('moveselector'); ?>" />
					        			<br>
					        			<span>This selector defines which content should slide left/right when the user clicks on a bubble. This setting depends on your theme's structure. Default is <i>body</i>.
					        				<br><br>You might try one of these selectors:
					        				<br><span class="italic"><?php echo $selectors; ?></span>
					        			</span>
					        	</td>
					        </tr>
					    </tbody>
				    </table>

			    </div>

			    <div id="styling">

					<h3>Styling</h3>

				    <table class="form-table">
					    <tbody>
					        <tr valign="top">
					        	<th scope="row">Custom CSS <span class="description thin"><br>Add additional CSS. This should override any other stylesheets.</span></th>
					        	<td>
					        		<textarea rows="14" cols="70" type="text" name="custom_css" placeholder="selector { property: value; }"><?php echo get_option('custom_css'); ?></textarea>
					        		<span>
					        			For example:<br>
					        			<i>.incom-bubble-dynamic a.incom-bubble-link { color: red; }</i><br>
					        			<i>.incom-active { background: #f3f3f3; }</i><br>
					        			(You don't know CSS? Try the <a href="http://kevinw.de/css-tutorial" target="_blank" title="CSS Tutorial on W3Schools">CSS Tutorial</a> on W3Schools.)
					        		</span>
					        	</td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Display Avatars<span class="newred">New!</span><br><span class="description thin">next to each comment</span></th>
						        <td>
									<input name="<?php echo INCOM_OPTION_KEY; ?>_avatars_display" type="checkbox" value="1" <?php checked( '1', get_option( INCOM_OPTION_KEY.'_avatars_display' ) ); ?> /> <span> If checked, avatars will be displayed next to each comment.</span><br><br>
						        	<input type="number" name="<?php echo INCOM_OPTION_KEY; ?>_avatars_size" placeholder="15" value="<?php echo get_option( INCOM_OPTION_KEY.'_avatars_size' ); ?>" /> <span>Define avatar size (in px). Insert an integer higher than 0.</span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Position</th>
						        <td>
						        	<input id="select_align_left" class="radio" type="radio" name="select_align" value="left"<?php if (get_option('select_align') === 'left') { echo ' checked'; } ?> /><label class="label-radio" for="select_align_left">Left</label>
						        	<input id="select_align_right" class="radio" type="radio" name="select_align" value="right"<?php if (get_option('select_align') !== 'left') { echo ' checked'; } ?> /><label class="label-radio" for="select_align_right">Right</label>
							    </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Bubble Style <span class="description thin"><br>for sections with no comments yet</span></th>
						        <td>
									<select class="select" typle="select" name="select_bubble_style">
										<option value="bubble"<?php if (get_option('select_bubble_style') === 'bubble') { echo ' selected="selected"'; } ?>>Bubble</option>
										<option value="plain"<?php if (get_option('select_bubble_style') === 'plain') { echo ' selected="selected"'; } ?>>Plain +</option>
									</select>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Background Colour <span class="description thin"><br>for comment threads</span></th>
					        	<td>
					        		<input id="incom_picker_input_bgcolor" class="picker-input" type="text" name="set_bgcolour" placeholder="#ffffff" value="<?php if (get_option("set_bgcolour") == "") { echo "#ffffff"; } else { echo get_option("set_bgcolour"); } ?>" />
					        		<div id="incom_picker_bgcolor" class="picker-style"></div>
					        	</td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Background Opacity<span class="description thin"><br>for comment threads</span></th>
					        	<td>
					        		<input type="text" name="incom_set_bgopacity" placeholder="1" value="<?php echo get_option('incom_set_bgopacity'); ?>" /><br><span>Insert a value from 0 to 1 where "1" means maximum covering power. Insert 0.7 to make the opacity 70%.</span>
					        	</td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Hide Static Bubbles</th>
						        <td>
									<input name="bubble_static" type="checkbox" value="1" <?php checked( '1', get_option( 'bubble_static' ) ); ?> /> <span>This checkbox only affects bubbles that indicate a paragraph/element with at least one comment. If checked, the comment count bubbles will only be visible when the user hovers the specific paragraph. (By default, bubbles that indicate at least one comment are always visible.)</span>
						        </td>
					        </tr>
				        </tbody>
				    </table>

				</div>

			    <div id="advanced">

					<h3>Advanced Settings</h3>

				    <table class="form-table">
					    <tbody>
					        <tr valign="top">
					        	<th scope="row">Content Before<span class="newred">New!</span><br><span class="description thin">Insert HTML above the list of comments</span></th>
					        	<td>
					        		<textarea rows="5" cols="70" type="text" name="incom_content_comments_before" placeholder=""><?php echo get_option('incom_content_comments_before'); ?></textarea>
					        	</td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Bubble Fade In</th>
						        <td>
									<select class="select" typle="select" name="select_bubble_fadein">
										<option value="default"<?php if (get_option('select_bubble_fadein') === 'default') { echo ' selected="selected"'; } ?>>No animation</option>
										<option value="fadein"<?php if (get_option('select_bubble_fadein') === 'fadein') { echo ' selected="selected"'; } ?>>Basic animation</option>
									</select>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Bubble Fade Out</th>
						        <td>
									<select class="select" typle="select" name="select_bubble_fadeout">
										<option value="default"<?php if (get_option('select_bubble_fadeout') === 'default') { echo ' selected="selected"'; } ?>>No animation</option>
										<option value="fadeout"<?php if (get_option('select_bubble_fadeout') === 'fadeout') { echo ' selected="selected"'; } ?>>Basic animation</option>
									</select>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Remove closing "x"</th>
						        <td>
									<input name="cancel_x" type="checkbox" value="1" <?php checked( '1', get_option( 'cancel_x' ) ); ?> /> <span>If checked, the "x" at the right top of the comments wrapper will not be displayed.</span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Remove permalinks</th>
						        <td>
									<input name="comment_permalink" type="checkbox" value="1" <?php checked( '1', get_option( 'comment_permalink' ) ); ?> /> <span>If checked, the permalink icon next to each comment will not be displayed.</span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Remove field "Website" <span class="newred">New!</span></th>
						        <td>
									<input name="incom_field_url" type="checkbox" value="1" <?php checked( '1', get_option( 'incom_field_url' ) ); ?> /> <span>If checked, users cannot submit an URL/Website when they comment inline.</span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Remove link "Cancel"</th>
						        <td>
									<input name="cancel_link" type="checkbox" value="1" <?php checked( '1', get_option( 'cancel_link' ) ); ?> /> <span>If checked, the "cancel" link at the left bottom of the comments wrapper will not be displayed.</span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Always Display Bubbles</th>
						        <td>
									<input name="bubble_static_always" type="checkbox" value="1" <?php checked( '1', get_option( 'bubble_static_always' ) ); ?> /> <span>If checked, the comment count bubbles will always be visible (and not only on hover). Bubbles will not fade.</span>
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
		        	<p><a href="http://kevinw.de/ic" target="_blank">Kevin Weber</a> &ndash; that's me.<br>
		        	I'm the developer of this plugin. Love it!</p></td>
			        <td>
						<p><b>It's free!</b> Support me with <a href="http://kevinw.de/donate/InlineComments/" title="Pay me a delicious lunch" target="_blank">a delicious lunch</a> or give this plugin a 5 star rating <a href="http://wordpress.org/support/view/plugin-reviews/inline-comments?filter=5" title="Vote for Inline Comments" target="_blank">on WordPress.org</a>.</p>
			        </td>       
		        <td style="width:300px;">
					<p>
						<b>Personal tip: Must use plugins</b>
						<ol>
							<li><a href="http://kevinw.de/ic-ll" title="Lazy Load for Videos" target="_blank">Lazy Load for Videos</a> (on my part)</li>
							<li><a href="https://yoast.com/wordpress/plugins/seo/" title="WordPress SEO by Yoast" target="_blank">WordPress SEO</a> (by Yoast)</li>
							<li><a href="http://kevinw.de/ic-wb" title="wBounce" target="_blank">wBounce</a> (on my part)</li>
							<li><a href="https://wordpress.org/plugins/broken-link-checker/" title="Broken Link Checker" target="_blank">Broken Link Checker</a> (by Janis Elsts)</li>
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