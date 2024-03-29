=== iframe ===
Contributors: webvitaly
Donate link: http://web-profile.com.ua/donate/
Tags: iframe, embed, youtube, vimeo, google-map, google-maps
Requires at least: 3.0
Tested up to: 3.5
Stable tag: 2.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

[iframe src="http://player.vimeo.com/video/819138" width="100%" height="480"] shortcode

== Description ==

Use iframe to embed video from YouTube or Vimeo or to embed Google Map or just to embed content from external page.

Embed iframe using shortcode `[iframe src="http://player.vimeo.com/video/819138" width="100%" height="480"]`

**[All iframe params](http://wordpress.org/extend/plugins/iframe/other_notes/)**

[iframe support page](http://web-profile.com.ua/wordpress/plugins/iframe/)

= Useful plugins: =
* ["Page-list" - show list of pages with shortcodes](http://wordpress.org/extend/plugins/page-list/ "list of pages with shortcodes")
* ["Anti-spam" - block spam in comments](http://wordpress.org/extend/plugins/anti-spam/ "no spam, no captcha")
* ["Filenames to latin" - sanitize filenames to latin during upload](http://wordpress.org/extend/plugins/filenames-to-latin/ "sanitize filenames to latin")

== Other Notes ==

= Iframe params: =
* **src** - source of the iframe `[iframe src="http://player.vimeo.com/video/819138"]` (by default src="http://player.vimeo.com/video/819138");
* **width** - width in pixels or in percents `[iframe width="100%" src="http://player.vimeo.com/video/819138"]` or `[iframe width="640" src="http://player.vimeo.com/video/819138"]` (by default width="100%");
* **height** - height in pixels `[iframe height="480" src="http://player.vimeo.com/video/819138"]` (by default height="480");
* **scrolling** - parameter `[iframe scrolling="yes"]` (by default scrolling="no");
* **frameborder** - parameter `[iframe frameborder="0"]` (by default frameborder="0");
* **marginheight** - parameter `[iframe marginheight="0"]` (removed by default);
* **marginwidth** - parameter `[iframe marginwidth="0"]` (removed by default);
* **allowtransparency** - allows to set transparency of the iframe `[iframe allowtransparency="true"]` (removed by default);
* **id** - allows to add the id of the iframe `[iframe id="my-id"]` (removed by default);
* **class** - allows to add the class of the iframe `[iframe class="my-class"]` (by default class="iframe-class");
* **style** - allows to add the css styles of the iframe `[iframe style="margin-left:-30px;"]` (removed by default);
* **same_height_as** - allows to set the height of iframe same as target element `[iframe same_height_as="body"]`, `[iframe same_height_as="div.sidebar"]`, `[iframe same_height_as="div#content"]`, `[iframe same_height_as="window"]` - iframe will have the height of the viewport (visible area), `[iframe same_height_as="document"]` - iframe will have the height of the document, `[iframe same_height_as="content"]` - auto-height feature, so the height of the iframe will be the same as embedded content. [same_height_as="content"] works only with the same domain and subdomain. Will not work if you want to embed page "sub.site.com" on page "site.com". (removed by default);
* **get_params_from_url** - allows to add GET params from url to the src of iframe; Example: page url - `site.com/?prm1=11`, shortcode - `[iframe src="embed.com" get_params_from_url="1"]`, iframe src - `embed.com?prm1=11` (disabled by default);
* **any_other_param** - allows to add new parameter of the iframe `[iframe any_other_param="any_value"]`;
* **any_other_empty_param** - allows to add new empty parameter of the iframe (like "allowfullscreen" on youtube) `[iframe any_other_empty_param=""]`;

== Screenshots ==

1. [iframe] shortcode

== Changelog ==

= 2.5 - 2012-11-03 =
* added 'get_params_from_url' (thanks to Nathanael Majoros)

= 2.4 - 2012-10-31 =
* minor changes

= 2.3 - 2012.09.09 =
* small fixes
* added (src="http://player.vimeo.com/video/819138") by default

= 2.2 =
* fixed bug (Notice: Undefined index: same_height_as)

= 2.1 =
* added (frameborder="0") by default

= 2.0 =
* plugin core rebuild (thanks to Gregg Tavares)
* remove not setted params except the defaults
* added support for all params, which user will set
* added support for empty params (like "allowfullscreen" on youtube)

= 1.8 =
* Added style parameter

= 1.7 =
* Fixing minor bugs

= 1.6.0 =
* Added auto-height feature (thanks to Willem Veelenturf)

= 1.5.0 =
* Using native jQuery from include directory
* Improved "same_height_as" parameter

= 1.4.0 =
* Added "same_height_as" parameter

= 1.3.0 =
* Added "id" and "class" parameters

= 1.2.0 =
* Added "output=embed" fix to Google Map

= 1.1.0 =
* Parameter allowtransparency added (thanks to Kent)

= 1.0.0 =
* Initial release

== Installation ==

1. install and activate the plugin on the Plugins page
2. add shortcode `[iframe src="http://player.vimeo.com/video/819138" width="100%" height="480"]` to page or post content
