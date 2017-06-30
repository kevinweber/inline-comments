<?php
class INCOM_Comments extends INCOM_Frontend {

	private $loadCancelLinkText = 'Cancel';
	private $DataIncomValue = NULL;
	private $DataIncomKey = 'data_incom';
	private $DataIncomKeyPOST = 'data_incom';

	function __construct() {
		add_filter( 'get_comment_text' , array( $this, 'comment_text' ), 10, 2 );
		add_filter( 'comment_form_default_fields', array( $this, 'comment_form_fields' ) );
		add_action( 'comment_post', array( $this, 'add_comment_meta_data_incom' ) );
		add_action( 'preprocess_comment' , array( $this, 'preprocess_comment_handler' ) );
		add_action( 'wp_footer', array( $this, 'generateCommentsAndForm' ) );
	}

	/**
	 * Filter comment_text
	 * @since 2.1
	 */
	function comment_text( $comment_text, $comment ) {
		if ( isset($comment) && ( get_option(INCOM_OPTION_KEY.'_references') != "nowhere" ) ) {
			$comment_text = $this->comment_text_reference( $comment_text, $comment );
		}
		return $comment_text;
	}

	/**
	 * Add reference to referenced paragraph/element
	 * @since 2.1
	 */
	private function comment_text_reference( $comment_text, $comment ) {
		if ( $this->DataIncomKey != '' ) {
			$data_incom = get_comment_meta( $comment->comment_ID, $this->DataIncomKey, true );

			if ( $data_incom != '' ) {	// Only display reference when comment actually references on a paragraph/element
				$jump_to_text = esc_html__( 'Reference', INCOM_TD );
				$jump_to = "<span class='incom-ref-link' data-incom-ref='$data_incom'>$jump_to_text</span>";
				$comment_text .= "<span class='incom-ref'>$jump_to</span>";
			}
		}

		return $comment_text;
	}

	/**
	 * Set $DataIncomValue
	 */
	private function setValueDataIncom() {
		if ( isset( $_POST[ $this->DataIncomKeyPOST ] ) ) {
			$value = sanitize_text_field( $_POST[ $this->DataIncomKeyPOST ] );
		}
		else {
			$value = NULL;
		}
		$this->DataIncomValue = $value;
	}

	/**
	 * Get $DataIncomValue
	 */
	private function getValueDataIncom() {
		return $this->DataIncomValue;
	}

	/**
	 * Generate comments form
	 */
	function generateCommentsAndForm() {
		echo '<div id="comments-and-form" class="comments-and-form" style="display:none">';

		$this->loadPluginInfoInvisible();

		do_action( 'incom_cancel_x_before' );
		echo wp_kses_post(apply_filters( 'incom_cancel_x', $this->loadCancelX() ));
		do_action( 'incom_cancel_x_after' );

		echo wp_kses_post(apply_filters( 'incom_comments_list_before', $this->comments_list_before() ));

		if (!parent::test_if_status_is_off()) {
			$this->loadCommentsList();
		}

		if (parent::can_comment()) {
			$this->loadCommentForm();

			do_action( 'incom_cancel_link_before' );
			echo wp_kses_post(apply_filters( 'incom_cancel_link', $this->loadCancelLink() ));
			do_action( 'incom_cancel_link_after' );
		}

		echo '</div>';
	}

	/**
	 * Display invisible plugin info
	 */
	private function loadPluginInfoInvisible() {
		echo '<!-- ## Inline Comments by Kevin Weber - kevinw.de/inline-comments ## -->';
	}

	/**
	 * Generate list with comments
	 */
	private function loadCommentsList() {
		$args = array(
			'post_id' => get_the_ID(),
			'type' => 'comment',
			'callback' => array( $this, 'loadComment' ),
			'avatar_size' => parent::get_avatar_size(),
		);
		wp_list_comments( apply_filters( 'incom_comments_list_args', $args ) );
	}

	/**
	 * Generate a single comment
	 */
	function loadComment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
		$data_incom = get_comment_meta( $comment->comment_ID, $this->DataIncomKey, true );
		?>

		<<?php echo $tag; /* XSS ok */ ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>" data-incom-comment="<?php echo esc_attr($data_incom); ?>" style="display:none">
		<?php if ( 'div' != $args['style'] ) : ?>

		<div id="incom-div-comment-<?php comment_ID() ?>" class="incom-div-comment comment-body">

		<?php
			endif;

			if ( (get_option(INCOM_OPTION_KEY."_comment_permalink") == "1") ) {
				echo wp_kses_post(apply_filters( 'incom_comment_permalink', $this->loadCommentPermalink( $comment->comment_ID ) ));
			}
		?>

