<?php
class INCOM_Comments {

	/*
	 * Get PHP code. Can be decoded in JS file with JSON.parse(@comments_php)
	 */
	function getCode() {
		$items = $this->generateCode();

	    $str = serialize($items);
	    $comments_php = json_encode( unserialize( $str) );
		return $comments_php;
	}

	private function generateCode() {
		$code = array();

		$postId = 'post_id=' . get_the_ID();
		$comments = get_comments( $postId );

		foreach($comments as $comment) :
			$code[] = '<p>' . $comment->comment_content . '</p>';
		endforeach;

		return $code;
	}

}

function initialize_incom_comments() {
	$incom_comments = new INCOM_Comments();
}
add_action( 'init', 'initialize_incom_comments' );