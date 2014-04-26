(function( incom, $, undefined ) {

  $(document).ready(function() {
    init();
  });

  var init = function() {
    handleSelect();
    handleTabs();
    addColourPicker();
  };

  var handleSelect = function() {
    var $selectCommentType = $( 'select[name=select_comment_type]' );
    var $classHideDisqus = $( '.hide-disqus' );

    if ( $selectCommentType.val() !== 'disqus' ) {
       $classHideDisqus.hide();
    }

    $selectCommentType.change(function () {
      if ( $( this ).val() === 'disqus' ) {
        $classHideDisqus.show( 'fast' );
      } else {
         $classHideDisqus.hide( 'middle' );
      }
    });
  };

  var handleTabs = function() {
    $( "#tabs" ).tabs();
  };

  var addColourPicker = function() {
    $('#incom_picker_bgcolor').farbtastic('#incom_picker_input_bgcolor');
// Picker No 2:    $('#incom_picker_bgcolor').farbtastic('#incom_picker_input_bgcolor');
  };

}( window.incom = window.incom || {}, jQuery ));
