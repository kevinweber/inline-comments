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
		$this->register_incom_settings();
	}

	function incom_create_menu() {
		add_options_page('Inline Comments', 'Inline Comments', 'manage_options', 'incom.php', array( $this, 'incom_settings_page'));
	}

	function register_incom_settings() {
		$arr = array('disqus_shortname', 'multiselector', 'bubble_static', 'check_highlight', 'select_align', 'select_comment_type', 'set_bgcolour', 'set_maxwidth', 'custom_css', 'check_rmode');
		foreach ( $arr as $i ) {
			register_setting( 'incom-settings-group', $i );
		}
	}

	function incom_settings_page()	{ ?>

		<div id="tabs" class="ui-tabs">
			<h2>Inline Comments by Kevin Weber</h2>

			<ul class="ui-tabs-nav">
		        <li><a href="#tabs-1">Basics</a></li>
				<li class="hide-disqus"><a href="#tabs-2">Disqus-specific</a></li>
		    	<li><a href="#tabs-3">Styling</a></li>
		    </ul>

			<form method="post" action="options.php">
			    <?php settings_fields( 'incom-settings-group' ); ?>
			    <?php do_settings_sections( 'incom-settings-group' ); ?>

			    <div id="tabs-1">

					<h3>Basic Settings</h3>

				    <table class="form-table">
					    <tbody>
					        <tr valign="top">
					        	<th scope="row">Comment System</th>
						        <td>
									<select class="select" typle="select" name="select_comment_type">
										<option value="wp"<?php if (get_option('select_comment_type') === 'wp') { echo ' selected="selected"'; } ?>>WordPress Comments (recommended)</option>
										<option value="disqus"<?php if (get_option('select_comment_type') === 'disqus') { echo ' selected="selected"'; } ?>>Disqus</option>
									</select>
									<span class="hide-disqus"><br><span style="color:#f60;">Notice:</span> Inline Comments with <strong>Disqus</strong> works on many websites. However, there are some known bugs that will not be fixed in the near future.</span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Position</th>
						        <td>
									<select class="select" typle="select" name="select_align">
										<option value="right"<?php if (get_option('select_align') === 'right') { echo ' selected="selected"'; } ?>>Right</option>
										<option value="left"<?php if (get_option('select_align') === 'left') { echo ' selected="selected"'; } ?>>Left</option>
									</select>
							    </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Selectors</th>
					        	<td>
					        		<textarea rows="3" cols="70" type="text" name="multiselector" placeholder="selector1, selector2, selectorN"><?php echo get_option('multiselector'); ?></textarea><br>
					        		<span>Insert selectors in order to control beside which sections the comment bubbles should be displayed. You can insert selectors like that: <i>selector1, selector2, selectorN</i>. Example: <i>h1, .single-post p, span, blockquote</i></span>
					        	</td>
					        </tr>
					    </tbody>
				    </table>

			    </div>

			    <div id="tabs-2">

					<h3>Disqus-specific Settings</h3>

				    <table class="form-table">
					    <tbody>
					        <tr valign="top">
					        	<th scope="row">Disqus Shortname (required!)</th>
					        	<td>
					        		<input type="text" name="disqus_shortname" placeholder="your_disqus_shortname" value="<?php echo get_option('disqus_shortname'); ?>" /> <span>To use Disqus, a <a href="http://disqus.com" target="_blank" title="Disqus">shortname</a> is required. (<a href="http://help.disqus.com/customer/portal/articles/466208-what-s-a-shortname-" target="_blank" title="What's a Shortname?">What's a shortname?</a>)</span>
					        	</td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Highlighting</th>
						        <td>
									<input name="check_highlight" type="checkbox" value="1" <?php checked( '1', get_option( 'check_highlight' ) ); ?> /> <span>If checked, the highlighting of the active section is enabled. Default: Unchecked (no highlighting).</span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Max Disqussion Width</th>
					        	<td>
					        		<input type="text" name="set_maxwidth" placeholder="9999" value="<?php echo get_option('set_maxwidth'); ?>" /> <span>Maximum width, in pixels, for comment threads.</span>
					        	</td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Responsive Mode</th>
						        <td>
									<input name="check_rmode" type="checkbox" value="1" <?php checked( '1', get_option( 'check_rmode' ) ); ?> /> <span>If checked, the plugin reacts different on smaller/larger screens. The comments field will be fixed on the page's right/left side.</span>
						        </td>
					        </tr>
					    </tbody>
				    </table>

				</div>

			    <div id="tabs-3">

					<h3>Styling</h3>

				    <table class="form-table">
					    <tbody>
					        <tr valign="top">
					        	<th scope="row">Hide Static Bubbles</th>
						        <td>
									<input name="bubble_static" type="checkbox" value="1" <?php checked( '1', get_option( 'bubble_static' ) ); ?> /> <span>If checked, the comment count bubbles will only be visible when the user hovers a specific element (paragraph or so).</span>
						        </td>
					        </tr>
					        <tr valign="top">
					        	<th scope="row">Background Colour <span class="description thin"><br>for comment threads</th>
					        	<td>
					        		<input id="incom_picker_input_bgcolor" class="picker-input" type="text" name="set_bgcolour" placeholder="#ffffff" value="<?php if (get_option("set_bgcolour") == "") { echo "#ffffff"; } else { echo get_option("set_bgcolour"); } ?>" />
					        		<div id="incom_picker_bgcolor" class="picker-style"></div>
					        	</td>
					        </tr>

					        <tr valign="top">
					        	<th scope="row">Custom CSS <span class="description thin"><br>Add additional CSS. This should override any other stylesheets.</span></th>
					        	<td>
					        		<textarea rows="14" cols="70" type="text" name="custom_css" placeholder="selector { property: value; }"><?php echo get_option('custom_css'); ?></textarea>
					        		<span>
					        			For example:<br>
					        			<i>a.incom-bubble-link { color: red; }</i><br>
					        			(You don't know CSS? Try the <a href="http://www.w3schools.com/css/DEFAULT.asp" target="_blank" title="CSS Tutorial on W3Schools">CSS Tutorial</a> on W3Schools.)
					        		</span>
					        	</td>
					        </tr>
				        </tbody>
				    </table>

				</div>

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
		        <td>
					<p><b>Speed up your site</b> by replacing embedded Youtube and Vimeo videos with a clickable preview image: <a href="http://kevinw.de/ind-ll" title="Lazy Load for Videos" target="_blank">Lazy Load for Videos</a>.</p>
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