/*
 * Inline Comments
 * by Kevin Weber
 */

(function( incom, $, undefined ) {

  var o;
  
  // IDs
  var idWrapper = 'incom_wrapper';
    var idWrapperHash = '#'+idWrapper;
  var idWrapperAppendTo = 'html';
  var idCommentsAndForm = 'comments-and-form';
    var idCommentsAndFormHash = '#'+idCommentsAndForm;
  var idCommentForm = 'incom-commentform';

  // Attributes
  var attDataIncom = 'data-incom';
    var attDataIncomComment = attDataIncom+'-comment';
    var attDataIncomArr = []; // This array will contain all attDataIncom values
    var attDataIncomBubble = attDataIncom+'-bubble';
    var attDataIncomRef = attDataIncom+'-ref';

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
  var classScrolledTo = 'incom-scrolled-to';

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
    setIncomWrapper();

    initElementsAndBubblesFromSelectors();

    displayBranding();
    references();

    // This code is required to make Inline Comments work with Ajaxify
    $( classReplyDot ).find( ".comment-reply-link" ).on( 'click', function() {
      $( idCommentsAndFormHash ).find( ' #commentform' ).attr( "id", idCommentForm );
    });

    handleEvents.init();
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
        position: 'left',
        background: 'white',
        backgroundOpacity: '1',
        animation: false,//'snap' // Get possible easing effects from http://ricostacruz.com/jquery.transit/
      },
    options);
  };


  /* 
   * This wrapper contains comment bubbles
   */
  var setIncomWrapper = function() {
    if ( $( idWrapperHash ).length === 0 ) {
      $( '<div id="'+idWrapper+'"></div>' ).appendTo( $( idWrapperAppendTo ) )
        .addClass( classPosition + o.position );
    }
  };

  /*
   * Setup elements and bubbles that depend on selectors
   */
  var initElementsAndBubblesFromSelectors = function() {
    $( o.selectors ).each( function() {
      var $this = $(this);
      addAttToElement( $this );
      bubble.createFromElement( $this );
    });
  };

  /*
   * Add attribute attDataIncom to element; increase counter per element type (instead of using one counter for all elements independent of their types).
   */
   var addAttToElement = function( $element, i ) {
      i = i || 0;

      // Only proceed if element has no attribute attDataIncom yet
      if ( !$element.attr( attDataIncom ) ) {
        var identifier = getIdentifier( $element );

        // Increase i when specific attProp (value of attDataIncom) already exists
        i = increaseIdentifierNumberIfAttPropExists( i, identifier );
        
        var attProp = identifier + i; // WOULD BE BETTER: var attProp = identifier + '-' + i; // BUT THAT WOULD CONFLICT WITH ALREADY STORED COMMENTS

        //@TODO: Add part that assigns comment to specific article/page/post (article-id); include fallback in cause a comment has no ID (yet)

        $element.attr( attDataIncom, attProp );
      }
   };

   var bubble = {
     /*
      * Set bubble position and visibility
      */
     set : function( options ) {
      var opt = $.extend( {
          posX: undefined,
          posY: undefined,
          id: undefined,
          visible: false,
        },
      options);

      //@TODO
      /*
      if (!exists … && id !== undefined ) {
        createBubble + addAtt
      }
      else if ( ( posX && posY ) !== undefined && ( changedPosX || changedPosY ) ) {
        recalculatePos
      }
      
      if ( opt.visible ) {
        displayBubble
      }
      */
     },
     
     /*
      * Add bubble depending on an element
      */
     createFromElement : function( $element ) {
      //@TODO
      addBubble( $element );
     }

   };

   /*
    * Example: Getter and Setter
    */
   // function Selectors( val ) {
   //    var selectors = val;

   //    this.getValue = function(){
   //        return selectors;
   //    };

   //    this.setValue = function( val ){
   //        selectors = splitSelectors( val );
   //    };
   // }

  /*
   * Use the first five letters of the element's name as identifier
   * @return string
   */
  var getIdentifier = function( element ) {
    var identifier = element.prop('tagName').substr(0,5);
    return identifier;
  };

  /*
   * Increase identifier number (i) if that specific attProp was already used. attProp must be unique
   * @return int
   */
  var increaseIdentifierNumberIfAttPropExists = function( i, identifier ) {
    var attProp = identifier + i;

    if ( $.inArray( attProp, attDataIncomArr ) !== -1 ) {
      while ( $.inArray( attProp, attDataIncomArr ) !== -1 ) {
        i++;
        attProp = identifier + i;
      }
    }
    attDataIncomArr.push(attProp);

    return i;
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
      .parent();

    setDisplayStatic( $bubble );
    setPosition( source, $bubble );

    if ( !isInWindow( $bubble ) ) {
      $bubble.hide();
    }
    else {
      handleHover( source, $bubble );
      handleClickBubble( source, $bubble );
    }

    $bubble.appendTo( idWrapperHash );
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
    var $count = $( idCommentsAndFormHash ).find(selectByAtt).length;
    // Increase count for each inline reply, too
    $count += $( idCommentsAndFormHash ).find(selectByAtt).find('.children').find('li').length;

    return $count;
  };

  /*
   * Get container that contains the bubble link
   */
  var loadBubbleContainer = function( source ) {
    var bubbleValue = source.attr( attDataIncom );
    var text = '<div class="' + loadBubbleContainerClass( source ) + '" '+attDataIncomBubble+'="'+bubbleValue+'" />';
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
        $( idWrapperHash ).find( classBubbleDot+':not('+classBubbleStaticDot+')' ).hide();

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
      
      // When the wrapper is already visible (and the bubble is active), then remove the wrapper and the bubble's class
      if ( $(this).hasClass(classBubbleActive) ) {
        removeCommentsWrapper( true );
        $(this).removeClass(classBubbleActive);
      }

      // Else ...
      else {
        // Remove classActive before classActive will be added to another element (source)
        removeExistingClasses( classActive );

        // Add classActive to active elements (paragraphs, divs, etc.)
        source.addClass( classActive );

        // Before creating a new comments wrapper: remove the previously created wrapper, if any
        removeCommentsWrapper();

        bubble.addClass( classBubbleActive );
        loadCommentsWrapper( bubble );
      }

    });
  };

  /*
   * Create comments wrapper
   */
  var createCommentsWrapper = function() {
    var $commentsWrapper;

    if ( $( classCommentsWrapperDot ).length === 0 ) {
      $commentsWrapper = $('<div/>',
          {
            'class': classCommentsWrapper,
          })
          .css('background-color', 'rgba(' + convertHexToRgb( o.background ) + ',' + o.backgroundOpacity + ')')
          .appendTo( idWrapperHash );
    }
    else {
      $commentsWrapper = $( classCommentsWrapperDot );
    }

    return $commentsWrapper;
  };

  /* 
   * Load comments wrapper
   */
  var loadCommentsWrapper = function ( source ) {
    var $commentsWrapper = createCommentsWrapper();

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
    $( idCommentsAndFormHash ).find( '.form-submit' ).append( $( input ) );
  };

  /*
   * Insert comments that have a specific value (getAttDataIncomValue) for attDataIncomComment
   */
  var loadComments = function() {
    var selectByAtt = '[' + attDataIncomComment + '=' + getAttDataIncomValue() + ']';
    $( selectComment ).hide();
    $( selectComment + selectByAtt ).addClass( classVisibleComment ).show();
    $( classVisibleCommentDot ).find( '.children').find( 'li' ).show();
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
      'left': testIfPosRight() ? $offset.left + source.outerWidth() : $offset.left - element.outerWidth(),
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
    if( testIfPosRight() && ( $sumOffsetAndElementW > $viewportW ) ) {
      setSlideWidth( $sumOffsetAndElementW - $viewportW );
      moveSite( 'in' );
    }
    else if ( !testIfPosRight() && ( $offsetL < 0 ) ) {
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
        $classCommentsWrapper.remove();
        removeExistingClasses( classActive );
        moveSite( 'out' );
      }
      else {
        $classCommentsWrapper.remove();
      }
    }

  };

  var moveSite = function( way ) {
    var $move = $( o.moveSiteSelector );
    $move.css( { "position" : "relative"  } );

    moveInOrOut( $move, way );

    // Only move elements if o.moveSiteSelector is not the same as idWrapperAppendTo
    if ( o.moveSiteSelector !== idWrapperAppendTo ) {
      prepareMoveX( $(classBubbleDot), way ); // Move bubbles
      prepareMoveX( $(classCommentsWrapperDot), way ); // Move wrapper
    }
  };

  // @TODO: Merge prepareMoveX into moveInOrOut.
  var moveInOrOut = function( element, way ) {
    var value;

    if ( way === 'in' ) {
      value = getSlidewidth();
    }
    else if ( way === 'out' ) {
      value = '0';
    }

    if (o.animation === false) {
      var options = {};
      options[o.position] = value;
      element.css( options );
    }
    else {  // DO ANIMATION
      prepareMoveX( element, way );
    }
  };

  var prepareMoveX = function( element, way ) {
    var value;
    var sign = testIfPosRight() ? '-' : '';

    if ( way === 'in' ) {
      value = sign+getSlidewidth();
    }
    else if ( way === 'out' ) {
      value = '0';
    }

    moveX( element, value );
  };

  var moveX = function( element, value ) {
    element.transition( // ".transition" requires jQuery Transit library
      { x: value },     // property: value
      400,              // duration
      o.animation       // easing effect
    );
  };

  var testIfPosRight = function() {
    return o.position === 'right' ? true : false;
  };

  /*
   * Controle references
   * @since 2.1
   */
  var references = function() {
    var source = attDataIncomRef;
    var target = attDataIncom;
    removeOutdatedReferences( source, target );
    loadScrollScript( source, target );
  };

  /*
   * Remove outdated references that link to an element that doesn't exist
   * @since 2.1
   */
  var removeOutdatedReferences = function( source, target ) {
    $( '['+source+']' ).each( function() {

      var $source = $( this );
      var targetValue = $source.attr( source );  // Get value from source element
      var $target = $( '['+target+'="'+targetValue+'"]' );

      if ( ! $target.length ) { // No length = linked element doesn't exist
        $source.parent().remove();
      }

    });
  };

  /*
   * Define all event handler functions here
   * @since 2.1.1
   */
  var handleEvents = {
    init : function() {
      this.permalinksHandler();
    },

    permalinksHandler : function() {
      $(idCommentsAndFormHash).on( 'click', 'a.incom-permalink', function() {
        var $target = $(this.hash);

        if ( $target.length ) {

          animateScrolling($target);

          var href = $(this).attr("href");
          changeUrl(href);

          return false;
        }
      });
    }
  };


  /*
   * Load scroll script
   * @since 2.1
   *
   * @todo When page scrolls to element, automatically open wrapper
   */
  var loadScrollScript = function( source, target ) {
    $( '['+source+']' ).click(function() {

      var targetValue = $( this ).attr( source );  // Get value from source element
      var $target = $( '['+target+'="'+targetValue+'"]' );

      if ( $target.length ) {

        animateScrolling($target);

        removeExistingClasses( classScrolledTo );
        $target.addClass( classScrolledTo );
      }

    });
  };

  /*
   * Remove existing classes (expects parameter "className" - without "dot")
   */
  var removeExistingClasses = function( className ) {
    var $activeE = $( '.'+className );
    if ( $activeE.length !== 0 ) {
      $activeE.removeClass( className );
      // If the attribute 'class' is empty -> remove it
      if ( $activeE.prop( 'class' ).length === 0 ) {
        $activeE.removeAttr( 'class' );
      }
    }
  };

  /*
   * Prevent users from removing branding
   */
  var displayBranding = function() {
    var $element = $( classBrandingDot );

    // DON'T BE EVIL - IS THIS ACTUALLY WORTH THE EFFORT?
    
    if ( $element.length ) {

      $element.css({
        'display': 'block',
        'visibility': 'visible',
      });

      // When the opacity/alpha is to low, increase opacity and color it black
      if ( 
          ( $element.css( "opacity" ) < 0.2 ) ||
          ( getAlpha( $element ) < 0.2 )
        )
      {
        $element.css({'color':'rgba(0,0,0,1)'}).fadeTo( "fast", 0.5 );
      }

      // When the font size is to low, increase it
      var $fontsize = $element.css( "font-size" ).replace(/\D/g,'');  // Remove everything but numbers
      if ( $fontsize < 6 ) {
        $element.css({'font-size':'13px'});
      }

      // Get colour
      var color = $element.css('color');
      // Test if spaces or tab stops exist
      if ( /\s/g.test(color) ) {
        // Remove spaces
        color = color.replace(/\s/g, '');
      }
      // Convert to lowercase
      color = color.toLowerCase();
      // When transparent: make it white
      if ( (color === 'rgb(255,255,255)' || color === 'white') || color === 'rgba(255,255,255,0)' ) {
        $element.css("cssText", "color: black!important;");
      }

    }

  };

  /*
   * Private Helpers
   */

  /*
   * Test if element's color contains a RGBA value.
   * If yes,  @return integer
   *          else @return 1
   */
  var getAlpha = function( element ) {
    var alpha = 1;
    var color = element.css( 'color' );

    // Search color value for string "rgba" (case-insensitive)
    if ( /rgba/i.test( color ) ) {
      // Get the fourth (alpha) value using string replace
      alpha = color.replace(/^.*,(.+)\)/,'$1');
    }

    return alpha;
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
   * Set easing "quart"
   */
  $.easing.quart = function (x, t, b, c, d) {
    return -c * ((t=t/d-1)*t*t*t - 1) + b;
  };

  /*
   * Change URL
   * @param href = complete URL
   */
  var changeUrl = function( href ) {
    history.pushState(null, null, href);
    if(history.pushState) {
        history.pushState(null, null, href);
    }
    else {
        location.hash = href;
    }
  };

  /*
   * Animate scrolling
   * @param $target (expects unique jQuery object)
   */

  var animateScrolling = function( $target ) {
    var $scrollingRoot = $('html, body');
    var targetOffset = $target.offset().top - 30;

    $scrollingRoot.animate({
        scrollTop: targetOffset
    }, 1200, 'quart' );
  };

}( window.incom = window.incom || {}, jQuery ));
