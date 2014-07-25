=== SS Device Detector ===
Contributors: vladiiancu, peterbuga
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=vladi%2eiancu%40gmail%2ecom&lc=RO&item_name=WordPress%20Plugin&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: responsive, shortcode, content, adaptive, RESS
Requires at least: 3.0.1
Tested up to: 3.9
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin that detects the device used by visitors and provides functions and shortcodes to display (or not) content based on said devices.

== Description ==

The purpose of the plugin is to help both WordPress users and developers with shortcodes and function respectevly, to implement a server side responsive solution for their theme. 
The difference is substantial compared to solutions like ` display:none `. When using the "display" CSS instruction on, let's say, an image, the browser actually downloads the entire image and then it hides it. With this solution the image is no longer downloaded. 
SS comes from 'server-side'.

== Installation ==

This section describes how to install the plugin and get it working.

1. Activate the plugin (SS Device Detector) through the 'Plugins' menu in WordPress.
2. Once activated you can use the shortcodes and functions provided by the plugin (see documentation).

== Frequently Asked Questions ==

= What shortcodes are available? =

You can use ` [stp_phone]Content here...[/stp_phone] `, ` [stp_tablet]Content for tablet...[/stp_tablet] `, ` [stp_desktop]Content for desktop...[/stp_desktop] ` and ` [stp_mobile] Content for phones and tablets alike [/stp_mobile] `. 

= What functions are available? =

You can use:
- ` stp_phone() ` returns true if the users are using a phone to view the content, while ` stp_notphone() ` returns true if the user is NOT using a phone to view the content;
- ` stp_tablet() ` returns true if the users are using a tablet to view the content.  Vice-versa `stp_nottablet()`;
- ` stp_desktop() ` returns true for desktop users. You get it by now. Aliases: `stp_notdevice()` and `stp_notmobile()`;
- ` stp_mobile() ` returns true for phone and tablet users. 


== Changelog ==

= 1.0 =
* Initial version.


== Bugs, suggestions, comments? ==

If you would like to report bugs, to make a suggestion or a simple comment you can write us at support@siteup.org.uk 
Please include the name of plugin either in the subject or in your email body.
Thank you. 

