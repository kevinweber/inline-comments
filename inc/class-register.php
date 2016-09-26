<?php
/**
 * register_activation_hook() and register_deactivation_hook() MUST NOT be called with action 'plugins_loaded' or any 'admin_init'
 * @package Admin
 */

register_activation_hook( INCOM_FILE, 'incom_plugin_activation' );
register_deactivation_hook( INCOM_FILE, 'incom_plugin_deactivation' );
add_action( 'init', 'allow_ksas_data' );

function incom_plugin_activation() {
	$signup = '';
	if ( INCOM_ESSENTIAL ) {
		$signup = '<div id="mc_embed_signup">
				<form action="http://kevinw.us2.list-manage.com/subscribe/post?u=f65d804ad274b9c8812b59b4d&amp;id=20c3ab10d8" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					<div class="mc-field-group">
						<label for="mce-EMAIL" style="line-height:2.5em">'.INCOM_NEWS_TEXT.'</label><br>
						<input type="email" value="'. esc_html__( 'Enter your email address', INCOM_TD ) .'" name="EMAIL" class="required email" id="mce-EMAIL" onclick="this.focus();this.select()" onfocus="if(this.value == \'\') { this.value = this.defaultValue; }" onblur="if(this.value == \'\') { this.value = this.defaultValue; }">
						<input type="hidden" name="GROUPS" id="GROUPS" value="'.INCOM_VERSION_NAME.'" />
						<input type="submit" value="'.INCOM_NEWS_BUTTON.'" name="subscribe" id="mc-embedded-subscribe" class="button">
					</div>
					<div id="mce-responses" class="clear">
						<div class="response" id="mce-error-response" style="display:none"></div>
						<div class="response" id="mce-success-response" style="display:none"></div>
					</div>
				    <div style="position: absolute; left: -5000px;"><input type="text" name="b_f65d804ad274b9c8812b59b4d_20c3ab10d8" tabindex="-1" value=""></div>
				</form>
				</div>';
	}

	$notices = get_option( 'incom_deferred_admin_notices', array() );
	$notices[] = $signup . '<br>'.esc_html__( 'Edit your plugin settings: ', INCOM_TD ).'<strong>
					<a href="options-general.php?page=incom.php">'.esc_html__( 'Inline Comments', INCOM_TD ).'</a>
					</strong>';
				;
	update_option( 'incom_deferred_admin_notices', $notices );
}

function incom_plugin_deactivation() {
	delete_option( 'incom_deferred_admin_notices' );
}

/**
 * Register additional HTML attributes for WP KSES
 * Based on https://vip.wordpress.com/documentation/register-additional-html-attributes-for-tinymce-and-wp-kses/
 * @since 2.1.2
 */
function allow_ksas_data() {
    global $allowedposttags;

    $tags = array( 'span' );
    $new_attributes = array( 'data-incom-ref' => array() );

    foreach ( $tags as $tag ) {
        if ( isset( $allowedposttags[ $tag ] ) && is_array( $allowedposttags[ $tag ] ) )
            $allowedposttags[ $tag ] = array_merge( $allowedposttags[ $tag ], $new_attributes );
    }
}

class INCOM_Register {

	function __construct() {
		add_action( 'admin_notices', array( $this, 'incom_plugin_notice_activation' ) );
	}

	/**
	 * Display notification when plugin is activated
	 */
	function incom_plugin_notice_activation() {
	  if ( $notices = get_option( 'incom_deferred_admin_notices' ) ) {
	    foreach ($notices as $notice) {
	      echo "<div class='updated'><p>$notice</p></div>";
	    }
	    delete_option( 'incom_deferred_admin_notices' );
	  }
	}

}

function initialize_incom_register() {
	$incom_admin = new INCOM_Register();
}
add_action( 'init', 'initialize_incom_register' );
