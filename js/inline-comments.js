/*
 * Inline Comments
 * by Kevin Weber
 */

(function( incom, $, undefined ) {

  var o;
  
  // IDs
  var idWrapper = 'incom_wrapper';
    var idWrapperHash = '#'+idWrapper;
  var idCommentsAndForm = 'comments-and-form';
    var idCommentsAndFormHash = '#'+idCommentsAndForm;

  // Attributes
  var attDataIncom = 'data-incom';
    var attDataIncomComment = attDataIncom+'-comment';

  // Classes
  var classActive = 'incom-active';
    var classActiveDot = '.'+classActive;
  var classPosition = 'incom-position-';  // Expects that o.position follows ('left' or 'right')
  var classBubble = 'incom-bubble';
    var classBubbleDot = '.'+classBubble;
    var classBubbleStyle = classBubble+'-style';
    var classBubbleStatic = classBubble+'-static';
    var classBubbleActive = classBubble+'-active';  // Class for currently selected bubble
    var classBubbleLink = classBubble+'-link';
  var classCommentsWrapper = 'incom-comments-wrapper';
    var classCommentsWrapperDot = '.'+classCommentsWrapper;
  var classCancel = 'incom-cancel'; // When a user clicks on an element with this class, the comments wrapper will be removed
    var classCancelDot = '.'+classCancel;

  // Other
  var selectComment = idCommentsAndFormHash+' .comment';
  var dataIncomKey = 'data_incom';  // Should be the same as $DataIncomKey in class-comments.php
  var slideWidth = 100;  // Shift page content ('body') to the left



  /*
   * Public methods
   */



  incom.init = function( options ) {
    setOptions( options );
    initIncomWrapper();
  };



  /*
   * Private methods
   */



  var setOptions = function( options ) {
    // 'options' overrides these defaults
    o = $.extend( {
        selectors: 'p',
        countStatic: true,
        defaultBubbleText: '+',
        // highlighted: false,
        position: 'left',
        background: 'white',
      },
    options);
  };


  /* 
   * This wrapper contains comment bubbles
   */
  var initIncomWrapper = function() {
    if ( $( idWrapperHash ).length === 0 ) {
      $( '<div id="'+idWrapper+'"></div>' ).appendTo( $( 'body' ) )
        .addClass( classPosition + o.position );
    }
    
    initSelectElements();
  };


  /* 
   * Select elements and increase counter per element type (instead of using one counter for all elements independent of their types).
   */
  var initSelectElements = function() {
    var selectors = splitSelectors( o.selectors );

    $( selectors ).each( function(j) {

      $( selectors[j] ).each( function(i) {
        var $element = $( this );

        addAtt( i, $element );
        addBubble( $element );
      });

    });
  };

  /*
   * Add attribute attDataIncom to each element
   */
  var addAtt = function( i, element ) {
    // Use the first letter of the element's name as identifier
    var identifier = element.prop('tagName').substr(0,1);

    // If element has no attribute attDataIncom, add it
    if ( !element.attr( attDataIncom ) ) {
      var attProp = identifier + i;
      element.attr( attDataIncom, attProp );
    }
  };

  /*
   * Add bubbles to each element
   */
  var addBubble = function( source ) {
    var bubbleText = addBubbleText( source );
    var bubbleContainer = loadBubbleContainer( source );
    var $bubble = $('<a/>',
        {
          href: '',
          'class': classBubbleLink,
        })
      .text( bubbleText )
      .wrap( bubbleContainer )
      .parent()
      .appendTo( idWrapperHash );

    setDisplayStatic( $bubble );
    setPosition( source, $bubble );
    handleHover( source, $bubble );
    handleClickBubble( source, $bubble );
  };

  /*
   * Get text/number that should be displayed in a bubble
   */
  var addBubbleText = function( source ) {
    var bubbleText;

    if ( testIfCommentsCountLarger0( source ) ) {
      bubbleText = countComments( source );
    }
    else {
      bubbleText = o.defaultBubbleText;
    }

    return bubbleText;
  };

  /*
   * Count the number of comments that are assigned to a specific paragraph
   */
  var countComments = function( source ) {
    // Get attribute value from source's attribute attDataIncom
    var attFromSource = source.attr( attDataIncom );
    // Define selector that identifies elements that shell be counted
    var selectByAtt = '[' + attDataIncomComment + '=' + attFromSource + ']';
    // Count elements
    var $count = $( selectByAtt ).length;

    return $count;
  };

  /*
   * Get container that contains the bubble link
   */
  var loadBubbleContainer = function( source ) {
    var text = '<div class="' + loadBubbleContainerClass( source ) + '" />';
    return text;
  };

  /*
   * Generate class for bubbleContainer
   */
  var loadBubbleContainerClass = function( source ) {
    var containerClass = classBubble;
    var space = ' ';

    if ( ( testIfCommentsCountLarger0( source ) && o.countStatic ) ) {
      containerClass += space + classBubbleStyle + space + classBubbleStatic;
    }
    else if ( testIfCommentsCountLarger0( source ) ) {
      containerClass += space + classBubbleStyle;
    }

    return containerClass;
  };

  /*
   * Test if comments count is larger than 0
   */
  var testIfCommentsCountLarger0 = function( source ) {
    var count = countComments( source );
    return ( $.isNumeric( count ) && count > 0 ) ? true : false;
  };

  var setDisplayStatic = function( bubble ) {
    if ( bubble.hasClass( classBubbleStatic ) ) {
      bubble.css( 'display', 'block' );
    }
  };

  /* 
   * This event will be triggered when user hovers a text element or bubble
   */
  var handleHover = function( element, bubble ) {
    if ( !bubble.hasClass( classBubbleStatic ) ) {
      // Handle hover (for both, "elements" and $bubble)
      element.add(bubble).hover(function() {
        bubble.stop( true, true ).fadeIn();
      }, function() {
        bubble.stop( true, true ).fadeOut( 2000 );
      });
    }
  };


  /* 
   * This event will be triggered when user clicks on bubble
   */
  var handleClickBubble = function( source, bubble ) {
    bubble.on( 'click', function(e) {
      e.preventDefault();
      
      // Remove classActive before classActive will be added to another element (source)
      removeClassActive();

      // Add classActive to active elements (paragraphs, divs, etc.)
      source.addClass( classActive );

      // Before creating a new comments wrapper: remove the previously created wrapper, if any
      removeCommentsWrapper();

      bubble.addClass( classBubbleActive );
      loadCommentsWrapper( bubble );
    });
  };

  /* 
   * Remove classActive from the element that's not 'active' anymore
   */
   var removeClassActive = function() {
    var $activeE = $( classActiveDot );
    if ( $activeE.length !== 0 ) {
      $activeE.removeClass( classActive );
      // If the attribute 'class' is empty -> remove it
      if ( $activeE.prop( 'class' ).length === 0 ) {
        $activeE.removeAttr( 'class' );
      }
    }
  };

  /* 
   * Load comments wrapper
   */
  var loadCommentsWrapper = function ( source ) {
    var $commentsWrapper = $('<div/>',
        {
          'class': classCommentsWrapper,
        })
      .appendTo( idWrapperHash )
      .css('background-color', o.background);

    moveSite( 'in' );
    loadComments();
    loadCommentForm();
    setPosition( source, $commentsWrapper, slideWidth );
    handleClickElsewhere();
    handleClickCancel();
  };

  /*
   * Insert comments and comment form into wrapper
   */
  var loadCommentForm = function() {
    $( idCommentsAndFormHash ).appendTo( classCommentsWrapperDot ).show();
    loadHiddenInputField();
  };

  /*
   * Add a hidden input field dynamically
   */
  var loadHiddenInputField = function() {
    var input = $( '<input>' )
     .attr( 'type', 'hidden' )
     .attr( 'name', dataIncomKey ).val( getAttDataIncomValue );
    $( idCommentsAndFormHash + ' .form-submit' ).append( $( input ) );
  };

  /*
   * Insert comments that have a specific value (getAttDataIncomValue) for attDataIncomComment
   */
  var loadComments = function() {
    var selectByAtt = '[' + attDataIncomComment + '=' + getAttDataIncomValue() + ']';
    $( selectComment ).hide();
    $( selectComment + selectByAtt ).show();
  };

  /*
   * Get (current) value for AttDataIncom
   */
  var getAttDataIncomValue = function() {
    var $attDataIncomValue = $( classActiveDot ).attr( attDataIncom );
    return $attDataIncomValue;
  };

  /*
   * Set position
   */
  var setPosition = function ( source, element, addWidth ) {
    var $offset = source.offset();
    addWidth = typeof addWidth !== 'undefined' ? addWidth : 0;

    element.css({
      'top': $offset.top,
      'left': o.position === 'right' ? $offset.left + source.outerWidth() + addWidth : $offset.left - element.outerWidth() - addWidth
    });
  };

  /*
   * Remove comments wrapper when user clicks anywhere but the idWrapperHash
   */
  var handleClickElsewhere = function() {
    $( 'html' ).click( function( e ) {
      if( $( e.target ).parents( idWrapperHash ).length === 0 ) {
        removeCommentsWrapper( true );
      }
    });
  };

  /*
   * Remove comments wrapper when user clicks on a cancel element
   */
  var handleClickCancel = function() {
    $( classCancelDot ).click( function( e ) {
      e.preventDefault();
      removeCommentsWrapper( true );
    });
  };

  /* 
   * Remove comments wrapper
   */
  var removeCommentsWrapper = function ( fadeout ) {
    var $classIncomBubble = $( classBubbleDot );
    var $classCommentsWrapper = $( classCommentsWrapperDot );

    // Comments and comment form must be detached (and hidden) before wrapper is deleted, so it can be used afterwards
    $( idCommentsAndFormHash ).appendTo( idWrapperHash ).hide();

    // If any element with $classIncomBubble has classBubbleActive -> remove class and commentsWrapper
    if ( $classIncomBubble.hasClass( classBubbleActive ) ) {
      $classIncomBubble.removeClass( classBubbleActive );
      if ( fadeout ) {
        $classCommentsWrapper.fadeOut( 'fast', function() {
            $( this ).remove();
        });
      }
      else {
        $classCommentsWrapper.remove();
      }
      moveSite( 'out' );
    }
  };

  var moveSite = function( way ) {
      //var $viewportW = $ind(window).width();

      if ( way === 'in' ) {
        if ( o.position === "left") {
          $( 'body' ).css( { "position" : "relative", "left" : slideWidth  } );
         } else {
          $( 'body' ).css( { "position" : "relative", "right" : slideWidth  } );
        }
      }
      else if ( way === 'out' ) {
        if ( o.position === "left" ) {
          $( 'body' ).css( { "position" : "relative", "left" : "initial"  } );
        } else {
          $( 'body' ).css( { "position" : "relative", "right" : "initial"  } );
        }
      }
  };

  /*
   * Split selectors
   * @return array
   */
  var splitSelectors = function( selectors ) {
    var splitSelectors = selectors.split(',');
    return splitSelectors;
  };

}( window.incom = window.incom || {}, jQuery ));
