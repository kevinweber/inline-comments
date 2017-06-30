<div id="tabs" class="ui-tabs">
    <h2><?php esc_html_e( 'Inline Comments', INCOM_TD ); ?> <span class="subtitle"><?php esc_html__( 'by', INCOM_TD ); ?> <a href="http://kevinw.de/ic" target="_blank" title="<?php esc_html_e( 'Website by Kevin Weber', INCOM_TD ); ?>">Kevin Weber</a> (<?php esc_html_e( 'Version', INCOM_TD ); ?> <?php echo esc_html(INCOM_VERSION); ?>)</span>
        <br><span class="claim" style="font-size:15px;font-style:italic;position:relative;top:-7px;"><?php esc_html_e( '&hellip; revolutionise the way we comment online!', INCOM_TD ); ?></span>
    </h2>

    <ul class="ui-tabs-nav">
        <li><a href="#basics"><?php esc_html_e( 'Basics', INCOM_TD ); ?> <span class="newred_dot">&bull;</span></a></li>
        <li><a href="#styling"><?php esc_html_e( 'Styling', INCOM_TD ); ?></a></li>
        <li><a href="#advanced"><?php esc_html_e( 'Advanced', INCOM_TD ); ?></a></li>
        <?php do_action( 'incom_settings_page_tabs_link_after' ); ?>
    </ul>

    <form method="post" action="options.php">
        <?php settings_fields( 'incom-settings-group' ); ?>
        <?php do_settings_sections( 'incom-settings-group' ); ?>

        <div id="basics">

            <h3><?php esc_html_e( 'Basic Settings', INCOM_TD ); ?></h3>

            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Visibility', INCOM_TD ); ?> <span class="newred"><?php esc_html_e( 'New!', INCOM_TD ); ?></th>
                        <td>
                            <select class="select" typle="select" name="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_status_default">
                                <option value="public"<?php if (get_option(INCOM_OPTION_KEY.'_status_default') === 'public') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Everyone', INCOM_TD ); ?></option>
                                <option value="logged_in"<?php if (get_option(INCOM_OPTION_KEY.'_status_default') === 'logged_in') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Logged-in users only', INCOM_TD ); ?></option>
                            </select>
                            <p>
                                <?php esc_html_e( 'Define who can see Inline Comments.', INCOM_TD ); ?>
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Default Status', INCOM_TD ); ?></th>
                        <td>
                            <select class="select" typle="select" name="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_status_default">
                                <option value="on_posts_pages"<?php if (get_option(INCOM_OPTION_KEY.'_status_default') === 'on_posts_pages') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Load on posts and pages', INCOM_TD ); ?></option>
                                <option value="on_posts_pages"<?php if (get_option(INCOM_OPTION_KEY.'_status_default') === 'on_posts_pages_custom') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Load on posts, pages and custom post types', INCOM_TD ); ?></option>
                                <option value="on_posts"<?php if (get_option(INCOM_OPTION_KEY.'_status_default') === 'on_posts') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Load on posts', INCOM_TD ); ?></option>
                                <option value="on_pages"<?php if (get_option(INCOM_OPTION_KEY.'_status_default') === 'on_pages') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Load on pages', INCOM_TD ); ?></option>
                                <option value="on"<?php if (get_option(INCOM_OPTION_KEY.'_status_default') === 'on') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Load always (not recommended)', INCOM_TD ); ?></option>
                                <option value="off"<?php if (get_option(INCOM_OPTION_KEY.'_status_default') === 'off') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Don&#39;t load', INCOM_TD ); ?></option>
                            </select>
                            <p>
                                <?php printf( esc_html__( 'Define if Inline Comments should be loaded on posts and/or pages by default. You can override the default setting on every post and page individually. See also: %1$sFAQ%2$s.', INCOM_TD ),
                                    '<a href="https://wordpress.org/plugins/inline-comments/faq/" title="Page with frequently asked questions" target="_blank">',
                                    '</a>'
                                ); ?>
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Selectors', INCOM_TD ); ?></th>
                        <td>
                            <textarea rows="3" cols="70" type="text" name="multiselector" placeholder="selector1, selector2, selectorN"><?php echo sanitize_text_field(get_option('multiselector')); ?></textarea><br>
                            <span><?php esc_html_e( 'Insert selectors in order to control beside which sections the comment bubbles should be displayed.', INCOM_TD ); ?><br><br><?php esc_html_e( 'You can insert selectors like that:', INCOM_TD ); ?> <i><?php esc_html_e( 'selector1, selector2, selectorN', INCOM_TD ); ?></i><br><?php esc_html_e( 'Example:', INCOM_TD ); ?> <i><?php esc_html_e( 'h1, .entry-content p, span, blockquote', INCOM_TD ); ?></i></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Use Ajaxify (no page reload)', INCOM_TD ); ?><br>
                            <span class="description thin">
                                <?php printf( esc_html__( 'Requires %1$sthat plugin%2$s.', INCOM_TD ),
                                    '<a href="http://wordpress.org/extend/plugins/wp-ajaxify-comments/" title="WP-Ajaxify-Comments" target="_blank">',
                                    '</a>'
                                ); ?>
                            </span>
                        </th>
                        <td>
                            <input name="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_support_for_ajaxify_comments" type="checkbox" value="1" <?php checked( '1', get_option( INCOM_OPTION_KEY.'_support_for_ajaxify_comments' ) ); ?> />

                            <span><?php
                            printf( esc_html__( 'Empower %1$sWP-Ajaxify-Comments%2$s (version 0.24.0 or higher) to add Ajax functionality to Inline Comments and improve the user experience: Your page will not reload after a comment is submitted.', INCOM_TD ),
                                '<a href="http://wordpress.org/extend/plugins/wp-ajaxify-comments/" title="WP-Ajaxify-Comments" target="_blank">',
                                '</a>'
                            ); ?> <b><?php esc_html_e( 'Recommended.', INCOM_TD ); ?></b></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Enable Inline Replies', INCOM_TD ); ?></span></th>
                        <td>
                            <input name="incom_reply" type="checkbox" value="1" <?php checked( '1', get_option( 'incom_reply' ) ); ?> /><span><?php esc_html_e( 'If checked, a reply link will be added below each inline comment and users can reply directly.', INCOM_TD ); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( '"Slide Site" Selector', INCOM_TD ); ?></th>
                        <td>
                            <?php
                                $arr_selectors = array( ".site-main", ".site-inner", ".site", "#page", "html" );
                                $selectors = implode( '<br>' , $arr_selectors );
                            ?>
                            <input type="text" name="moveselector" placeholder="body" value="<?php echo sanitize_text_field(get_option('moveselector')); ?>" />
                                <br>
                                <span><?php esc_html_e( 'This selector defines which content should slide left/right when the user clicks on a bubble. This setting depends on your theme\'s structure.', INCOM_TD ); ?> <?php esc_html_e( 'Default is', INCOM_TD ); ?> <i>html</i>.
                                    <br><br><?php esc_html_e( 'You might try one of these selectors:', INCOM_TD ); ?>
                                    <br><span class="italic"><?php echo $selectors; /* XSS OK */ ?></span>
                                </span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Attribution', INCOM_TD ); ?><br><span class="description thin"><?php esc_html_e( 'give appropriate credit for my time-consuming efforts', INCOM_TD ); ?></span></th>
                        <td>
                            <?php $options = get_option( INCOM_OPTION_KEY.'_attribute' ); ?>
                            <input class="radio" type="radio" name="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_attribute" value="none"<?php checked( 'none' == $options || empty($options) ); ?> /> <label for="none"><?php esc_html_e( 'No attribution: "I can not afford to give appropriate credit for this free plugin."', INCOM_TD ); ?></label><br><br>
                            <input class="radio" type="radio" name="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_attribute" value="link"<?php checked( 'link' == $options ); ?> /> <label for="link"><?php esc_html_e( 'Link attribution: Display a subtle "i" (information link) that is placed in the top right of every comment wrapper and helps that the plugin gets spread.', INCOM_TD ); ?></label><br><br>
                            <input class="radio" type="radio" name="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_attribute" value="donate"<?php checked( 'donate' == $options ); ?> />
                            <label for="donate">
                                <?php esc_html_e( 'Donation: "I have donated already or will do so soon."', INCOM_TD ); ?>
                                <?php printf( esc_html__( 'Please %1$sdonate now%2$s so that I can keep up the development of this plugin.', INCOM_TD ),
                                    '<a href="http://kevinw.de/donate/InlineComments/" target="_blank">',
                                    '</a>'
                                ); ?>
                            </label><br>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

        <div id="styling">

            <h3><?php esc_html_e( 'Styling', INCOM_TD ); ?></h3>

            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Custom CSS', INCOM_TD ); ?> <span class="description thin"><br><?php esc_html_e( 'Add additional CSS. This should override any other stylesheets.', INCOM_TD ); ?></span></th>
                        <td>
                            <textarea rows="14" cols="70" type="text" name="custom_css" placeholder="selector { property: value; }"><?php echo esc_html(get_option('custom_css')); ?></textarea>
                            <span>
                                <?php esc_html_e( 'For example:', INCOM_TD ); ?><br>
                                <i>.incom-bubble-dynamic a.incom-bubble-link { color: red; }</i><br>
                                <i>.incom-active { background: #f3f3f3; }</i><br>
                                <?php printf( esc_html__( '(You don\'t know CSS? Try the %1$shttp://kevinw.de/css-tutorial%2$sCSS Tutorial%3$s on W3Schools.)', INCOM_TD ),
                                    '<a href="',
                                    '" target="_blank">',
                                    '</a>'
                                ); ?>
                            </span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Position', INCOM_TD ); ?></th>
                        <td>
                            <input id="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_select_align_left" class="radio" type="radio" name="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_select_align" value="left"<?php if (get_option( INCOM_OPTION_KEY.'_select_align') === 'left') { echo ' checked'; } ?> /><label class="label-radio" for="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_select_align_left"><?php esc_html_e( 'Left', INCOM_TD ); ?></label>
                            <input id="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_select_align_right" class="radio" type="radio" name="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_select_align" value="right"<?php if (get_option( INCOM_OPTION_KEY.'_select_align') !== 'left') { echo ' checked'; } ?> /><label class="label-radio" for="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_select_align_right"><?php esc_html_e( 'Right', INCOM_TD ); ?></label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Display Avatars', INCOM_TD ); ?><br><span class="description thin"><?php esc_html_e( 'next to each comment', INCOM_TD ); ?></span></th>
                        <td>
                            <input name="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_avatars_display" type="checkbox" value="1" <?php checked( '1', get_option( INCOM_OPTION_KEY.'_avatars_display' ) ); ?> /><span><?php esc_html_e( 'If checked, avatars will be displayed next to each comment.', INCOM_TD ); ?></span><br><br>
                            <input type="number" name="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_avatars_size" placeholder="15" value="<?php echo sanitize_text_field(get_option( INCOM_OPTION_KEY.'_avatars_size' )); ?>" /><span><?php esc_html_e( 'Define avatar size (in px). Insert an integer higher than 0.', INCOM_TD ); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Bubble Style', INCOM_TD ); ?> <span class="description thin"><br><?php esc_html_e( 'for sections with no comments yet', INCOM_TD ); ?></span></th>
                        <td>
                            <select class="select" typle="select" name="select_bubble_style">
                                <option value="bubble"<?php if (get_option('select_bubble_style') === 'bubble') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Bubble', INCOM_TD ); ?></option>
                                <option value="plain"<?php if (get_option('select_bubble_style') === 'plain') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Plain +', INCOM_TD ); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Background Colour', INCOM_TD ); ?> <span class="description thin"><br><?php esc_html_e( 'for comment threads', INCOM_TD ); ?></span></th>
                        <td>
                            <input id="incom_picker_input_bgcolor" class="incom_picker_bgcolor picker-input" type="text" name="set_bgcolour" data-default-color="#ffffff" value="<?php if (get_option("set_bgcolour") == "") { echo "#ffffff"; } else { echo esc_attr(get_option("set_bgcolour")); } ?>" />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Background Opacity', INCOM_TD ); ?><span class="description thin"><br><?php esc_html_e( 'for comment threads', INCOM_TD ); ?></span></th>
                        <td>
                            <input type="text" name="incom_set_bgopacity" placeholder="1" value="<?php echo sanitize_text_field(get_option('incom_set_bgopacity')); ?>" /><br><span><?php esc_html_e( 'Insert a value from 0 to 1 where "1" means maximum covering power. Insert 0.7 to make the opacity 70%.', INCOM_TD ); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Hide Static Bubbles', INCOM_TD ); ?></th>
                        <td>
                            <input name="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_bubble_static" type="checkbox" value="1" <?php checked( '1', get_option( INCOM_OPTION_KEY.'_bubble_static' ) ); ?> /><span><?php esc_html_e( 'This checkbox only affects bubbles that indicate a paragraph/element with at least one comment. If checked, the comment count bubbles will only be visible when the user hovers the specific paragraph. (By default, bubbles that indicate at least one comment are always visible.)', INCOM_TD ); ?></span>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

        <div id="advanced">

            <h3><?php esc_html_e( 'Advanced Settings', INCOM_TD ); ?></h3>

            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Content Before', INCOM_TD ); ?><br><span class="description thin"><?php esc_html_e( 'Insert HTML above the list of comments', INCOM_TD ); ?></span></th>
                        <td>
                            <textarea rows="5" cols="70" type="text" name="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_content_comments_before" placeholder=""><?php echo wp_kses_post(get_option(INCOM_OPTION_KEY.'_content_comments_before')); ?></textarea>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Bubble Fade In', INCOM_TD ); ?></th>
                        <td>
                            <select class="select" typle="select" name="select_bubble_fadein">
                                <option value="default"<?php if (get_option('select_bubble_fadein') === 'default') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'No animation', INCOM_TD ); ?></option>
                                <option value="fadein"<?php if (get_option('select_bubble_fadein') === 'fadein') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Basic animation', INCOM_TD ); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Bubble Fade Out', INCOM_TD ); ?></th>
                        <td>
                            <select class="select" typle="select" name="select_bubble_fadeout">
                                <option value="default"<?php if (get_option('select_bubble_fadeout') === 'default') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'No animation', INCOM_TD ); ?></option>
                                <option value="fadeout"<?php if (get_option('select_bubble_fadeout') === 'fadeout') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Basic animation', INCOM_TD ); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Remove Closing "x"', INCOM_TD ); ?></th>
                        <td>
                            <input name="cancel_x" type="checkbox" value="1" <?php checked( '1', get_option( 'cancel_x' ) ); ?> /><span><?php esc_html_e( 'If checked, the "x" at the right top of the comments wrapper will not be displayed.', INCOM_TD ); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Remove Field "Website"', INCOM_TD ); ?></th>
                        <td>
                            <input name="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_field_url" type="checkbox" value="1" <?php checked( '1', get_option( INCOM_OPTION_KEY.'_field_url' ) ); ?> /><span><?php esc_html_e( 'If checked, users cannot submit an URL/Website when they comment inline.', INCOM_TD ); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Remove Link "Cancel"', INCOM_TD ); ?></th>
                        <td>
                            <input name="cancel_link" type="checkbox" value="1" <?php checked( '1', get_option( 'cancel_link' ) ); ?> /><span><?php esc_html_e( 'If checked, the "cancel" link at the left bottom of the comments wrapper will not be displayed.', INCOM_TD ); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Display Permalinks', INCOM_TD ); ?></th>
                        <td>
                            <input name="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_comment_permalink" type="checkbox" value="1" <?php checked( '1', get_option( INCOM_OPTION_KEY.'_comment_permalink' ) ); ?> /><span><?php esc_html_e( 'If checked, a permalink icon will be displayed next to each comment.', INCOM_TD ); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Display References', INCOM_TD ); ?></th>
                        <td>
                            <select class="select" typle="select" name="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_references">
                                <option value="below_text"<?php if (get_option( INCOM_OPTION_KEY.'_references') === 'below_text') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Below comment text', INCOM_TD ); ?></option>
                                <option value="nowhere"<?php if (get_option( INCOM_OPTION_KEY.'_references') === 'nowhere') { echo ' selected="selected"'; } ?>><?php esc_html_e( 'Nowhere', INCOM_TD ); ?></option>
                            </select>
                            <span><br>
                            <?php esc_html_e( 'References are links to referenced paragraphs. By default, they are visible in the regular comment section (below your article) next to a comment that has been submitted using Inline Comments.', INCOM_TD ); ?>
                            </span>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Always Display Bubbles', INCOM_TD ); ?></th>
                        <td>
                            <input name="<?php echo esc_attr(INCOM_OPTION_KEY); ?>_bubble_static_always" type="checkbox" value="1" <?php checked( '1', get_option( INCOM_OPTION_KEY.'_bubble_static_always' ) ); ?> /><span><?php esc_html_e( 'If checked, the comment count bubbles will always be visible (and not only on hover). Bubbles will not fade.', INCOM_TD ); ?></span>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

        <?php do_action( 'incom_settings_page_tabs_after' ); ?>

        <?php submit_button(); ?>
    </form>

    <?php if ( INCOM_ESSENTIAL ) {
        require_once( 'inc/signup.php' );
    } ?>

    <table class="form-table">
        <tr valign="top">
        <th scope="row" style="width:100px;"><a href="http://kevinw.de/ic" target="_blank"><img src="https://www.gravatar.com/avatar/9d876cfd1fed468f71c84d26ca0e9e33?d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536&s=100" style="-webkit-border-radius:50%;-moz-border-radius:50%;border-radius:50%;"></a></th>
        <td style="width:200px;">
            <p><a href="http://kevinw.de/ic" target="_blank">Kevin Weber</a> &ndash; <?php esc_html_e( 'that\'s me.', INCOM_TD ); ?><br>
            <?php esc_html_e( 'I\'m the developer of this plugin. Love it!', INCOM_TD ); ?></p></td>
            <td>
                <p>
                    <b><?php esc_html_e( 'It\'s free!', INCOM_TD ); ?></b>
                    <?php printf( esc_html__( 'Support me with %1$sa delicious lunch%2$s or give this plugin a 5 star rating %3$son WordPress.org%4$s.', INCOM_TD ),
                        '<a href="http://kevinw.de/donate/InlineComments/" title="Pay me a delicious lunch" target="_blank">',
                        '</a>',
                        '<a href="http://wordpress.org/support/view/plugin-reviews/inline-comments?filter=5" title="Vote for Inline Comments" target="_blank">',
                        '</a>'
                    ); ?>
                </p>
            </td>
        <td style="width:300px;">
            <p>
                <b><?php esc_html_e( 'Personal tip: Must use plugins', INCOM_TD ); ?></b>
                <ol>
                    <li><a href="http://kevinw.de/ic-ll" title="Lazy Load for Videos" target="_blank"><?php esc_html_e( 'Lazy Load for Videos', INCOM_TD ); ?></a> <?php esc_html_e( '(on my part)', INCOM_TD ); ?></li>
                    <li><a href="https://yoast.com/wordpress/plugins/seo/" title="WordPress SEO by Yoast" target="_blank"><?php esc_html_e( 'WordPress SEO', INCOM_TD ); ?></a> <?php esc_html_e( '(by Yoast)', INCOM_TD ); ?></li>
                    <li><a href="http://kevinw.de/ic-wb" title="wBounce" target="_blank"><?php esc_html_e( 'wBounce', INCOM_TD ); ?></a> <?php esc_html_e( '(on my part)', INCOM_TD ); ?></li>
                    <li><a href="https://wordpress.org/plugins/broken-link-checker/" title="Broken Link Checker" target="_blank"><?php esc_html_e( 'Broken Link Checker', INCOM_TD ); ?></a> <?php esc_html_e( '(by Janis Elsts)', INCOM_TD ); ?></li>
                </ol>
            </p>
        </td>
        </tr>
    </table>
</div>
