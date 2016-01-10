<?php
/**
 * @package Admin
 */
class Incom_Meta {
    private $select_name = 'incom_status';

	function __construct() {
		$this->init_meta_boxes();
	}

	/**
	 * Add additonal fields to the page where you create your posts and pages
	 * (Based on http://wp.tutsplus.com/tutorials/plugins/how-to-create-custom-wordpress-writemeta-boxes/)
	 */
	function init_meta_boxes() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	function add_meta_box() {
		$screens = array( 'post', 'page' );

		foreach ( $screens as $screen ) {
			add_meta_box(
				'meta-box-incom',
				__( 'Inline Comments', INCOM_TD ),
				array( $this, 'meta_box' ),
				$screen,
				'side',	// Position
				'high'	// Priority
			);
		}
	}

	function meta_box( $post ) {
		$post_id = $post->ID;
		$values = get_post_custom( $post_id );
		
		$select_name = $this->select_name;
        $selected = isset( $values[$select_name] ) ? esc_attr( $values[$select_name][0] ) : '';
        
//		 wp_nonce_field( 'add_incom_meta_box_nonce', INCOM_OPTION_KEY.'_meta_box_nonce' );
		?>

        <p>
            <label for="<?php echo $select_name; ?>">
                <?php
                        printf( __( 'Use Inline Comments on this %s?', INCOM_TD ),
                            get_current_screen()->post_type
                        );
                    ?>
            </label>
        </p>
        <p>
            <select class="select" type="select" name="<?php echo $select_name; ?>" id="<?php echo $select_name; ?>">
                <?php $meta_element_class = get_post_meta($post_id, $select_name, true);	?>
                    <option value="default" <?php selected( $meta_element_class, 'default' ); ?>>
                        <?php esc_html_e( 'Default', INCOM_TD ); ?>
                    </option>
                    <option value="on" <?php selected( $meta_element_class, 'on' ); ?>>
                        <?php esc_html_e( 'On', INCOM_TD ); ?>
                    </option>
                    <option value="off" <?php selected( $meta_element_class, 'off' ); ?>>
                        <?php esc_html_e( 'Off', INCOM_TD ); ?>
                    </option>
            </select>
        </p>
        <?php
        if (!comments_open($post_id)) {
            echo '<p>';
            printf( __( 'ATTENTION! Looks like comments are not allowed for this %s. Make sure that comments are allowed if you want to use Inline Comments.', INCOM_TD ),
                get_current_screen()->post_type
            );
            echo '</p>';
        }
        
        do_action( INCOM_OPTION_KEY.'_meta_box_after', $post_id );
    }

	function save( $post_id ) {

		// Bail if we're doing an auto save
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		
		// // If our nonce isn't there, or we can't verify it, bail
		// if ( 
		// 	!empty( $_POST ) &&
		// 	(
		// 		!isset( $_POST[INCOM_OPTION_KEY.'_meta_box_nonce'] )
		// 		|| !wp_verify_nonce( $_POST[INCOM_OPTION_KEY.'_meta_box_nonce'], 'add_incom_meta_box_nonce' ) 
		// 	)
		// ) {
		// 	print 'Sorry, your nonce did not verify.';
		// 	exit;
		// } else {

			// SELECT
			$select_name = $this->select_name;

			if( isset( $_POST[$select_name] ) )
				update_post_meta( $post_id, $select_name, esc_attr( $_POST[$select_name] ) );

			do_action( INCOM_OPTION_KEY.'_save_post', $post_id );

		// }

	}
}


function initialize_incom_meta() {
    new Incom_Meta();
}
add_action( 'admin_init', 'initialize_incom_meta' );