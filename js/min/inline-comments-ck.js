!function(t,$,n){var i,o="incom_wrapper",e="#"+o,a="body",c="comments-and-form",r="#"+c,s="data-incom",u=s+"-comment",l="incom-active",f="."+l,d="incom-visible-comment",b="."+d,p="incom-position-",v="incom-bubble",m="."+v,h=v+"-style",g=v+"-static",w="."+g,y=v+"-dynamic",S=v+"-active",k=v+"-link",C="incom-comments-wrapper",T="."+C,x="incom-cancel",A="."+x,I="incom-info-icon",O="."+I,W=r+" .comment",j="data_incom",B=0,D=$(window).width(),N,_,L;t.init=function(t){Q(t),q(),yn()};var Q=function(t){i=$.extend({selectors:"p",moveSiteSelector:a,countStatic:!0,alwaysStatic:!1,defaultBubbleText:"+",bubbleStyle:"bubble",bubbleAnimationIn:"default",bubbleAnimationOut:"default",position:"left",background:"white",backgroundOpacity:"1"},t)},q=function(){0===$(e).length&&$('<div id="'+o+'"></div>').appendTo($(a)).addClass(p+i.position),z()},z=function(){var t=Sn(i.selectors);$(t).each(function(n){$(t[n]).each(function(t){var n=$(this);E(t,n),F(n)})})},E=function(t,n){var i=n.prop("tagName").substr(0,2);if(!n.attr(s)){var o=i+t;n.attr(s,o)}},F=function(t){var n=G(t),i=J(t),o=$("<a/>",{href:"","class":k}).text(n).wrap(i).parent().appendTo(e);P(o),cn(t,o),sn(o)?(R(t,o),U(t,o)):o.hide()},G=function(t){var n;return n=M(t)?H(t):i.defaultBubbleText},H=function(t){var n=t.attr(s),i="["+u+"="+n+"]",o=$(i).length;return o},J=function(t){var n='<div class="'+K(t)+'" />';return n},K=function(t){var n=v,o=" ";return(i.alwaysStatic||M(t)&&i.countStatic)&&(n+=o+g),n+=M(t)||!M(t)&&"bubble"===i.bubbleStyle?o+h:o+y},M=function(t){var n=H(t);return $.isNumeric(n)&&n>0?!0:!1},P=function(t){t.hasClass(g)&&t.css("display","block")},R=function(t,n){n.hasClass(g)||t.add(n).hover(function(){$(m+":not("+w+")").hide(),"fadein"===i.bubbleAnimationIn?n.stop(!0,!0).fadeIn():n.stop(!0,!0).show(),sn(n)||n.hide()},function(){"fadeout"===i.bubbleAnimationOut?n.stop(!0,!0).fadeOut():n.stop(!0,!0).delay(700).hide(0)})},U=function(t,n){n.on("click",function(i){i.preventDefault(),V(),t.addClass(l),pn(),n.addClass(S),Z(n)})},V=function(){var t=$(f);0!==t.length&&(t.removeClass(l),0===t.prop("class").length&&t.removeAttr("class"))},X=function(t){var n=parseInt(Y(t).substring(0,2),16),i=parseInt(Y(t).substring(2,4),16),o=parseInt(Y(t).substring(4,6),16);return n+","+i+","+o},Y=function(t){return"#"===t.charAt(0)?t.substring(1,7):t},Z=function(t){var n=$("<div/>",{"class":C}).appendTo(e).css("background-color","rgba("+X(i.background)+","+i.backgroundOpacity+")");en(),nn(),cn(t,n),un(n),dn(),tn()},tn=function(){$(document).ready(bn()).ajaxStop(function(){bn()})},nn=function(){$(r).appendTo(T).show(),on()},on=function(){var t=$("<input>").attr("type","hidden").attr("name",j).val(an);$(r+" .form-submit").append($(t))},en=function(){var t="["+u+"="+an()+"]";$(W).hide(),$(W+t).addClass(d).show(),$(b+" .children li").show()},an=function(){var t=$(f).attr(s);return t},cn=function(t,n){var i=t.offset();n.css({top:i.top,left:wn()?i.left+t.outerWidth():i.left-n.outerWidth()})},rn=function(t){N=t.outerWidth(),_=t.offset().left,L=_+N},sn=function(t){return rn(t),L>D||0>_?!1:!0},un=function(t){rn(t),wn()&&L>D?(ln(L-D),vn("in")):!wn()&&0>_&&(ln(-_),vn("in"))},ln=function(t){B=t},fn=function(){return B},dn=function(){$("html").click(function(t){0===$(t.target).parents(e).length&&pn(!0)})},bn=function(){$(A).click(function(t){t.preventDefault(),pn(!0)})},pn=function(t){var n=$(m),i=$(T);$(r).appendTo(e).hide(),$(b).removeClass(d),n.hasClass(S)&&(n.removeClass(S),t?i.fadeOut("fast",function(){$(this).remove(),V()}):i.remove(),vn("out"))},vn=function(t){var n=$(i.moveSiteSelector);n.css({position:"relative"}),mn(n,t),i.moveSiteSelector!==a&&(gn(t,m),gn(t,T))},mn=function(t,n){var i;"in"===n?i=fn():"out"===n&&(i="initial"),hn(t,i)},hn=function(t,n){t.css(wn()?{right:n}:{left:n})},gn=function(t,n){var i=$(n);"in"===t?i.css({left:wn()?"-="+fn():"+="+fn()}):"out"===t&&i.css({left:wn()?"+="+fn():"-="+fn()})},wn=function(){return"right"===i.position?!0:!1},yn=function(){$(O).css({display:"block",visibility:"visible"});var t=$(O).css("color");t=t.replace(/\s/g,""),t=t.toLowerCase(),("rgb(255, 255, 255)"===t||"white"===t||"rgba(0,0,0,0)"===t)&&$(O).css("cssText","color: black!important;")},Sn=function(t){var n=t.split(",");return n}}(window.incom=window.incom||{},jQuery);