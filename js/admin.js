(function( incom, $, undefined ) {

  var $selectCommentType = $( 'select[name=select_comment_type]' );
  var $classDisqusShortname = $( '.disqus_shortname' );

  if ( $selectCommentType.val() !== 'disqus' ) {
     $classDisqusShortname.hide();
  }

  $selectCommentType.change(function () {
    if ( $( this ).val() === 'disqus' ) {
      $classDisqusShortname.show( 'fast' );
    } else {
       $classDisqusShortname.hide( 'fast' );
    }
  });

}( window.incom = window.incom || {}, jQuery ));
