<?php
/**
 * @package Frontend
 */
class INCOM_Frontend {
    private static $status_body_class = 'inline-comments';

    function init() {
        if (!is_admin() && $this->test_if_status_is_off()) {
            self::$status_body_class = 'inline-comments-off';
            add_filter( 'body_class' , array( $this, 'body_class' ) );
            return;
        }

		add_filter( 'body_class' , array( $this, 'body_class' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_jquery' ) );
        require_once( INCOM_PATH . 'frontend/class-wp.php' );
        new INCOM_WordPress();

    }

	/**
	 * Add class to <body> that identifies the usage of this plugin
	 * @since 2.1
	 */
	function body_class( $classes ) {
		$classes[] = self::$status_body_class;
		return $classes;
	}

	/**
 	 * Enable jQuery (comes with WordPress)
 	 */
 	function enqueue_jquery() {
     	wp_enqueue_script( 'jquery' );
 	}

	/**
	 * Handle avatar size
	 */
	protected function get_avatar_size() {
		if ( get_option( 'incom_avatars_display' ) != 1 )
			return '0';

		$input = get_option( 'incom_avatars_size' );
		if ( (int) $input > 0 ) {
			return $input;
		}
		else {
			return '15';
		}
	}

	/**
	 * Determine if user is allowed to comment.
	 * Logged in users are always allowed to comment.
 	 * @since 2.2.3
	 */
	protected function can_comment() {
		return comments_open() && (!get_option('comment_registration') || is_user_logged_in());
	}

 	/**
 	 * Test if status is "off" for specific post/page
 	 */
 	function test_if_status_is_off() {
		global $post;
		$result = true;

    if (!isset($post->ID)) {
			$post_id = null;
		}
		else {
			$post_id = $post->ID;
		}

		// When the individual status for a page/post is 'off', all the other setting don't matter. Therefore, this has to be tested next.
		if (get_post_meta( $post_id, INCOM_OPTION_KEY.'_status', true ) &&
                get_post_meta( $post_id, INCOM_OPTION_KEY.'_status', true ) === 'off') {
			$result = true;
		} else if (!get_option(INCOM_OPTION_KEY.'_status_default') ||   // Load when no option is defined yet
                get_post_meta( $post_id, INCOM_OPTION_KEY.'_status', true ) === 'on' && is_singular() ||
                get_option(INCOM_OPTION_KEY.'_status_default') === 'on' ||
                get_option(INCOM_OPTION_KEY.'_status_default') === 'on_posts' && is_single() ||
                get_option(INCOM_OPTION_KEY.'_status_default') === 'on_pages' && is_page() ||
                get_option(INCOM_OPTION_KEY.'_status_default') === 'on_posts_pages' && (is_single()||is_page()) ||
                get_option(INCOM_OPTION_KEY.'_status_default') === 'on_posts_pages_custom' &&
                        (is_single()||is_page()||get_post_types(array( 'public' => true, '_builtin' => false )))) {
			$result = false;
		}

		$result = apply_filters( INCOM_OPTION_KEY.'_test_if_status_is_off', $result );
		return $result;
 	}
}

function initialize_incom_frontend() {
    $frontend = new INCOM_Frontend();
    $frontend->init();
}
add_action( 'wp', 'initialize_incom_frontend' );



function initialize_incom_comment_submission() {
  require_once( INCOM_PATH . 'frontend/class-comments.php' );
  new INCOM_Comments();
}
add_action( 'init', 'initialize_incom_comment_submission' );
