/*
 * Inline Comments
 * by Kevin Weber
 */

(function( incom, $, undefined ) {

  var o;
  
  // IDs
  var idWrapper = 'incom_wrapper';
    var idWrapperHash = '#'+idWrapper;
  var idWrapperAppendTo = 'body'; // Alternative: 'body'
  var idCommentsAndForm = 'comments-and-form';
    var idCommentsAndFormHash = '#'+idCommentsAndForm;
  var idCommentForm = 'incom-commentform';

  // Attributes
  var attDataIncom = 'data-incom';
    var attDataIncomComment = attDataIncom+'-comment';

  // Classes
  var classActive = 'incom-active';
    var classActiveDot = '.'+classActive;
  var classVisibleComment = 'incom-visible-comment';
    var classVisibleCommentDot = '.'+classVisibleComment;
  var classPosition = 'incom-position-';  // Expects that o.position follows ('left' or 'right')
  var classBubble = 'incom-bubble';
    var classBubbleDot = '.'+classBubble;
    var classBubbleStyle = classBubble+'-style';
    var classBubbleStatic = classBubble+'-static';
      var classBubbleStaticDot = '.'+classBubbleStatic;
    var classBubbleDynamic = classBubble+'-dynamic';
    var classBubbleActive = classBubble+'-active';  // Class for currently selected bubble
    var classBubbleLink = classBubble+'-link';
  var classCommentsWrapper = 'incom-comments-wrapper';
    var classCommentsWrapperDot = '.'+classCommentsWrapper;
  var classReply = 'incom-reply';
    var classReplyDot = '.'+classReply;
  var classCancel = 'incom-cancel'; // When a user clicks on an element with this class, the comments wrapper will be removed
    var classCancelDot = '.'+classCancel;
  var classBranding = 'incom-info-icon';
    var classBrandingDot = '.'+classBranding;

  // Other
  var selectComment = idCommentsAndFormHash+' .comment';
  var dataIncomKey = 'data_incom';  // Should be the same as $DataIncomKey in class-comments.php
  var slideWidth = 0;  // Shift page content o.moveSiteSelector to the left
  var $viewportW = $(window).width();
  var $elementW;
  var $offsetL;
  var $sumOffsetAndElementW;



  /*
   * Public methods
   */



  incom.init = function( options ) {
    setOptions( options );
    initIncomWrapper();
    displayBranding();

    // CHECK: Ensure that #commentform is replaced by #incom-commentform to make IC work with Ajaxify
    // CHECK: Use useful variables instead of hard-coded selectors
    // TODO: Debug bugs
    // TODO: Call that code only in class-wpac.php
      $( classReplyDot + " .comment-reply-link" ).on( 'click', function() {
        $( idCommentsAndFormHash + ' #commentform' ).attr( "id", idCommentForm );
      });



  };



  /*
   * Private methods
   */



  var setOptions = function( options ) {
    // 'options' overrides these defaults
    o = $.extend( {
        selectors: 'p',
        moveSiteSelector: idWrapperAppendTo,
        countStatic: true,
        alwaysStatic: false,
        defaultBubbleText: '+',
        bubbleStyle: 'bubble',
        bubbleAnimationIn: 'default',
        bubbleAnimationOut: 'default',
        // highlighted: false,
        position: 'left',
        background: 'white',
        backgroundOpacity: '1',
      },
    options);
  };


  /* 
   * This wrapper contains comment bubbles
   */
  var initIncomWrapper = function() {
    if ( $( idWrapperHash ).length === 0 ) {
      $( '<div id="'+idWrapper+'"></div>' ).appendTo( $( idWrapperAppendTo ) )
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
    // Use the first two letters of the element's name as identifier
    var identifier = element.prop('tagName').substr(0,2);

    // If element has no attribute attDataIncom, add it
    if ( !element.attr( attDataIncom ) ) {
      var attProp = identifier + i; // BETTER WOULD BE: var attProp = identifier + '-' + i; // BUT THAT WOULD CONFLICT WITH ALREADY STORED COMMENTS
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

    if ( !isInWindow( $bubble ) ) {
      $bubble.hide();
    }
    else {
      handleHover( source, $bubble );
      handleClickBubble( source, $bubble );
    }
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
    // Increase count for each inline reply, too
    $count += $( selectByAtt + ' .children li').length;

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

    if ( 
        ( o.alwaysStatic ) ||
        ( testIfCommentsCountLarger0( source ) && o.countStatic )
      ) {
      containerClass += space + classBubbleStatic;
    }

    if (
        testIfCommentsCountLarger0( source ) ||
        ( !testIfCommentsCountLarger0( source ) && ( o.bubbleStyle === 'bubble' ) )
      ) {
      containerClass += space + classBubbleStyle;
    }
    else {
      containerClass += space + classBubbleDynamic;
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
        // First hide all non-static bubbles
        $( classBubbleDot+':not('+classBubbleStaticDot+')' ).hide();

        if ( o.bubbleAnimationIn === 'fadein' ) {
          bubble.stop( true, true ).fadeIn();
        }
        else {
          bubble.stop( true, true ).show();
        }

        if ( !isInWindow( bubble ) ) {
          bubble.hide();
        }  
      }, function() {
        if ( o.bubbleAnimationOut === 'fadeout' ) {
          bubble.stop( true, true ).fadeOut();
        }
        else {
          // Delay hiding to make it possible to hover the bubble before it disappears
          bubble.stop( true, true ).delay( 700 ).hide(0);
        }
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
   * @return Hex colour value as RGB
   */
  var convertHexToRgb = function (h) {
    var r = parseInt((removeHex(h)).substring(0,2),16);
    var g = parseInt((removeHex(h)).substring(2,4),16);
    var b = parseInt((removeHex(h)).substring(4,6),16);
    return r+','+g+','+b;
  };

  /*
   * Remove Hex ("#") from string
   */
  var removeHex = function (h) {
    return ( h.charAt(0) === "#" ) ? h.substring(1,7) : h;
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
      .css('background-color', 'rgba(' + convertHexToRgb( o.background ) + ',' + o.backgroundOpacity + ')');

    loadComments();
    loadCommentForm();
    setPosition( source, $commentsWrapper );
    testIfMoveSiteIsNecessary( $commentsWrapper );
    handleClickElsewhere();
    ajaxStop();
  };

  /*
   * Use ajaxStop function to prevent plugin from breaking when another plugin uses Ajax
   */
  var ajaxStop = function() {
    $(document).ready(handleClickCancel()).ajaxStop(function() {
      handleClickCancel();
    });
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
    $( selectComment + selectByAtt ).addClass( classVisibleComment ).show();
    $( classVisibleCommentDot + ' .children li' ).show();
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
  var setPosition = function ( source, element ) {
    var $offset = source.offset();

    element.css({
      'top': $offset.top,
      'left': testIfPositionRight() ? $offset.left + source.outerWidth() : $offset.left - element.outerWidth(),
    });
  };

  /*
   * Set element properties (outerWidth, offset, ...)
   */
  var setElementProperties = function( element ) {
    $elementW = element.outerWidth();
    $offsetL = element.offset().left;
    $sumOffsetAndElementW = $offsetL + $elementW;
  };

  /*
   * Test if element (bubble or so) is in window completely
   */
  var isInWindow = function ( element ) {
    setElementProperties( element );
    return ( ( $sumOffsetAndElementW > $viewportW ) || ( $offsetL < 0 ) ) ? false : true;
  };

  var testIfMoveSiteIsNecessary = function( element ) {
    setElementProperties( element );

    // If admin has selected position "right" and the comments wrapper's right side stands out of the screen -> setSlideWidth and moveSite
    if( testIfPositionRight() && ( $sumOffsetAndElementW > $viewportW ) ) {
      setSlideWidth( $sumOffsetAndElementW - $viewportW );
      moveSite( 'in' );
    }
    else if ( !testIfPositionRight() && ( $offsetL < 0 ) ) {
      setSlideWidth( -$offsetL );
      moveSite( 'in' );
    }
  };

  var setSlideWidth = function( width ) {
    slideWidth = width;
  };

  var getSlidewidth = function() {
    return slideWidth;
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

    // Remove classVisibleComment from every element that has classVisibleComment
    $( classVisibleCommentDot ).removeClass( classVisibleComment );

    // If any element with $classIncomBubble has classBubbleActive -> remove class and commentsWrapper
    if ( $classIncomBubble.hasClass( classBubbleActive ) ) {
      $classIncomBubble.removeClass( classBubbleActive );
      if ( fadeout ) {
        $classCommentsWrapper.fadeOut( 'fast', function() {
            $( this ).remove();
            removeClassActive();
        });
      }
      else {
        $classCommentsWrapper.remove();
      }
      moveSite( 'out' );
    }

  };

  var moveSite = function( way ) {
    var $move = $( o.moveSiteSelector );
    $move.css( { "position" : "relative"  } );

    handleWayInAndOut( $move, way );

    // Only move elements if o.moveSiteSelector is not the same as idWrapperAppendTo
    if ( o.moveSiteSelector !== idWrapperAppendTo ) {
      moveElement( way, classBubbleDot ); // Move bubbles
      moveElement( way, classCommentsWrapperDot );  // Move wrapper
    }
  };

  var handleWayInAndOut = function( element, way ) {
    var value;

    if ( way === 'in' ) {
      value = getSlidewidth();
    }
    else if ( way === 'out' ) {
      value = 'initial';

    }
    moveLeftOrRight( element, value );
  };

  var moveLeftOrRight = function( element, value ) {
    if ( testIfPositionRight() ) {
      element.css( { 'right' : value  } );
    } else {
      element.css( { 'left' : value  } );
    }
  };

  var moveElement = function( way, selector ) {
    var $element = $( selector );

    if ( way === 'in' ) {
      $element.css({
          left: testIfPositionRight() ? '-='+getSlidewidth() : '+='+getSlidewidth()
      });
    }
    else if ( way === 'out' ) {
      $element.css({
          left: testIfPositionRight() ? '+='+getSlidewidth() : '-='+getSlidewidth()
      });
    }
  };

  var testIfPositionRight = function() {
    return o.position === 'right' ? true : false;
  };

  /*
   * Prevent users from removing branding
   */
  var displayBranding = function() {

    // DON'T BE EVIL - IS THIS ACTUALLY WORTH THE EFFORT?

    $( classBrandingDot ).css({
      'display': 'block',
      'visibility': 'visible',
    });

    // Get colour
    var color = $( classBrandingDot ).css('color');
    // Remove spaces
    color = color.replace(/\s/g, '');
    // Convert to lowercase
    color = color.toLowerCase();
    // When transparent: make it white
    if ( (color === 'rgb(255, 255, 255)' || color === 'white') || color === 'rgba(0,0,0,0)' ) {
      $( classBrandingDot ).css("cssText", "color: black!important;");
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
