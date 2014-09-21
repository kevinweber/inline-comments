<?php
/**
 * @package Admin
 */

class INCOM_No_Premium_Admin_Options {

	function __construct() {
		$this->register_incom_no_premium_settings();
	}

	/**
	 * Add content and settings to options page
	 */
	function register_incom_no_premium_settings() {
		add_filter( 'register_incom_settings_after', array( $this, 'register_incom_no_premium_settings_after' ) );
		add_filter( 'incom_settings_page_tabs_link_after', array( $this, 'add_incom_admin_tab_link' ) );
		add_filter( 'incom_settings_page_tabs_after', array( $this, 'add_incom_admin_tab' ) );
	}
	// Step 1
	function register_incom_no_premium_settings_after() {
		$arr = array(
			'displayBranding',
			'displayAvatars'
		);
		foreach ( $arr as $i ) {
			register_setting( 'incom-settings-group', $i );
		}
	}
	// Step 2
	function add_incom_admin_tab_link() {
		echo '<li><a href="#tab-no-premium" class="tab-orange tab-premium">Premium <span class="newred_dot">&bull;</span></a></li>';
	}
	// Step 3
	function add_incom_admin_tab() { ?>
		<div id="tab-no-premium">

			<h3>Get Premium and &hellip;</h3>

			<table class="form-table">
				<tbody>
			        <tr valign="top">
			        	<th scope="row">&hellip; remove branding</th>
				        <td>
							<span>The <i>Premium Extension</i> automatically removes the branding link from Inline Comments.</span>
				        </td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row">&hellip; display avatars <span class="newred grey">Updated</span><br><span class="description thin">next to each comment</span></th>
				        <td>
							<span>Display photos/avatars from commentators next to each comment.</span>
				        </td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row">&hellip; insert content <span class="newred">New!</span></th>
				        <td>
							<span>Insert content (any HTML) above the list of comments.</span>
				        </td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row">&hellip; get preferred support<br><span class="description thin">to setup and style Inline Comments</span></th>
				        <td>
							<span>I help you to choose the correct selectors and assist you to make Inline Comments good-looking on your site.</span>
				        </td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row">&hellip; enjoy coming features<br><span class="description thin">with free lifetime updates!</span></th>
				        <td>
							<span>Here is so much more to come!<br>What do you think of social logins (Twitter, Facebook) and the possibility to reply to specific inline comments?</span>
				        </td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row"><a href="https://sellfy.com/p/uzBe/" id="uzBe" class="sellfy-buy-button">buy</a><script type="text/javascript" src="https://sellfy.com/js/api_buttons.js"></script></th>
				        <td>
							<span>You could invest $2.000 for a developer to let him develop such an innovative comment system. Or you pay just $48 for Inline Comments that has already been developed in weeks-long work. The price on the green button might change over time. If you think the price is not appropriate in your case, feel free to <a href="http://kevinw.de/kontakt" target="_blank">contact me</a>. Many others and I are persuaded that this plugin will revolutionise the way users comment online. So make sure to get premium as long as it is that cheap and push development using <a href="https://sellfy.com/p/uzBe/" target="_blank" title="Buy Inline Comments Premium on Sellfy">this link</a> or the <span style="color:green">green</span> button on the left.</span><br>
							<strong>Immediate download after purchase.</strong>
				        </td>
			        </tr>
			    </tbody>
		    </table>

	    </div>
	<?php }

}

function initialize_incom_no_premium_admin_options() {
	$incom_no_premium_admin_options = new INCOM_No_Premium_Admin_Options();
}
add_action( 'init', 'initialize_incom_no_premium_admin_options' );
?>