=== Inline Comments ===
Contributors: kevinweber
Donate link: http://kevinw.de/donate/InlineComments/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
Tags: admin, comment, comments, content, counter, free, integration, jquery, mobile, page, pages, plugin, post, posts, sidebar, wordpress
Requires at least: 3.0
Tested up to: 4.0
Stable tag: 2.0

Inline Comments adds your comment system to the side of paragraphs and other sections (like headlines and images) of your post.

== Description ==
Inline Comments adds your comment system to the side of paragraphs and other sections (like headlines and images) of your post.

It performs native with WordPress comments. The comment area is shown when you click the comment count bubbles (left or right) beside any section.

When publishing a comment next to a paragraph, the comment is published in place without a page reload (using Ajax).

Demo and more information on the developer’s website: [kevinw.de/inline-comments/](http://kevinw.de/inline-comments/)

== Installation ==

1. Upload Inline Comments into you plugin directory (/wp-content/plugins/) and activate the plugin through the 'Plugins' menu in WordPress.
2. Configure the plugin via the admin backend.


== Frequently Asked Questions ==

= Why should I use Inline Comments? =
* Inline Comments are an innovative approach on how to display comments.
* It's different from "traditional" comments you see on every website.
* Commentators can better refer to specific paragraphs/statements in an article.
* Readers can comment while reading (and don’t have to scroll to the very bottom).
* Readers can even reply to inline comments directly and discuss existing annotations.

Demo and more information on the developer’s website: [kevinw.de/inline-comments/](http://kevinw.de/inline-comments/)

= How can I change the formatting of the commentator’s currently selected section? =
For comment system "WordPress Comments", use custom CSS like this: 

*.incom-active { background: #f3f3f3; }*

= Known bugs =
* When you use Jetpack Comments, the comments will not be assigned to a specific paragraph. Anyhow, the comment will be displayed within your regular comment section with all other comments.

== Changelog ==

= 2.0.1 =
* Renamed functions.php to inline-comments.php

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
* Removed option “identifier” (users cannot choose their own identifier anymore)

= 0.8 =
* Plugin goes public (Disqus-only)


== Upgrade Notice ==

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