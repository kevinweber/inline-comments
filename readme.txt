=== Plugin Name ===
Contributors: kevinweber
Donate link: http://kevinw.de/donate/InlineComments/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
Tags: admin, comment, comments, content, counter, free, integration, jquery, mobile, page, pages, plugin, post, posts, sidebar, wordpress
Requires at least: 3.0
Tested up to: 3.9.1
Stable tag: 1.0.6

Inline Comments adds your comment system to the side of paragraphs and other sections (like headlines and images) of your post.

== Description ==
Inline Comments adds your comment system to the side of paragraphs and other sections (like headlines and images) of your post.

It performs native with WordPress comments. The comment area is shown when you click the comment count bubbles (left or right) beside any section.

Demo and more information on the developer’s website: [kevinw.de/inline-comments](http://kevinw.de/inline-comments)

== Installation ==

1. Upload Inline Comments into you plugin directory (/wp-content/plugins/) and activate the plugin through the 'Plugins' menu in WordPress.
2. Configure the plugin via the admin backend.


== Frequently Asked Questions ==

= Why should I use Inline Comments? =
* Inline Comments are an innovative approach on how to display comments.
* It’s simply different from „traditional“ comments you see on every website.
* Commentators can better refer to specific paragraphs/statements in an article.
* Readers can comment while reading (and don’t have to scroll to the very bottom).

Demo and get more information on the developer’s website: [kevinw.de/inline-comments](http://kevinw.de/inline-comments)

= How can I change the formatting of the commentator’s currently selected section? =
For comment system "WordPress Comments", use custom CSS like this: 

*.incom-active { background: #f3f3f3; }*

= Where do I get my Disqus shortname from? =
First, you need an account and a registered site on disqus.com. Then read this: http://help.disqus.com/customer/portal/articles/466208-what-s-a-shortname-

= Known bugs =
* When you use Jetpack Comments, the comments will not be assigned to a specific paragraph. Anyhow, the comment will be displayed within your regular comment section with all other comments.

== Changelog ==

= 1.0.6 =
* New feature: Decide if bubbles should fade in/out or appear/disappear immediately
* New feature: You can make the comment bubbles to be always visible.
* New feature: Hide the permalink that’s displayed next to each comment

= 1.0.4 =
* If a comment bubble fits not completely on the screen, it will not be displayed

= 1.0.3 =
* Now it's possible to format active paragraphs/sections
* New feature: Select bubble style for sections with no comments yet (options: plain or bubble)

= 1.0 =
* Major update! Many improvements and new functionalities.
* This plugin now performs with native WordPress comments.
* Removed option “identifier” (users cannot choose their own identifier anymore)

= 0.8 =
* Plugin goes public (Disqus-only).


== Upgrade Notice ==

= 1.0 =
* This plugin now performs with native WordPress comments.

= 0.8 =
* Plugin goes public (only Disqus comment system is supported).


== Screenshots ==

1. Screenshot of a site that uses Inline Comments.
2. Comment count bubble on the right (visible when hovering the heading, requires custom selector "h1").
3. Comment area - visible after clicking on the bubble.
4. Comment area with option "Highlighting" enabled.
5. Options panel for admins “Basics” (version 1.0).
6. Options panel for admins “Styling” (version 1.0).