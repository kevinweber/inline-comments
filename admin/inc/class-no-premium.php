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
		add_filter( 'incom_settings_page_tabs_link_after', array( $this, 'add_incom_admin_tab_link' ) );
		add_filter( 'incom_settings_page_tabs_after', array( $this, 'add_incom_admin_tab' ) );
	}

	function add_incom_admin_tab_link() {
		echo '<li><a href="#premium" class="tab-orange tab-premium">Premium</a></li>';
	}
	function add_incom_admin_tab() { ?>
		<div id="premium">

			<h3><?php esc_html_e( 'Premium Extension', INCOM_TD ); ?></h3>

			<p><?php esc_html_e( 'Right now, every feature for Inline Comments is available FOR FREE, except for the "Remove branding" option. This is what you get when you buy premium:', INCOM_TD ); ?></p>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th>It's pretty simple:</th>
						<td>
							<p><?php esc_html_e( 'I offer nearly every feature of Inline Comments for free. So you can ensure that everything works fine on your site before you grab this slick extension.', INCOM_TD ); ?></p>
							<p><?php esc_html_e( 'This extension removes the subtle "i" (information link) that is placed in the top right of every comment wrapper. That\'s it.', INCOM_TD ); ?></p>
							<p style="color:#999;"><i><?php esc_html_e( 'Using this link I assure that the plugin gets spread. And everyone who doesn\'t want the branding pays a very little compensation for my time-consuming efforts.', INCOM_TD ); ?></i></p>
						</td>
					</tr>
			        <tr valign="top">
			        	<th scope="row"><?php esc_html_e( 'Remove branding', INCOM_TD ); ?></th>
				        <td>
							<span><?php esc_html_e( 'The premium extension automatically removes the subtle branding link.', INCOM_TD ); ?></span>
				        </td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row"><?php esc_html_e( 'Lifetime updates', INCOM_TD ); ?><br><span class="description thin"><?php esc_html_e( 'Enjoy all coming features!', INCOM_TD ); ?></span></th>
				        <td>
							<span><?php esc_html_e( 'No matter what comes next: Once you\'ve bought premium, you\'re going to get every new feature for free.', INCOM_TD ); ?></span>
				        </td>
			        </tr>
			        <tr valign="top">
			        	<th scope="row"><a href="https://sellfy.com/p/uzBe/" id="uzBe" class="sellfy-buy-button">buy</a><script type="text/javascript" src="https://sellfy.com/js/api_buttons.js"></script></th>
				        <td>
							<span><?php esc_html_e( 'Buy premium to get additional features, honour my month-long work and push development. The price might change/increase over time.', INCOM_TD ); ?></span>
							<br><strong><?php esc_html_e( 'Immediate download after purchase.', INCOM_TD ); ?></strong>
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