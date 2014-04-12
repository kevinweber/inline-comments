/*
 * Inline Comments
 * by Kevin Weber
 */

(function( incom, $, undefined ) {

  var o;
  var classIncomActive = 'incom-active';  // Class for currently selected bubble



  /*
   * Public methods
   */



  incom.init = function( options ) {
    setOptions( options );
    initIncomWrapper();
    initSelectElements();
  };



  /*
   * Private methods
   */



  var setOptions = function( options ) {
    // Override defaults
    o = $.extend( {
        selectors: 'p',
        // identifier: 'disqussion', // WILL NOT BE SUPPORTET for WordPress Comment System
        // displayCount: true,
        // highlighted: false,
        position: 'left',
        // background: 'white',
        // maxWidth: 9999,
      },
    options);
  };


  /* 
   * This wrapper contains comment bubbles
   */
  var initIncomWrapper = function() {
    if ( $( '#incom_wrapper' ).length === 0 ) {
      $( '<div id="incom_wrapper"></div>' ).appendTo( $('body') );
    }
    // if ( $( '#incom_thread' ).length === 0 ) {
    //   $( '<div id="incom_thread"></div>' ).appendTo( '#incom_wrapper' );
    // }
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
   * Add attribute 'data-incom' to each element
   */
  var addAtt = function( i, element ) {
    // Use the first letter of the element's name as identifier
    var identifier = element.prop('tagName').substr(0,1);

    // If element has no attribute 'data-incom', add it
    if ( !element.attr( 'data-incom') ) {
      var attProp = identifier + i;
      element.attr( 'data-incom', attProp );
    }
  };

  /*
   * Add bubbles to each element
   */
  var addBubble = function( element ) {
    var $offset = element.offset();
    var $bubble = $('<a/>',
              {
                href: '',
                'class': 'incom-bubble-link',
              })
      .text('+')
      .wrap('<div class="incom-bubble" />')
      .parent()
      .appendTo('#incom_wrapper');

      // Position bubble
      $bubble.css({
        'top': $offset.top,
        'left': o.position === 'right' ? $offset.left + element.outerWidth() : $offset.left - $bubble.outerWidth()
      });

    handleHover( element, $bubble );
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
  var handleClickBubble = function ( bubble ) {
    bubble.on( 'click', function(e) {
      e.preventDefault();

      // Before creating a new comments wrapper: remove the previously created wrapper, if any
      removeCommentsWrapper();

      bubble.addClass( classIncomActive );
      loadComments( bubble );

    });
  };


  /* 
   * Load comments wrapper
   */
  var loadComments = function ( source ) {
    var commentsPHP = ajaxLoadComments();

    var $offset = source.offset();
    var $commentsWrapper = $('<div/>',
              {
                'class': 'incom-comments-wrapper',
              })
      .html( JSON.parse( commentsPHP ) )
      .appendTo('#incom_wrapper');

    // Position comments wrapper
    $commentsWrapper.css({
      'top': $offset.top,
      'left': o.position === 'right' ? $offset.left + source.outerWidth() : $offset.left - $commentsWrapper.outerWidth()
    });

    // Remove comments wrapper when user clicks anywhere but the #incom_wrapper and its children
    $('html').click( function( event ) {
      if( $( event.target ).parents( '#incom_wrapper' ).length === 0 ) {
        removeCommentsWrapper( true );
      }
    });

  };

  /*
   * Get PHP using AJAX
   */
  var ajaxLoadComments = function()
  {
    // $.ajax({
    //   //url: ajax_script_vars.ajaxurl,
    //   // data: (
    //   //   {
    //   //     action : ajax_script_vars.comments_php
    //   //   }
    //   // ),
    //   // success: function() {
    //   //   console.log( 'debug' );
    //   // }
    // });
    return ajax_script_vars.comments_php;
  };

  /* 
   * Remove comments wrapper
   */
  var removeCommentsWrapper = function ( fadeout ) {
    var $classIncomBubble = $( '.incom-bubble' );
    var $classCommentsWrapper = $( '.incom-comments-wrapper' );

    // If any element with $classIncomBubble has classIncomActive -> remove class and commentsWrapper
    if ( $classIncomBubble.hasClass(classIncomActive) ) {
      $classIncomBubble.removeClass( classIncomActive );
      if ( fadeout === true ) {
        $classCommentsWrapper.fadeOut( 'fast' );
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