		<div class="comment-author vcard">
			<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			<?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>
		</div>
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
			<br />
		<?php endif; ?>

		<?php comment_text(); ?>

		<?php if ( get_option( 'incom_reply' ) == '1' ) { ?>
			<div class="incom-reply">
			<?php
				comment_reply_link( array_merge(
						$args,
						array(
							'add_below' => 'incom-div-comment',
							// 'respond_id' => 'incom-commentform',
							// TODO: 'reply_text' => 'insert icon here',
							'depth' => $depth,
							'max_depth' => $args['max_depth'],
							'login_text' => '',
							'reply_title_id' => 'incom-reply-title',
						)
					)
				);
			?>
			</div>
		<?php } ?>

		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
	<?php
	}

	/**
	 * Load comment form
	 */
	function loadCommentForm() {
		$user = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';

		$args = array(
			'id_form' => 'incom-commentform',
			'comment_form_before' => '',
			'comment_notes_before' => '',
			'comment_notes_after' => '',
			'title_reply' => '',
			'title_reply_to' => '',
			'logged_in_as' => '<p class="logged-in-as">' .
			    sprintf(
			    __( 'Logged in as <a href="%1$s">%2$s</a>.' ),
			      admin_url( 'profile.php' ),
			      $user_identity
			    ) . '</p>',
			'user_identity' => $user_identity,
		);

		comment_form( apply_filters( 'incom_comment_form_args', $args ) );
	}

	/**
	 * Template for comment form fields
	 * @since 1.3
	 */
	function comment_form_fields() {
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );

		$fields =  array(
		  'author' =>
		    '<p class="comment-form-author"><label for="author">' . esc_html__( 'Name', INCOM_TD ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		    '" size="30"' . $aria_req . ' /></p>',

		  'email' =>
		    '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', INCOM_TD ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		    '" size="30"' . $aria_req . ' /></p>',
		);

		if ( get_option( 'incom_field_url' ) !== '1' ) {
			$fields_url = array(
			  'url' =>
			    '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', INCOM_TD ) . '</label>' .
			    '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
			    '" size="30" /></p>',
			);
			$fields = array_merge( $fields, $fields_url );
		}

		return $fields;
	}

	/**
	 * Add comment meta field to comment form
	 */
	function add_comment_meta_data_incom( $comment_id ) {
		$DataIncomValue = $this->getValueDataIncom();
		if ( $DataIncomValue !== NULL ) {
			add_comment_meta( $comment_id, $this->DataIncomKey, $DataIncomValue, true );
		}
	}

	/**
	 * This function will be executed immediately before a comment will be stored into database
	 */
	function preprocess_comment_handler( $commentdata ) {
		$this->setValueDataIncom();
		$commentdata[ $this->DataIncomKey ] = $this->DataIncomValue;

		return $commentdata;
	}

	/**
	 * Load permalink to comment
	 */
	private function loadCommentPermalink( $comment_ID ) {
		$permalink_url = htmlspecialchars( get_comment_link( $comment_ID ) );
		$permalink_img_url = plugins_url( 'images/permalink-icon.png' , INCOM_FILE );
		$permalink_html = '<div class="comment-meta commentmetadata">
			<a class="incom-permalink" href="' . $permalink_url . '" title="Permalink to this comment">
				<img class="incom-permalink-img" src="' . $permalink_img_url . '" alt="">
			</a>
		</div>';
		return $permalink_html;
	}

	/*
	 * Load cancel cross (remove wrapper when user clicks on that cross)
	 */
	private function loadCancelX() {
		if ( get_option( 'cancel_x' ) !== '1' ) {
			return '<a class="incom-cancel incom-cancel-x" href title="'. esc_html__($this->loadCancelLinkText, INCOM_TD ) . '">&#10006;</a>';
		}
	}

	/**
	 * Load cancel link (remove wrapper when user clicks on that link)
	 */
	private function loadCancelLink() {
		if ( get_option( 'cancel_link' ) !== '1' ) {
			return '<a class="incom-cancel incom-cancel-link" href title>' . esc_html__($this->loadCancelLinkText, INCOM_TD ) . '</a>';
		}
	}

	/**
	 * Add content before comment list
	 */
	function comments_list_before() {
		if ( get_option( 'incom_content_comments_before' ) != '' ) {
			return get_option( 'incom_content_comments_before' );
		}
	}

	/**
	 * Customise comment form
	 */
	// function comment_form_args( $args ) {
	// 	$args['comment_notes_after'] = '';
	// 	return $args;
	// }

}
