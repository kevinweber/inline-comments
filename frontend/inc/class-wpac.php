<?php
/**
 * @package Comment System Type: WordPress
 */

	/*
	 * Customise WP Ajaxify Comments
	 */
	add_filter('option_wpac', 'filter_options_wpac' );

	function filter_options_wpac($wpacOptions) {
		$wpacOptions = is_array($wpacOptions) ? $wpacOptions : array();

		// Filter Values
		$wpacOptions['enable'] = true;
		// $wpacOptions['disableScrollToAnchor'] = true;

		$wpacOptions['selectorCommentForm'] = '#incom-commentform';
		$wpacOptions['selectorCommentsContainer'] = '#comments-and-form';
		//$wpacOptions['selectorRespondContainer'] = '#comments-and-form';
		$wpacOptions['selectorCommentPagingLinks'] = '#incom-commentform [class^="nav-"] a';
		$wpacOptions['selectorCommentLinks'] = '#incom-commentform a[href*="/comment-page-"]';
	
		// Filter Callbacks
		
		// @TODO//TESTING for Danny
		// $wpacOptions['callbackOnBeforeSelectElements'] = "var e = jQuery('#comments, #comments ~ *',dom); if (e.length==0) e = jQuery('#comments-and-form', dom); e.wrapAll('<div id=\"comments-and-form\" />');";
	//	$wpacOptions['callbackOnBeforeSelectElements'] = "var e = jQuery('#comments, #comments ~ *',dom); if (e.length==0) e = jQuery('#respond', dom); e.wrapAll('<div id=\"comments-and-form\" />');";

		
		$wpacOptions['callbackOnBeforeUpdateComments'] = 'var newCommentsContainer = jQuery("body").find("'.$wpacOptions['selectorCommentsContainer'].'");';
		$wpacOptions['callbackOnAfterUpdateComments'] = '

			// Variables from Inline Comments JS file
			  var idCommentsAndForm = "comments-and-form";
			    var idCommentsAndFormHash = "#"+idCommentsAndForm;
			  var attDataIncom = "data-incom";
			    var attDataIncomComment = attDataIncom+"-comment";
			  var classActive = "incom-active";
			    var classActiveDot = "."+classActive;
			  var dataIncomKey = "data_incom";  // Should be the same as $DataIncomKey in class-comments.php

			//// Lets display all comments that are assigned to the specific element/paragraph
			// Step 1: Display the container that contains all comments
			jQuery("#comments-and-form").show();

			// Step 2: Extract the newly submitted comment\'s ID from the URL
			var getIdNewComment = commentUrl.indexOf("#") >= 0 ? commentUrl.substr(commentUrl.indexOf("#")) : null;
			var idNewComment = jQuery( getIdNewComment );

			// Step 3: Define the attribute that is needed for the next steps
			var attDataIncomComment = \'data-incom-comment\';
			var attFromSource = idNewComment.attr( attDataIncomComment );

			// Step 4: This test is needed to make replies to parent comments work 
			if ( attFromSource === "" )  {
				attFromSource = idNewComment.parents(".depth-1").attr( attDataIncomComment );
			}

			// Step 5: Display all comments with the same attDataIncomComment (because they are assigned to the same section) and all their children
			var selectByAtt = \'[\' + attDataIncomComment + \'=\' + attFromSource + \']\';
			jQuery( selectByAtt + \', \' + selectByAtt + \' .children li\' ).show();

			// Add class that indicates the newest submitted comment
			idNewComment.addClass("incom-comment-newest");

			// Add a hidden input field in order to assign a comment to a specific section when he is submitted
			var $attDataIncomValue = jQuery( classActiveDot ).attr( attDataIncom );
		    var input = jQuery( \'<input>\' )
			  .attr( \'type\', \'hidden\' )
			  .attr( \'name\', dataIncomKey ).val( $attDataIncomValue );
			jQuery( idCommentsAndFormHash + \' .form-submit\' ).append( jQuery( input ) );

			// Update count of bubble
			function isInt(value) {
			  var x;
			  if (isNaN(value)) {
			    return false;
			  }
			  x = parseFloat(value);
			  return (x | 0) === x;
			}

			var bubble = jQuery( ".incom-bubble-active a" );
			if (isInt(bubble.text())) {
				bubble.text( parseInt( bubble.text(), 10 ) + 1 );
			} else {
				bubble.text(1);
			}

			bubble.parent().addClass("incom-bubble-static").css("display","block");
		';

	   return $wpacOptions;
	}