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
		echo '<li><a href="#premium" class="tab-orange tab-premium">Premium <span class="newred_dot">&bull;</span></a></li>';
	}
	// Step 3
	function add_incom_admin_tab() { ?>
		<div id="premium">

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
			        	<th scope="row">&hellip; display avatars</th>
				        <td>
							<span>Display photos/avatars from commentators next to each comment.</span>
				        </td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row">&hellip; insert content</th>
				        <td>
							<span>Insert content (any HTML) above the list of comments.</span>
				        </td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row">&hellip; get setup support</th>
				        <td>
							<span>I help you to choose the correct selectors.</span>
				        </td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row">&hellip; request features</th>
				        <td>
							<span>I'm going to develop your feature request with priority (but no guarantee).</span>
				        </td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row">&hellip; enjoy coming features<br><span class="description thin">with free lifetime updates!</span></th>
				        <td>
							<span>No matter what comes next: Once you've bought premium, you're going to get every new feature for free. What do you think of social logins (Twitter, Facebook) or Inline Comments for Editors?</span>
				        </td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row"><a href="https://sellfy.com/p/uzBe/" id="uzBe" class="sellfy-buy-button">buy</a><script type="text/javascript" src="https://sellfy.com/js/api_buttons.js"></script></th>
				        <td>
							<span>Buy premium to get additional features, honour my month-long work and push development. The price might change/increase over time.</span>
							<br><strong>Immediate download after purchase.</strong>
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