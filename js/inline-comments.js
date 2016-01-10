/*
 * Inline Comments
 * by Kevin Weber
 */

(function (incom, $) {
    'use strict';

    var o,

        // IDs
        idWrapper = 'incom_wrapper',
        idWrapperHash = '#' + idWrapper,
        idWrapperAppendTo = 'html',
        idCommentsAndForm = 'comments-and-form',
        idCommentsAndFormHash = '#' + idCommentsAndForm,
        idCommentForm = 'incom-commentform',

        // Attributes
        attDataIncom = 'data-incom',
        attDataIncomComment = attDataIncom + '-comment',
        attDataIncomArr = [], // This array will contain all attDataIncom values
        attDataIncomBubble = attDataIncom + '-bubble',
        attDataIncomRef = attDataIncom + '-ref',

        // Classes
        classActive = 'incom-active',
        classActiveDot = '.' + classActive,
        classVisibleComment = 'incom-visible-comment',
        classVisibleCommentDot = '.' + classVisibleComment,
        classPosition = 'incom-position-', // Expects that o.position follows ('left' or 'right')
        classBubble = 'incom-bubble',
        classBubbleDot = '.' + classBubble,
        classBubbleStyle = classBubble + '-style',
        classBubbleStatic = classBubble + '-static',
        classBubbleStaticDot = '.' + classBubbleStatic,
        classBubbleDynamic = classBubble + '-dynamic',
        classBubbleActive = classBubble + '-active', // Class for currently selected bubble
        classBubbleLink = classBubble + '-link',
        classCommentsWrapper = 'incom-comments-wrapper',
        classCommentsWrapperDot = '.' + classCommentsWrapper,
        classReply = 'incom-reply',
        classReplyDot = '.' + classReply,
        classCancel = 'incom-cancel', // When a user clicks on an element with this class, the comments wrapper will be removed
        classCancelDot = '.' + classCancel,
        classBranding = 'incom-info-icon',
        classBrandingDot = '.' + classBranding,
        classScrolledTo = 'incom-scrolled-to',

        // Other
        selectComment = idCommentsAndFormHash + ' .comment',
        dataIncomKey = 'data_incom', // Should be the same as $DataIncomKey in class-comments.php
        slideWidth = 0, // Shift page content o.moveSiteSelector to the left
        $viewportW = $(window).width(),
        $elementW,
        $offsetL,
        $sumOffsetAndElementW;


    /**
     * Rebuild bubbles and content data attributes
     */
    incom.rebuild = function () {
        // Reset
        $viewportW = $(window).width();
        attDataIncomArr = [];
        $('#incom_wrapper .incom-bubble').remove();

        // Re-init bubbles
        initElementsAndBubblesFromSelectors();

        // Reset sidebar form if visible
        var commentsForm = $(idCommentsAndFormHash + ':visible');
        if (commentsForm.length) {
            removeCommentsWrapper();
            moveSite('out');
        }
    };



    /*
     * Private methods
     */



    var setOptions = function (options) {
        // 'options' overrides these defaults
        o = $.extend({
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
                displayBranding: false,
            },
            options);
    };


    /* 
     * This wrapper contains comment bubbles
     */
    var initIncomWrapper = function () {
        var docFragment,
            wrapper,
            wrapperParent;

        if ($(idWrapperHash).length === 0) {
            docFragment = document.createDocumentFragment();
            wrapper = document.createElement("div");
            wrapperParent = document.querySelector(idWrapperAppendTo);

            wrapper.setAttribute("id", idWrapper);
            wrapper.className = classPosition + o.position;

            docFragment.appendChild(wrapper);
            wrapperParent.appendChild(docFragment);
        }

        
        initElementsAndBubblesFromSelectors();
    };

    /*
     * Setup elements and bubbles that depend on selectors
     */
    var initElementsAndBubblesFromSelectors = function () {
        var elementsBySelectors,
            i,
            l;
        
        elementsBySelectors = document.querySelectorAll(o.selectors);   
        for (i = 0, l = elementsBySelectors.length; i < l; i += 1) {
            var $that = $(elementsBySelectors[i]);
            addAttToElement($that);
            bubble.createFromElement($that);
        }
    };

    /*
     * Add attribute attDataIncom to element; increase counter per element type (instead of using one counter for all elements independent of their types).
     */
    var addAttToElement = function ($element, i) {
        i = i || 0;

        // Only proceed if element has no attribute attDataIncom yet
        if (!$element.attr(attDataIncom)) {
            var identifier = getIdentifier($element);

            // Increase i when specific attProp (value of attDataIncom) already exists
            i = increaseIdentifierNumberIfAttPropExists(i, identifier);

            var attProp = identifier + i; // WOULD BE BETTER: var attProp = identifier + '-' + i; // BUT THAT WOULD CONFLICT WITH ALREADY STORED COMMENTS

            //@TODO: Add part that assigns comment to specific article/page/post (article-id); include fallback in cause a comment has no ID (yet)

            $element.attr(attDataIncom, attProp);
        }
    };

    var bubble = {
        /*
         * Set bubble position and visibility
         */
        set: function (options) {
            var opt = $.extend({
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
        createFromElement: function ($element) {
            //@TODO
            addBubble($element);
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
    var getIdentifier = function (element) {
        var identifier = element.prop('tagName').substr(0, 5);
        return identifier;
    };

    /*
     * Increase identifier number (i) if that specific attProp was already used. attProp must be unique
     * @return int
     */
    var increaseIdentifierNumberIfAttPropExists = function (i, identifier) {
        var attProp = identifier + i;

        if ($.inArray(attProp, attDataIncomArr) !== -1) {
            while ($.inArray(attProp, attDataIncomArr) !== -1) {
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
    var addBubble = function (source) {
        var bubbleText = addBubbleText(source);
        var bubbleContainer = loadBubbleContainer(source);
        var $bubble = $('<a/>', {
                href: '',
                'class': classBubbleLink,
            })
            .text(bubbleText)
            .wrap(bubbleContainer)
            .parent()
            .appendTo(idWrapperHash);

        setDisplayStatic($bubble);
        setPosition(source, $bubble);

        if (!isInWindow($bubble)) {
            $bubble.hide();
        } else {
            handleHover(source, $bubble);
            handleClickBubble(source, $bubble);
        }
    };

    /*
     * Get text/number that should be displayed in a bubble
     */
    var addBubbleText = function (source) {
        var bubbleText;

        if (testIfCommentsCountLarger0(source)) {
            bubbleText = countComments(source);
        } else {
            bubbleText = o.defaultBubbleText;
        }

        return bubbleText;
    };

    /*
     * Count the number of comments that are assigned to a specific paragraph
     */
    var countComments = function (source) {
        // Get attribute value from source's attribute attDataIncom
        var attFromSource = source.attr(attDataIncom);
        // Define selector that identifies elements that shell be counted
        var selectByAtt = '[' + attDataIncomComment + '=' + attFromSource + ']';
        // Count elements
        var $count = $(selectByAtt).length;
        // Increase count for each inline reply, too
        $count += $(selectByAtt + ' .children li').length;

        return $count;
    };

    /*
     * Get container that contains the bubble link
     */
    var loadBubbleContainer = function (source) {
        var bubbleValue = source.attr(attDataIncom);
        var text = '<div class="' + loadBubbleContainerClass(source) + '" ' + attDataIncomBubble + '="' + bubbleValue + '" />';
        return text;
    };

    /*
     * Generate class for bubbleContainer
     */
    var loadBubbleContainerClass = function (source) {
        var containerClass = classBubble;
        var space = ' ';

        if (
            (o.alwaysStatic) ||
            (testIfCommentsCountLarger0(source) && o.countStatic)
        ) {
            containerClass += space + classBubbleStatic;
        }

        if (
            testIfCommentsCountLarger0(source) ||
            (!testIfCommentsCountLarger0(source) && (o.bubbleStyle === 'bubble'))
        ) {
            containerClass += space + classBubbleStyle;
        } else {
            containerClass += space + classBubbleDynamic;
        }

        return containerClass;
    };

    /*
     * Test if comments count is larger than 0
     */
    var testIfCommentsCountLarger0 = function (source) {
        var count = countComments(source);
        return ($.isNumeric(count) && count > 0) ? true : false;
    };

    var setDisplayStatic = function (bubble) {
        if (bubble.hasClass(classBubbleStatic)) {
            bubble.css('display', 'block');
        }
    };

    /* 
     * This event will be triggered when user hovers a text element or bubble
     */
    var handleHover = function (element, bubble) {
        if (!bubble.hasClass(classBubbleStatic)) {
            // Handle hover (for both, "elements" and $bubble)
            element.add(bubble).hover(function () {
                // First hide all non-static bubbles
                $(classBubbleDot + ':not(' + classBubbleStaticDot + ')').hide();

                if (o.bubbleAnimationIn === 'fadein') {
                    bubble.stop(true, true).fadeIn();
                } else {
                    bubble.stop(true, true).show();
                }

                if (!isInWindow(bubble)) {
                    bubble.hide();
                }
            }, function () {
                if (o.bubbleAnimationOut === 'fadeout') {
                    bubble.stop(true, true).fadeOut();
                } else {
                    // Delay hiding to make it possible to hover the bubble before it disappears
                    bubble.stop(true, true).delay(700).hide(0);
                }
            });
        }
    };


    /* 
     * This event will be triggered when user clicks on bubble
     */
    var handleClickBubble = function (source, bubble) {
        bubble.on('click', function (e) {
            e.preventDefault();
            var $that = $(this);

            // When the wrapper is already visible (and the bubble is active), then remove the wrapper and the bubble's class
            if ($that.hasClass(classBubbleActive)) {
                removeCommentsWrapper(true);
                $that.removeClass(classBubbleActive);
            }

            // Else ...
            else {
                // Remove classActive before classActive will be added to another element (source)
                removeExistingClasses(classActive);

                // Add classActive to active elements (paragraphs, divs, etc.)
                source.addClass(classActive);

                // Before creating a new comments wrapper: remove the previously created wrapper, if any
                removeCommentsWrapper();

                bubble.addClass(classBubbleActive);
                loadCommentsWrapper(bubble);
            }

        });
    };

    /*
     * Create comments wrapper
     */
    var createCommentsWrapper = function () {
        var $commentsWrapper;

        if ($(classCommentsWrapperDot).length === 0) {
            $commentsWrapper = $('<div/>', {
                    'class': classCommentsWrapper,
                })
                .appendTo(idWrapperHash)
                .css('background-color', 'rgba(' + convertHexToRgb(o.background) + ',' + o.backgroundOpacity + ')');
        } else {
            $commentsWrapper = $(classCommentsWrapperDot);
        }

        return $commentsWrapper;
    };

    /* 
     * Load comments wrapper
     */
    var loadCommentsWrapper = function (source) {
        var $commentsWrapper = createCommentsWrapper();

        loadComments();
        loadCommentForm();
        setPosition(source, $commentsWrapper);
        testIfMoveSiteIsNecessary($commentsWrapper);
        handleClickElsewhere();
        ajaxStop();
    };

    /*
     * Use ajaxStop function to prevent plugin from breaking when another plugin uses Ajax
     */
    var ajaxStop = function () {
        $(document).ready(handleClickCancel()).ajaxStop(function () {
            handleClickCancel();
        });
    };

    /*
     * Insert comments and comment form into wrapper
     */
    var loadCommentForm = function () {
        $(idCommentsAndFormHash).appendTo(classCommentsWrapperDot).show();
        loadHiddenInputField();
    };

    /*
     * Add a hidden input field dynamically
     */
    var loadHiddenInputField = function () {
        var input = $('<input>')
            .attr('type', 'hidden')
            .attr('name', dataIncomKey).val(getAttDataIncomValue);
        $(idCommentsAndFormHash + ' .form-submit').append($(input));
    };

    /*
     * Insert comments that have a specific value (getAttDataIncomValue) for attDataIncomComment
     */
    var loadComments = function () {
        var selectByAtt = '[' + attDataIncomComment + '=' + getAttDataIncomValue() + ']';
        $(selectComment).hide();
        $(selectComment + selectByAtt).addClass(classVisibleComment).show();
        $(classVisibleCommentDot + ' .children li').show();
    };

    /*
     * Get (current) value for AttDataIncom
     */
    var getAttDataIncomValue = function () {
        var $attDataIncomValue = $(classActiveDot).attr(attDataIncom);
        return $attDataIncomValue;
    };

    /*
     * Set position
     */
    var setPosition = function (source, element) {
        var $offset = source.offset();

        element.css({
            'top': $offset.top,
            'left': testIfPositionRight() ? $offset.left + source.outerWidth() : $offset.left - element.outerWidth(),
        });
    };

    /*
     * Set element properties (outerWidth, offset, ...)
     */
    var setElementProperties = function (element) {
        $elementW = element.outerWidth();
        $offsetL = element.offset().left;
        $sumOffsetAndElementW = $offsetL + $elementW;
    };

    /*
     * Test if element (bubble or so) is in window completely
     */
    var isInWindow = function (element) {
        setElementProperties(element);
        return (($sumOffsetAndElementW > $viewportW) || ($offsetL < 0)) ? false : true;
    };

    var testIfMoveSiteIsNecessary = function (element) {
        setElementProperties(element);

        // If admin has selected position "right" and the comments wrapper's right side stands out of the screen -> setSlideWidth and moveSite
        if (testIfPositionRight() && ($sumOffsetAndElementW > $viewportW)) {
            setSlideWidth($sumOffsetAndElementW - $viewportW);
            moveSite('in');
        } else if (!testIfPositionRight() && ($offsetL < 0)) {
            setSlideWidth(-$offsetL);
            moveSite('in');
        }
    };

    var setSlideWidth = function (width) {
        slideWidth = width;
    };

    var getSlidewidth = function () {
        return slideWidth;
    };

    /*
     * Remove comments wrapper when user clicks anywhere but the idWrapperHash
     */
    var handleClickElsewhere = function () {
        $('html').click(function (e) {
            if ($(e.target).parents(idWrapperHash).length === 0) {
                removeCommentsWrapper(true);
            }
        });
    };

    /*
     * Remove comments wrapper when user clicks on a cancel element
     */
    var handleClickCancel = function () {
        $(classCancelDot).click(function (e) {
            e.preventDefault();
            removeCommentsWrapper(true);
        });
    };

    /* 
     * Remove comments wrapper
     */
    var removeCommentsWrapper = function (fadeout) {
        var $classIncomBubble = $(classBubbleDot);
        var $classCommentsWrapper = $(classCommentsWrapperDot);

        // Comments and comment form must be detached (and hidden) before wrapper is deleted, so it can be used afterwards
        $(idCommentsAndFormHash).appendTo(idWrapperHash).hide();

        // Remove classVisibleComment from every element that has classVisibleComment
        $(classVisibleCommentDot).removeClass(classVisibleComment);

        // If any element with $classIncomBubble has classBubbleActive -> remove class and commentsWrapper
        if ($classIncomBubble.hasClass(classBubbleActive)) {
            $classIncomBubble.removeClass(classBubbleActive);
            if (fadeout) {
                $classCommentsWrapper.fadeOut('fast', function () {
                    $(this).remove();
                    removeExistingClasses(classActive);
                });
            } else {
                $classCommentsWrapper.remove();
            }
            moveSite('out');
        }

    };

    var moveSite = function (way) {
        var $move = $(o.moveSiteSelector);
        $move.css({
            "position": "relative"
        });

        handleWayInAndOut($move, way);

        // Only move elements if o.moveSiteSelector is not the same as idWrapperAppendTo
        if (o.moveSiteSelector !== idWrapperAppendTo) {
            moveElement(way, classBubbleDot); // Move bubbles
            moveElement(way, classCommentsWrapperDot); // Move wrapper
        }
    };

    var handleWayInAndOut = function (element, way) {
        var value;

        if (way === 'in') {
            value = getSlidewidth();
        } else if (way === 'out') {
            value = 'initial';

        }
        moveLeftOrRight(element, value);
    };

    var moveLeftOrRight = function (element, value) {
        var direction = testIfPositionRight() ? 'right' : 'left';
        var options = {};
        options[direction] = value;

        element.css(options);


        // element.animate(options,{
        //    duration: 500,
        //           step:function(now, fn){
        //             fn.start = 0;
        //             fn.end = value;
        //             $(element).css({
        //                 '-webkit-transform':'translateX(-'+now+'px)',
        //                 '-moz-transform':'translateX(-'+now+'px)',
        //                 '-o-transform':'translateX(-'+now+'px)',
        //                 'transform':'translateX(-'+now+'px)'
        //             });
        //           }
        // });

        // if ( testIfPositionRight() ) {
        //   element.css( { 
        //     '-webkit-transform': translateX(-100%);
        //     -moz-transform: translateX(-100%);
        //     -ms-transform: translateX(-100%);
        //     -o-transform: translateX(-100%);
        //     transform: translateX(-100%)

        //    } );
        // } else {
        //   element.css( { 'left' : value  } );
        // }



        // if ( testIfPositionRight() ) {
        //   // element.css( { 'right' : value  } );

        //   // element.animate({
        //   //   width: "toggle",
        //   //   height: "toggle"
        //   // }, {
        //   //   duration: 5000,
        //   //   specialEasing: {
        //   //     width: "linear",
        //   //     height: "easeOutBounce"
        //   //   },
        //   //   complete: function() {
        //   //     $( this ).after( "<div>Animation complete.</div>" );
        //   //   }
        //   // });
        //   element.animate({
        //       right: value,
        //     }, "fast" );

        // } else {
        //   element.css( { 'left' : value  } );
        // }
    };

    var moveElement = function (way, selector) {
        var $element = $(selector);

        if (way === 'in') {
            $element.css({
                left: testIfPositionRight() ? '-=' + getSlidewidth() : '+=' + getSlidewidth()
            });
        } else if (way === 'out') {
            $element.css({
                left: testIfPositionRight() ? '+=' + getSlidewidth() : '-=' + getSlidewidth()
            });
        }
    };

    var testIfPositionRight = function () {
        return o.position === 'right' ? true : false;
    };

    /*
     * Controle references
     * @since 2.1
     */
    var references = function () {
        var source = attDataIncomRef;
        var target = attDataIncom;
        removeOutdatedReferences(source, target);
        loadScrollScript(source, target);
    };

    /*
     * Remove outdated references that link to an element that doesn't exist
     * @since 2.1
     */
    var removeOutdatedReferences = function (source, target) {
        $('[' + source + ']').each(function () {

            var $source = $(this);
            var targetValue = $source.attr(source); // Get value from source element
            var $target = $('[' + target + '="' + targetValue + '"]');

            if (!$target.length) { // No length = linked element doesn't exist
                $source.parent().remove();
            }

        });
    };

    /*
     * Define all event handler functions here
     * @since 2.1.1
     */
    var handleEvents = {
        init: function () {
            this.permalinksHandler();
        },

        permalinksHandler: function () {
            $(idCommentsAndFormHash).on('click', 'a.incom-permalink', function () {
                var $target = $(this.hash);

                if ($target.length) {

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
    var loadScrollScript = function (source, target) {
        $('[' + source + ']').click(function () {

            var targetValue = $(this).attr(source); // Get value from source element
            var $target = $('[' + target + '="' + targetValue + '"]');

            if ($target.length) {

                animateScrolling($target);

                removeExistingClasses(classScrolledTo);
                $target.addClass(classScrolledTo);
            }

        });
    };

    /*
     * Remove existing classes (expects parameter "className" - without "dot")
     */
    var removeExistingClasses = function (className) {
        var $activeE = $('.' + className);
        if ($activeE.length !== 0) {
            $activeE.removeClass(className);
            // If the attribute 'class' is empty -> remove it
            if ($activeE.prop('class').length === 0) {
                $activeE.removeAttr('class');
            }
        }
    };



    /*
     * Create info element
     */
    var createPluginInfo = function () {
        // source = Video
        var anchorElement = $('.incom-cancel-x');
        var element = $(loadPluginInfo());

        if ((o.displayBranding === true || o.displayBranding === 1) && !$(classBrandingDot).length) {
            anchorElement.after(element);
        }
    };

    /*
     * Load plugin info
     */
    var loadPluginInfo = function () {
        return '<a class="' + classBranding + '" href="http://kevinw.de/inline-comments/" title="Inline Comments by Kevin Weber" target="_blank">i</a>';
    };



    /*
     * Private Helpers
     */

    /*
     * @return Hex colour value as RGB
     */
    var convertHexToRgb = function (h) {
        var r = parseInt((removeHex(h)).substring(0, 2), 16);
        var g = parseInt((removeHex(h)).substring(2, 4), 16);
        var b = parseInt((removeHex(h)).substring(4, 6), 16);
        return r + ',' + g + ',' + b;
    };

    /*
     * Remove Hex ("#") from string
     */
    var removeHex = function (h) {
        return (h.charAt(0) === "#") ? h.substring(1, 7) : h;
    };

    /*
     * Set easing "quart"
     */
    $.easing.quart = function (x, t, b, c, d) {
        return -c * ((t = t / d - 1) * t * t * t - 1) + b;
    };

    /*
     * Change URL
     * @param href = complete URL
     */
    var changeUrl = function (href) {
        history.pushState(null, null, href);
        if (history.pushState) {
            history.pushState(null, null, href);
        } else {
            location.hash = href;
        }
    };

    /*
     * Animate scrolling
     * @param $target (expects unique jQuery object)
     */

    var animateScrolling = function ($target) {
        var $scrollingRoot = $('html, body');
        var targetOffset = $target.offset().top - 30;

        $scrollingRoot.animate({
            scrollTop: targetOffset
        }, 1200, 'quart');
    };



    /*
     * Public methods
     */



    incom.init = function (options) {
        setOptions(options);
        initIncomWrapper();

        createPluginInfo();
        references();

        // This code is required to make Inline Comments work with Ajaxify
        $(classReplyDot + " .comment-reply-link").on('click', function () {
            $(idCommentsAndFormHash + ' #commentform').attr("id", idCommentForm);
        });

        handleEvents.init();
    };

}(window.incom = window.incom || {}, jQuery));