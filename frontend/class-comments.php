<?php
class INCOM_Comments {

	private $loadPluginInfoHref = 'http://kevinw.de/inline-comments';
	private $loadPluginInfoTitle = 'Inline-Comments by Kevin Weber';

	function __construct() {
		add_action ( 'comment_post', array( $this, 'add_comment_meta_data_incom' ) );
		add_action( 'wp_footer', array( $this, 'generateCommentsAndForm' ) );
	}

	// /*
	//  * Get PHP code. Can be decoded in JS file with JSON.parse(@comments_php)
	//  */
	// function getCode() {
	// 	$items = $this->generateCode();

	//     $str = serialize($items);
	//     $comments_php = json_encode( unserialize( $str) );
	// 	return $comments_php;
	// }

	// private function generateCode() {
	// 	$code = array();

	// 	$postId = 'post_id=' . get_the_ID();
	// 	$comments = get_comments( $postId );

	// 	foreach($comments as $comment) :
	// 		$code[] = '<p>' . $comment->comment_content . '</p>';
	// 	endforeach;

	// 	return $code;
	// }

	function generateCommentsAndForm() {
		echo '<div id="comments-and-form">';

		$this->loadPluginInfo();
		$this->loadCommentsList();
		$this->loadCommentForm();
		$this->loadCancelLink();

		echo '</div>';
	}

	private function loadCommentsList() {
		$args = array(
			'post_id' => get_the_ID()
		);

		$comments = get_comments( $args );

		foreach($comments as $comment) :
			$data_incom = get_comment_meta( $comment->comment_ID, 'data_incom', true );
			echo '<p data-incom-comment="' . $data_incom . '">' . $comment->comment_content . '</p>';
		endforeach;
	}

	private function loadCommentForm() {
		$user = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';

		comment_form(array(
			// 'id_form' => '',
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

	function add_comment_meta_data_incom( $comment_id ) {
		add_comment_meta($comment_id, 'data_incom', $this->getValueDataIncom(), true);
	}

	private function getValueDataIncom() {
		return 'P4';
	}

	private function loadPluginInfo() {
		echo '<a class="incom-info" href="' . $this->loadPluginInfoHref . '" title="' . $this->loadPluginInfoTitle . '" target="_blank">(i)</a>';
	}

	private function loadCancelLink() {
		echo '<a class="incom-cancel incom-cancel-link" href title>Cancel</a>';
	}

}

function initialize_incom_comments() {
	$incom_comments = new INCOM_Comments();
}
add_action( 'init', 'initialize_incom_comments' );