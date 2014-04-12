/*
 * Inline Comments
 * by Kevin Weber
 */

(function( incom, $, undefined ) {

  /*
   * Public methods
   */

  incom.init = function( options ) {

    //var that = this;

    // Defaults
    var o = $.extend( {
        selectors: 'p',
        // identifier: 'disqussion',
        // displayCount: true,
        // highlighted: false,
        // position: 'right',
        // background: 'white',
        // maxWidth: 9999,
      },
    options);

    // Increase counter per element type (instead of using one counter for all elements).
    // Advantage: For example, if an user inserts a new paragraph, the comments assigned to a specific element will not match anymore.
    // However, this new paragraph will not affect comments that are assigned to other elements of another type, like DIVs, blockquotes or headlines.
    var selectors = splitSelectors( o.selectors );

    $( selectors ).each( function(j) {

      $( selectors[j] ).each( function(i) {
        addAtt( i, $(this) );
      });

    });

  };

  /*
   * Private methods
   */

  var addAtt = function(i, element) {

    // Use the first letter of the element's name
    var identifier = element.prop('tagName').substr(0,1);

    // If element has no attribute 'data-incom' add it
    if ( !element.attr( 'data-incom') ) {
      var attProp = identifier + i;
      element.attr( 'data-incom', attProp );
    }
  };

  // Split selectors
  var splitSelectors = function( selectors ) {
    var splitSelectors = selectors.split(',');
    return splitSelectors;
  };

}( window.incom = window.incom || {}, jQuery ));
