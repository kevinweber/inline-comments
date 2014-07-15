<?php
/**
 * @package Comment System Type: WordPress
 */

	// if ( !defined( 'WPAC_DOMAIN' ) ) {
	// 	define( 'WPAC_DOMAIN', 'wpac' );
	// }
	// if ( !defined( 'WPAC_OPTION_KEY' ) ) {
	// 	define( 'WPAC_OPTION_KEY', WPAC_DOMAIN ); // used to save options in version >= 0.9.0
	// }

	/*
	 * Customise WP Ajaxify Comments
	 */
	add_filter('option_wpac', 'filter_options_wpac' );
	//add_filter('option_'.WPAC_OPTION_KEY, 'filter_options_wpac' );

	function filter_options_wpac($wpacOptions) {
		$wpacOptions = is_array($wpacOptions) ? $wpacOptions : array();

		// Filter Values
		$wpacOptions['enable'] = true;
		$wpacOptions['disableScrollToAnchor'] = true;

		$wpacOptions['selectorCommentForm'] = '#incom-commentform';
		$wpacOptions['selectorCommentsContainer'] = '#comments-and-form';
		$wpacOptions['selectorCommentPagingLinks'] = '#incom-commentform [class^="nav-"] a';
		$wpacOptions['selectorCommentLinks'] = '#incom-commentform a[href*="/comment-page-"]';
	
		// Filter Callbacks
		$wpacOptions['callbackOnBeforeUpdateComments'] = 'var newCommentsContainer = jQuery("body").find("#comments-and-form");';
		$wpacOptions['callbackOnAfterUpdateComments'] = '

			// Variables from Inline Comments JS file
			  var idCommentsAndForm = "comments-and-form";
			    var idCommentsAndFormHash = "#"+idCommentsAndForm;
			  var attDataIncom = "data-incom";
			    var attDataIncomComment = attDataIncom+"-comment";
			  var classActive = "incom-active";
			    var classActiveDot = "."+classActive;
			  var dataIncomKey = "data_incom";  // Should be the same as $DataIncomKey in class-comments.php

			// Display the container that contains all comments
			jQuery("#comments-and-form").show();

			// Show the newly submitted comment
			var getIdNewComment = commentUrl.indexOf("#") >= 0 ? commentUrl.substr(commentUrl.indexOf("#")) : null;
			var idNewComment = jQuery( getIdNewComment );
			idNewComment.show();

			// Display all comments with the same attDataIncomComment (because they are assigned to the same section)
			var attDataIncomComment = \'data-incom-comment\';
			var attFromSource = idNewComment.attr( attDataIncomComment );
			var selectByAtt = \'[\' + attDataIncomComment + \'=\' + attFromSource + \']\';
			jQuery( selectByAtt ).show();

			// Add a hidden input field in order to assign a comment to a specific section when he is submitted
			var $attDataIncomValue = jQuery( classActiveDot ).attr( attDataIncom );
		    var input = jQuery( \'<input>\' )
			  .attr( \'type\', \'hidden\' )
			  .attr( \'name\', dataIncomKey ).val( $attDataIncomValue );
			jQuery( idCommentsAndFormHash + \' .form-submit\' ).append( jQuery( input ) );

		';

	   return $wpacOptions;
	}