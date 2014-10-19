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

			<h3>Premium Extension</h3>

			<p>Right now, every feature for Inline Comments is available FOR FREE, except for the "Remove branding" option. This is what you get when you buy premium:</p>

			<table class="form-table">
				<tbody>
			        <tr valign="top">
			        	<th scope="row">Remove branding</th>
				        <td>
							<span>The premium extension automatically removes the subtle branding link.</span>
				        </td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row">Get setup support</th>
				        <td>
							<span>I help you to choose the correct selectors.</span>
				        </td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row">Lifetime updates<br><span class="description thin">Enjoy all coming features!</span></th>
				        <td>
							<span>No matter what comes next: Once you've bought premium, you're going to get every new feature for free. What do you think of social logins (Twitter, Facebook) or Inline Comments for Editors?</span>
				        </td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row">Push development</th>
				        <td>
							<span>This plugin does not anywhere near compensate my month-long time efforts financially. WordPress development is a hobby of mine and allows me to experiment. With your purchase, you sponsor me to spend at least a bit more time to enhance Inline Comments.</span>
				        </td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row">Request features</th>
				        <td>
							<span>I'm going to develop your feature request with priority (but no guarantee).</span>
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