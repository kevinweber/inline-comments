<?php
class INCOM_Comments {

	function __construct() {
		add_action('wp_footer', array( $this, 'generateCommentForm') );
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

	function generateCommentForm() {
		echo '<div id="incom_commentform">';
		//TODO: incom-DESIGN + invisible ++ mit .detach() das Commentform entfernen und später wieder einfügen
		comment_form(array(
			//'id_form' => '',
			'comment_form_before' => '',
			'comment_notes_after' => '',
			'title_reply'       => '',
			'title_reply_to'    => ''
			)
		);
		echo '</div>';	//<!--#incom_commentform-->
	}

}

function initialize_incom_comments() {
	$incom_comments = new INCOM_Comments();
}
add_action( 'init', 'initialize_incom_comments' );