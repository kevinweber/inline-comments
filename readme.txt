=== Inline Comments ===
Contributors: kevinweber
Donate link: http://kevinw.de/donate/InlineComments/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
Tags: admin, comment, comments, content, counter, free, integration, jquery, mobile, page, pages, plugin, post, posts, sidebar, wordpress
Requires at least: 3.5
Tested up to: 4.4.2
Stable tag: 2.2.1

Inline Comments adds your comment system to the side of paragraphs and other sections (like headlines and images) of your post.

== Description ==
Inline Comments adds your comment system to the side of paragraphs and other sections (like headlines and images) of your post.

It performs native with WordPress comments. The comment area is shown when you click the comment count bubbles (left or right) beside any section.

When publishing a comment next to a paragraph, the comment is published in place without a page reload (using Ajax; requires plugin WP Ajaxify Comments). The comment bubbles are not showing up on small screens/mobile sites in many cases.

IMPORTANT: This plugin is no longer supported. Minor fixes might be published but no new features are going to be developed. However, you can [contribute on Github](https://github.com/kevinweber/inline-comments) and enhancements will be published to the official WordPress directory.

Demo and more information on the developer’s website: [kevinw.de/inline-comments/](http://kevinw.de/inline-comments/)


= Translators =
* German (de_DE) - [Kevin Weber](http://kevinw.de/)
* Polish (pl_PL) - [Łukasz Piwko](http://shebang.pl/)
* Russian (ru_RU) - [Vlad Mira](http://mirvla.com/)
* Serbian (sr_RS) - [Ogi Djuraskovic](http://firstsiteguide.com/)
* Spanish (es_ES) - [Andrew Kurtis](http://www.webhostinghub.com/)

If you have created your own language pack, or have an update of an existing one, you can [send me](http://kevinw.de/contact/) your gettext PO and MO so that I can bundle it into my plugin. You can download the latest POT file [from here](http://plugins.svn.wordpress.org/inline-comments/trunk/languages/inline-comments.pot).


== Installation ==

1. Upload Inline Comments into you plugin directory (/wp-content/plugins/) and activate the pastlugin through the 'Plugins' menu in WordPress.
2. Configure the plugin via the admin backend. Take at least a closer look at the "Selectors" option to make the comments appear at the desired places.
3. Optionally: Sign up to the Inline Comments newsletter to get notified about major updates.


== Frequently Asked Questions ==

= Why should I use Inline Comments? =
* Inline Comments are an innovative approach on how to display comments.
* It's different from "traditional" comments you see on every website.
* Commentators can better refer to specific paragraphs/statements in an article.
* Readers can comment while reading (and don’t have to scroll to the very bottom).
* Readers can even reply to inline comments directly and discuss existing annotations.

Demo and more information on the developer’s website: [kevinw.de/inline-comments/](http://kevinw.de/inline-comments/)

= How does the "Default status" option work? (Plugin version 2.2+) =
Using this option you can decide on which parts (posts, pages, ...) of your website the Inline Comments script should be loaded. Only when the script is loaded on a specific page, Inline Comments can show up. It is NOT recommended to load the script on absolutely every page because the plugin doesn't work correctly on pages with multiple posts, such as most home pages or category pages with post loops.

= Why do we need "Selectors"? =
That option is essential to make this plugin work fine with your individual WordPress site. We need it because each WordPress theme is different and comes with a different page structure. To address those differences, we use selectors. Selectors determine in which places the comments should be displayed. You can use nearly every combination of CSS selectors. You'll find examples on the admin page. ([Learn more about CSS](http://www.w3schools.com/css/).)

= How can I change the formatting of the commentator’s currently selected section? =
For comment system "WordPress Comments", use custom CSS like this: 

*.incom-active { background: #f3f3f3; }*

= Why are comments not showing up (even after submitting a new comment was successful)? =
Make sure that comments on your page/post are working – even when Inline Comments is not activated. When comments are not showing up while this plugin is deactivated, they probably won't show up when Inline Comments is activated.

When you use a theme with the popular Genesis framework, for example, make sure that the theme specific option "Enable Comments" is checked. If you don't want to display comments in the regular comments section (thus, below the post), you can hide that section using CSS. But do not disable commenting at all.

= Known bugs =
* When you use Jetpack Comments, the comments will not be assigned to a specific paragraph. Anyhow, the comment will be displayed within your regular comment section with all other comments.

== Changelog ==

= 2.2.1 =
* Fix for comment submission in WordPress 4.4.2 (pull request from @foliovision on Github, change by @fvmartin).

= 2.2 =
* New feature: Define where Inline Comments should be loaded by default. You can override the default setting on every post and page individually.

= 2.1.6.2 =
* Added Russian translation by Vlad M.
* Added Polish translation by Łukasz Piwko.

= 2.1.6.1 =
* Removed one escape method to make the plugin working again.

= 2.1.6 =
* Improved security: Excaped content to prevent cross-site scripting (XSS) (pull request from @allan23 on Github).

= 2.1.5 =
* The "i" link is now optional. By default, no information link is displayed.
* Fixed not working jQuery tabs in admin backend.

= 2.1.4 =
* Recalculate bubble positions when window is resized (pull request from @r-a-y on Github).
* Minor fixes.

= 2.1.3 =
* Improved compatibility with WP-Ajaxify-Comments: Update comment count bubble when new comment is submitted (pull request from @r-a-y on Github).

= 2.1.2 =
* Registered additional HTML attribute 'data-incom-ref' to improve theme support for the references feature.

= 2.1.1 =
* Changed option "Remove Permalinks" to "Display Permalinks" (permalinks are hidden by default as from now). If this option is checked, a permalink icon will be displayed next to each comment.
* Improved colour picker.
* Scroll smoothly when the user clicks on a comment's permalink icon.
* Removed "Comment System" option.
* Fix: Replaced '<?=' with '<?php echo'.
* Improvement: Use not minified JavaScript files when SCRIPT_DEBUG is true (defined in wp-config.php).
* Added version number to scripts.
* Added Spanish translation by Andrew Kurtis.

= 2.1 =
* New feature: References. The default WordPress comments that are displayed below your article contain a link to the referenced paragraph. Click on the link to jump to the paragraph.
* Fixed not working option "Always Display Bubbles".
* Extended body_class() function to display class "inline-comments" within the <body> element.

= 2.0.2 =
* Improved UX: Close comments when user clicks on the same bubble again.
* Added Serbian translation by Ogi Djuraskovic.

= 2.0.1 =
* Renamed functions.php to inline-comments.php.

= 2.0 =
* MILESTONE, new feature: Reply to inline comments (this feature is compatible with WP-Ajaxify-Comments).
* Removed Disqus integration.
* It's translatable! A German translation comes with this update ("Inline-Kommentare", de_DE).
* New feature: Display avatars.
* New feature: Insert HTML above the list of comments.
* New feature: Remove form field "Website".
* Improvement/fix: Use the first five letters to create the data-incom attribute (instead of just one letter) and, additionally, ensure that no two elements with the same value exist. Else it happens that one comment is displayed next to two different headings, like next to h1 and h2. (Now a comment will be assigned either to h1 or h2.) This improvement removes existing comments that have been assigned to headings from being displayed inline.
* Improved look of permalink icons.
* Improved usability for admins: Change URL when tab is switched. Now you can send URLs that directly load a specific tab on your options page
* Fix: When WP-Ajaxify-Comments is enabled and a comment was submitted, and when then the user wants to close the wrapper using the cancel link/cross, the page reloaded. That issue is now fixed.

= 1.2 =
* New feature: Added closing "x" to the right top of the comments wrapper. Can be removed per option
* New feature: Change background opacity for comment threads
* New feature: Hide "cancel" link
* Fix: Now bubbles will only then appear when images, fonts and all other elements are loaded. So there is no displacement of bubbles anymore but it may take a bit longer until they are visible. (Displacements occurred especially on sites that load web fonts and when users with a slow internet connection visited the site.)

= 1.1 =
* No page reload anymore: INLINE COMMENTS NOW EMPOWERS WP-AJAXIFY-COMMENTS!! This improves the user experience with Ajax functionality: Your page will not reload after a comment is submitted

= 1.0.6 =
* New feature: Decide if bubbles should fade in/out or appear/disappear immediately
* New feature: You can make the comment bubbles to be always visible
* New feature: Hide the permalink that’s displayed next to each comment

= 1.0.4 =
* If a comment bubble fits not completely on the screen, it will not be displayed

= 1.0.3 =
* Now it's possible to format active paragraphs/sections
* New feature: Select bubble style for sections with no comments yet (options: plain or bubble)

= 1.0 =
* Major update! Many improvements and new functionalities
* This plugin now performs with native WordPress comments
* Removed option "identifier" (users cannot choose their own identifier anymore)

= 0.8 =
* Plugin goes public (Disqus-only)


== Upgrade Notice ==

= 2.2 =
* Check out the new "Default status" option. It makes it easier to display comments on specific pages without the need of extra selectors such as ".single-page".
* Starting with this version, this plugin is no longer supported. I might publish minor fixes but will no longer develop new features or reply to requests.

= 2.1.1 =
* If you want permalinks to be displayed next to each comment, please check the updated option "Display Permalinks". Previously, those permalinks had been visible by default.

= 2.0.1 =
* I renamed functions.php to inline-comments.php. This causes your plugin to be deactivated. Simply activate it again and everything works fine.
* Disqus integration is no longer supported, but you can still use the previous versions  1.2 or below from https://wordpress.org/plugins/inline-comments/developers/.
* Inline comments that were assigned to a div or heading (and a few other elements) before this update will not be linked to that element anymore. However, those comments are not lost - they are still visible within the regular comment section. This bugfix ensures that there are no longer two or more different headings that display the same comments.
* A German translation (de_DE) comes with this update.

= 1.2 =
* Check your settings and how your inline comments look. This update comes with some style update. IMPORTANT: When you call your site the first time after the update, clear your browser’s cache and reload the page with “F5” to ensure that the current stylesheets are actually loaded. If you’re using a caching plugin, clear it’s cache, too.

= 1.0 =
* This plugin now performs with native WordPress comments.

= 0.8 =
* Plugin goes public (only Disqus comment system is supported).


== Screenshots ==

1. Screenshot of a site that uses Inline Comments. The user has hovered the first paragraph.
2. Comments view. The user has clicked on the bubble.
3. Admin backend with many options for customisation.