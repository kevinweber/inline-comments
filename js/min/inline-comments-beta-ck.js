!function(t,$,n){var i,o="incom_wrapper",e="#"+o,a="body",r="comments-and-form",c="#"+r,s="incom-commentform",u="data-incom",l=u+"-comment",f=[],d=u+"-bubble",m=u+"-ref",p="incom-active",b="."+p,v="incom-visible-comment",h="."+v,g="incom-position-",y="incom-bubble",w="."+y,k=y+"-style",C=y+"-static",S="."+C,T=y+"-dynamic",A=y+"-active",x=y+"-link",I="incom-comments-wrapper",O="."+I,D="incom-reply",W="."+D,j="incom-cancel",q="."+j,z="incom-info-icon",B="."+z,N="incom-scrolled-to",_=c+" .comment",L="data_incom",Q=0,E=$(window).width(),F,G,H;t.init=function(t){J(t),K(),M(),jn(),In(),$(W+" .comment-reply-link").on("click",function(){$(c+" #commentform").attr("id",s)})};var J=function(t){i=$.extend({selectors:"p",moveSiteSelector:a,countStatic:!0,alwaysStatic:!1,defaultBubbleText:"+",bubbleStyle:"bubble",bubbleAnimationIn:"default",bubbleAnimationOut:"default",position:"left",background:"white",backgroundOpacity:"1"},t)},K=function(){0===$(e).length&&$('<div id="'+o+'"></div>').appendTo($(a)).addClass(g+i.position)},M=function(){$(i.selectors).each(function(t){var n=$(this),i=P(n);t=R(t,i),U(t,n,i),V(n)})},P=function(t){var n=t.prop("tagName").substr(0,5);return n},R=function(t,n){var i=n+t;if(-1!==$.inArray(i,f))for(;-1!==$.inArray(i,f);)t++,i=n+t;return f.push(i),t},U=function(t,n,i){if(!n.attr(u)){var o=i+t;n.attr(u,o)}},V=function(t){var n=X(t),i=Z(t),o=$("<a/>",{href:"","class":x}).text(n).wrap(i).parent().appendTo(e);on(o),mn(t,o),bn(o)?(en(t,o),an(t,o)):o.hide()},X=function(t){var n;return n=nn(t)?Y(t):i.defaultBubbleText},Y=function(t){var n=t.attr(u),i="["+l+"="+n+"]",o=$(i).length;return o+=$(i+" .children li").length},Z=function(t){var n=t.attr(u),i='<div class="'+tn(t)+'" '+d+'="'+n+'" />';return i},tn=function(t){var n=y,o=" ";return(i.alwaysStatic||nn(t)&&i.countStatic)&&(n+=o+C),n+=nn(t)||!nn(t)&&"bubble"===i.bubbleStyle?o+k:o+T},nn=function(t){var n=Y(t);return $.isNumeric(n)&&n>0?!0:!1},on=function(t){t.hasClass(C)&&t.css("display","block")},en=function(t,n){n.hasClass(C)||t.add(n).hover(function(){$(w+":not("+S+")").hide(),"fadein"===i.bubbleAnimationIn?n.stop(!0,!0).fadeIn():n.stop(!0,!0).show(),bn(n)||n.hide()},function(){"fadeout"===i.bubbleAnimationOut?n.stop(!0,!0).fadeOut():n.stop(!0,!0).delay(700).hide(0)})},an=function(t,n){n.on("click",function(i){i.preventDefault(),$(this).hasClass(A)?(kn(!0),$(this).removeClass(A)):(Wn(p),t.addClass(p),kn(),n.addClass(A),cn(n))})},rn=function(){var t;return t=0===$(O).length?$("<div/>",{"class":I}).appendTo(e).css("background-color","rgba("+zn(i.background)+","+i.backgroundOpacity+")"):$(O)},cn=function(t){var n=rn();fn(),un(),mn(t,n),vn(n),yn(),sn()},sn=function(){$(document).ready(wn()).ajaxStop(function(){wn()})},un=function(){$(c).appendTo(O).show(),ln()},ln=function(){var t=$("<input>").attr("type","hidden").attr("name",L).val(dn);$(c+" .form-submit").append($(t))},fn=function(){var t="["+l+"="+dn()+"]";$(_).hide(),$(_+t).addClass(v).show(),$(h+" .children li").show()},dn=function(){var t=$(b).attr(u);return t},mn=function(t,n){var i=t.offset();n.css({top:i.top,left:xn()?i.left+t.outerWidth():i.left-n.outerWidth()})},pn=function(t){F=t.outerWidth(),G=t.offset().left,H=G+F},bn=function(t){return pn(t),H>E||0>G?!1:!0},vn=function(t){pn(t),xn()&&H>E?(hn(H-E),Cn("in")):!xn()&&0>G&&(hn(-G),Cn("in"))},hn=function(t){Q=t},gn=function(){return Q},yn=function(){$("html").click(function(t){0===$(t.target).parents(e).length&&kn(!0)})},wn=function(){$(q).click(function(t){t.preventDefault(),kn(!0)})},kn=function(t){var n=$(w),i=$(O);$(c).appendTo(e).hide(),$(h).removeClass(v),n.hasClass(A)&&(n.removeClass(A),t?i.fadeOut("fast",function(){$(this).remove(),Wn(p)}):i.remove(),Cn("out"))},Cn=function(t){var n=$(i.moveSiteSelector);n.css({position:"relative"}),Sn(n,t),i.moveSiteSelector!==a&&(An(t,w),An(t,O))},Sn=function(t,n){var i;"in"===n?i=gn():"out"===n&&(i="initial"),Tn(t,i)},Tn=function(t,n){t.css(xn()?{right:n}:{left:n})},An=function(t,n){var i=$(n);"in"===t?i.css({left:xn()?"-="+gn():"+="+gn()}):"out"===t&&i.css({left:xn()?"+="+gn():"-="+gn()})},xn=function(){return"right"===i.position?!0:!1},In=function(){var t=m,n=u;On(t,n),Dn(t,n)},On=function(t,n){$("["+t+"]").each(function(){var i=$(this),o=i.attr(t),e=$("["+n+'="'+o+'"]');e.length||i.parent().remove()})},Dn=function(t,n){$("["+t+"]").click(function(){var i=$(this).attr(t),o=$("["+n+'="'+i+'"]');if(o.length){var e=o.offset().top-30;$("html, body").animate({scrollTop:e},1200,"quart"),Wn(N),o.addClass(N)}})},Wn=function(t){var n=$("."+t);0!==n.length&&(n.removeClass(t),0===n.prop("class").length&&n.removeAttr("class"))},jn=function(){var t=$(B);if(t.length){t.css({display:"block",visibility:"visible"}),(t.css("opacity")<.2||qn(t)<.2)&&t.css({color:"rgba(0,0,0,1)"}).fadeTo("fast",.5);var n=t.css("font-size").replace(/\D/g,"");6>n&&t.css({"font-size":"13px"});var i=t.css("color");/\s/g.test(i)&&(i=i.replace(/\s/g,"")),i=i.toLowerCase(),("rgb(255,255,255)"===i||"white"===i||"rgba(255,255,255,0)"===i)&&t.css("cssText","color: black!important;")}},qn=function(t){var n=1,i=t.css("color");return/rgba/i.test(i)&&(n=i.replace(/^.*,(.+)\)/,"$1")),n},zn=function(t){var n=parseInt(Bn(t).substring(0,2),16),i=parseInt(Bn(t).substring(2,4),16),o=parseInt(Bn(t).substring(4,6),16);return n+","+i+","+o},Bn=function(t){return"#"===t.charAt(0)?t.substring(1,7):t};$.easing.quart=function(t,n,i,o,e){return-o*((n=n/e-1)*n*n*n-1)+i}}(window.incom=window.incom||{},jQuery);