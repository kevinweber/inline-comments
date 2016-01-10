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
            INCOM_OPTION_KEY.'_status_default',
			'multiselector',
			INCOM_OPTION_KEY.'_support_for_ajaxify_comments',
			INCOM_OPTION_KEY.'_reply',
			'moveselector',
			INCOM_OPTION_KEY.'_attribute',
			
			// Styling
			'custom_css',
			INCOM_OPTION_KEY.'_select_align',
			INCOM_OPTION_KEY.'_avatars_display',
			INCOM_OPTION_KEY.'_avatars_size',
			'select_bubble_style',
			'set_bgcolour',
			INCOM_OPTION_KEY.'_set_bgopacity',
			INCOM_OPTION_KEY.'_bubble_static',

			// Advanced
			INCOM_OPTION_KEY.'_content_comments_before',
			'select_bubble_fadein',
			'select_bubble_fadeout',
			'cancel_x',
			'cancel_link',
			INCOM_OPTION_KEY.'_field_url',
			INCOM_OPTION_KEY.'_comment_permalink',
			INCOM_OPTION_KEY.'_references',
			INCOM_OPTION_KEY.'_bubble_static_always',
		);
		foreach ( $arr as $i ) {
			register_setting( 'incom-settings-group', $i );
		}
		do_action( 'register_incom_settings_after' );
	}

	function incom_settings_page()	{
      require_once( INCOM_PATH . 'admin/admin-options.php' );
	}

	function incom_admin_js() {
		if ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) {
			wp_enqueue_script( 'lazyload_admin_js', INCOM_URL . 'js/admin.js', array('jquery', 'jquery-ui-tabs', 'wp-color-picker' ), INCOM_VERSION );
		} else {
			wp_enqueue_script( 'lazyload_admin_js', INCOM_URL . 'js/min/admin.min.js', array('jquery', 'jquery-ui-tabs', 'wp-color-picker' ), INCOM_VERSION );
		}
	}

	function incom_admin_css() {
		wp_enqueue_style( 'incom_admin_css', plugins_url('../css/min/admin.css', __FILE__) );
		wp_enqueue_style( 'wp-color-picker' );	// Required for colour picker
	}
}

function initialize_incom_admin_options() {
	new INCOM_Admin_Options();
}
add_action('init', 'initialize_incom_admin_options');
