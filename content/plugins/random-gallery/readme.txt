=== Random Gallery ===
Contributors: David Greenwold 
Donate link: http://www.greenwold.com/web-projects/#random-gallery
Tags: gallery, tiled, random, truncate, list, media, pictures, photos
Requires at least: 3.0.1
Tested up to: 4.4
Stable tag: 00.02
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display a random selection of photos from an arbitrarily large list.

== Description ==

Give Random Gallery a list of photos and a number. It will pick that number of photos randomly from your list and send them off to a normal gallery. It works great with Jetpack's Tiled Galleries.

The easiest way to use Random Gallery is to insert a normal gallery into your page. Be sure to select all of the photos you want Random Gallery to draw from. In the editor, you'll see something like this:

[gallery ids="1,2,3,5,8,13,21"]

Then, all you have to do is change "gallery" to "random-gallery" and add shownum to the end, like this:

[random-gallery ids="1,2,3,5,8,13,21" shownum="3"]

You can also use the standard WP Gallery options: type, columns, size, and link.

In this example, there are seven photos in the list, but only three will be shown at a time.

There's nothing too fancy under the hood, so Random Gallery is pretty much future proof. Check it out and let me know what you think. Thanks!

== Installation ==

Drop random-gallery.php in the wp-content/plugins/ directory of your WordPress installation and activate it from the Plugins page.

== Frequently Asked Questions ==

= What if I have a question? =

I'd be happy to help! david.greenwold@gmail.com

= What if I have a suggestion? =

That would be most welcome! david.greenwold@gmail.com

= What if I find a bug? =

Please let me know right away! david.greenwold@gmail.com

== Changelog ==

= 00.02 =

Added support for type, columns, size, and link.

Miscellaneous code and documentation improvements.

Fixed bug that was forcing the gallery to the top of the page.

= 00.01 =

Added header and comments. Submitted to wp.

= 00.00 =

Just the code. Made for and deployed on client's website.