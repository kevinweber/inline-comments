/*
 * Inline Comments
 * by Kevin Weber
 */

(function( incom, $, undefined ) {

  var o;
  var idWrapper = 'incom_wrapper';
    var idWrapperHash = '#'+idWrapper;
  var idCommentsAndForm = 'comments-and-form';
    var idCommentsAndFormHash = '#'+idCommentsAndForm;
  var attDataIncom = 'data-incom';
  var classBubble = 'incom-bubble';
  var classActive = 'incom-active';  // Class for currently selected bubble
    var classBubbleDot = '.'+classBubble;
  var classBubbleLink = 'incom-bubble-link';
  var classCommentsWrapper = 'incom-comments-wrapper';
    var classCommentsWrapperDot = '.'+classCommentsWrapper;
  var classCancel = 'incom-cancel'; // When a user clicks on an element with this class, the comments wrapper will be removed
    var classCancelDot = '.'+classCancel;



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
        // identifier: 'disqussion', // WILL NOT BE SUPPORTET for WordPress Comment System
        // displayCount: true,
        // highlighted: false,
        position: 'left',
        background: 'white',
        // maxWidth: 9999,
      },
    options);
  };


  /* 
   * This wrapper contains comment bubbles
   */
  var initIncomWrapper = function() {
    if ( $( idWrapperHash ).length === 0 ) {
      $( '<div id="'+idWrapper+'"></div>' ).appendTo( $( 'body' ) );
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
    var $bubble = $('<a/>',
        {
          href: '',
          'class': classBubbleLink,
        })
      .text('+')
      .wrap('<div class="'+classBubble+'" />')
      .parent()
      .appendTo( idWrapperHash );

    setPosition( source, $bubble );
    handleHover( source, $bubble );
    handleClickBubble( $bubble );
  };


  /* 
   * This event will be triggered when user hovers a text element or bubble
   */
  var handleHover = function ( element, bubble ) {
    // Handle hover (for both, "elements" and $bubble)
    element.add(bubble).hover(function() {
      bubble.stop( true, true ).fadeIn();
    }, function() {
      bubble.stop( true, true ).fadeOut( 2000 );
    });
  };


  /* 
   * This event will be triggered when user clicks on bubble
   */
  var handleClickBubble = function ( source ) {
    source.on( 'click', function(e) {
      e.preventDefault();

      // Before creating a new comments wrapper: remove the previously created wrapper, if any
      removeCommentsWrapper();

      source.addClass( classActive );
      loadCommentsWrapper( source );
    });
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

    loadCommentForm();
    setPosition( source, $commentsWrapper );
    handleClickElsewhere();
    handleClickCancel();
  };

  /*
   * Insert comments and comment form into wrapper
   */
  var loadCommentForm = function() {
    $( idCommentsAndFormHash ).appendTo( classCommentsWrapperDot ).show();
  };

  /*
   * Set position
   */
  var setPosition = function ( source, element ) {
    var $offset = source.offset();

    element.css({
      'top': $offset.top,
      'left': o.position === 'right' ? $offset.left + source.outerWidth() : $offset.left - element.outerWidth()
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
   * Get PHP using AJAX
   */
  // var ajaxLoadComments = function()
  // {
  //   // $.ajax({
  //   //   //url: ajax_script_vars.ajaxurl,
  //   //   // data: (
  //   //   //   {
  //   //   //     action : ajax_script_vars.comments_php
  //   //   //   }
  //   //   // ),
  //   //   // success: function() {
  //   //   //   console.log( 'debug' );
  //   //   // }
  //   // });
  //   return ajax_script_vars.comments_php;
  // };

  /* 
   * Remove comments wrapper
   */
  var removeCommentsWrapper = function ( fadeout ) {
    var $classIncomBubble = $( classBubbleDot );
    var $classCommentsWrapper = $( classCommentsWrapperDot );

    // Comments and comment form must be detached (and hidden) before wrapper is deleted, so it can be used afterwards
    $( idCommentsAndFormHash ).appendTo( idWrapperHash ).hide();

    // If any element with $classIncomBubble has classActive -> remove class and commentsWrapper
    if ( $classIncomBubble.hasClass( classActive ) ) {
      $classIncomBubble.removeClass( classActive );
      if ( fadeout === true ) {
        $classCommentsWrapper.fadeOut( 'fast', function() {
            $( this ).remove();
        });
      }
      else {
        $classCommentsWrapper.remove();
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
