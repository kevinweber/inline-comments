<?php
class INCOM_Comments {

	function __construct() {
		$this->getCode();
	}

	function getCode() {
		$items = array();
		$comments = get_comments('post_id=135'); // TODO: No static ID (-'135'-)

		foreach($comments as $comment) :
				$items[] = '<p>' . $comment->comment_content . '</p>';
		endforeach;

		return $items;
	}
}

function initialize_incom_comments() {
	$incom_comments = new INCOM_Comments();
}
add_action( 'init', 'initialize_incom_comments' );