<?php
class INCOM_Comments {

	private $loadPluginInfoHref = 'http://kevinw.de/inline-comments';
	private $loadPluginInfoTitle = 'Inline-Comments by Kevin Weber';
	private $loadCancelLinkText = 'Cancel';
	private $DataIncomValue = NULL;
	private $DataIncomKey = 'data_incom';
	private $DataIncomKeyPOST = 'data_incom';

	function __construct() {
		add_action ( 'comment_post', array( $this, 'add_comment_meta_data_incom' ) );
		add_action( 'preprocess_comment' , array( $this, 'preprocess_comment_handler' ) );
		add_action( 'wp_footer', array( $this, 'generateCommentsAndForm' ) );
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
		echo '<div id="comments-and-form" style="display:none">';

		$this->loadPluginInfo();
		$this->loadCommentsList();
		$this->loadCommentForm();
		$this->loadCancelLink();

		echo '</div>';
	}

	/**
	 * Generate list with comments
	 */
	private function loadCommentsList() {
		$args = array(
			'post_id' => get_the_ID(),
			'type' => 'comment',
			'callback' => array( $this, 'loadComment' ),
			'avatar_size' => '0',
		);
		wp_list_comments( $args );
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
		
		<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>" data-incom-comment="<?php echo $data_incom; ?>" style="display:none">
		<?php if ( 'div' != $args['style'] ) : ?>

		<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		
		<?php endif; ?>
		<div class="comment-author vcard">
			<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			<?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>
		</div>
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata">
			<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time() ); ?>
			</a>
		</div>

		<?php comment_text(); ?>

		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
	<?php
	}

	/**
	 * Load comment form
	 */
	private function loadCommentForm() {
		$user = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';

		comment_form(array(
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
			    ) . '</p>'
			)
		);
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
	 * Load plugin info
	 */
	private function loadPluginInfo() {
		echo '<a class="incom-info" href="' . $this->loadPluginInfoHref . '" title="' . $this->loadPluginInfoTitle . '" target="_blank">(i)</a>';
	}

	/**
	 * Load cancel link (remove wrapper when user clicks on that link)
	 */
	private function loadCancelLink() {
		echo '<a class="incom-cancel incom-cancel-link" href title>' . $this->loadCancelLinkText . '</a>';
	}

}

function initialize_incom_comments() {
	$incom_comments = new INCOM_Comments();
}
add_action( 'init', 'initialize_incom_comments' );