=== Google Maps Widget - Ultimate Google Maps Plugin ===
Contributors: WebFactory, GoogleMapsWidget
Tags: google maps, google map, gmap, maps, map widget, map markers, google maps plugin, wp google map, map plugin, map directions, google maps widget, map builder
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Requires at least: 4.0
Tested up to: 4.9
Stable tag: 3.85
Requires PHP: 5.2

Tired of broken Google Maps taking hours to setup? With Google Maps Widget you'll have a perfect map with a thumbnail & lightbox in minutes!

== Description ==

Tired of buggy & slow Google Maps plugins that take hours to setup? With Google Maps Widget you'll have a perfect map with a thumbnail & lightbox in minutes! **No nonsense maps - we know you're in a hurry!** Join 100,000+ happy Google Maps users.

[youtube https://www.youtube.com/watch?v=oVrTGKepPPI]

Check out some examples on the <a href="http://www.gmapswidget.com/">Google Maps Widget site</a> or give us a shout on Twitter <a href="http://twitter.com/WebFactoryLtd">@WebFactoryLtd</a>.


**General Google Maps Widget options**

* title
* address

**Thumbnail Google map options**

* map size - width & height
* map type - road, satellite, terrain & hybrid
* map color scheme - default, gowalla, refreshed, ultra light, mapbox + 11 extra & any custom map style in PRO
* zoom level
* pin type
* pin color
* pin size
* pin label
* custom pin icon - any image can be used
* 1500+ pins library in PRO
* link type - lightbox, custom URL, replace thumbnail with interactive map (PRO), immediately show interactive map (PRO) or disable link
* image format
* map language
* text above map
* text below map

**Interactive Google map options**

* lightbox size - width & height (auto-adjusted on smaller screens) or fullscreen in PRO
* map mode - place + in PRO: directions, search, view & street view
* map type - road & satellite
* map color scheme - 15 styles & any custom map style in PRO
* pins clustering - PRO feature
* zoom level
* lightbox skin - light, dark + 20 extra in PRO
* lightbox features - close on overlay click, close on esc key, close button & show map title
* map language
* header text
* footer text

**Shortcode**

* by using the _[gmw id="#"]_ shortcode you can display the google map in any page, post, or custom post type (PRO feature)

**Multiple Pins**

* full clustering and filtering support for pins on Google maps - <a href="http://www.gmapswidget.com/">demos</a> available on site
* you can add unlimited pins with custom markers and descriptions to thumbnail and interactive map (PRO feature)
* every map pin has the following options: show on thumbnail and/or interactive map, set custom pin image, set on-click behavior: open custom description bubble, open URL in new/same tab or do nothing


> > **PRO** version of Google Maps Widget offers more than 50 extra features and options including multiple pins support, clustering, pins library, skins, export, import and widget cloning features, Google Analytics integration and premium, USA based support. Install the plugin and try the PRO features 7 days for free! Features are activated instantly. Or read more about it on the <a href="http://www.gmapswidget.com/">official Google Maps Widget site</a>.


**Showcase & What others say about Google Maps Widget**

* see a live example of Google Maps Widget showing off server locations around the world on <a href="http://www.bitcatcha.com/">Bitcatcha</a>
* voted on the <a href="http://themesplugins.com/Plugin-detail/google-maps-widget-google-map-free-plugin-for-wordpress/" title="Top 100 WordPressian plugin">Top 100 List</a> by WordPressian
* made it on the <a href="http://tidyrepo.com/google-maps-widget/">Tidy Repo</a> list
* reviewed 5/5 by <a href="http://websmush.com/google-maps-widget-plugin-review/">Web Smush</a>
* one of 3 best google map plugins by <a href="http://torquemag.io/the-3-best-map-plugins-for-wordpress/">The Torque Mag</a>
* "an easier way to add Google maps to your site" says <a href="http://www.wpbeginner.com/wp-tutorials/how-to-add-google-maps-in-wordpress/">WP Beginner</a>
* <a href="http://designscrazed.org/wordpress-google-map-plugins/">Design Crazed</a> puts in on the top 20 Google maps list
* <a href="http://www.inkthemes.com/easily-integrate-google-map-in-your-wordpress-themes-widget-area/09/">InkThemes</a> shows how easy it is to use GMW
* <a href="http://www.indexwp.com/google-maps-widget/">IndexWP</a> calls it a "handy map plugin"


**Translators (thank you!)**

* English - original :)
* Swedish - Sofia Asklund
* Spanish - Jesus Garica
* Croatian - Gordan from <a href="http://www.webfactoryltd.com/">Web factory Ltd</a>
* German - Karimba
* French - Karimba
* Chinese simplified  - Wyeoh
* Chinese traditional - Wyeoh
* Dutch - Arno
* Ukrainian - Victor Shutovskiy
* Serbian - Ogi Djuraskovic from <a href="http://firstsiteguide.com/">FirstSiteGuide</a>
* Russian - Ivanka


**License info**

* <a href="https://select2.github.io/">Select2 v4</a>, licensed under MIT
* <a href="http://www.jacklmoore.com/colorbox">Colorbox 1.6</a>, licensed under MIT


== Installation ==

**Follow the usual routine**

1. Open WordPress admin, go to Plugins, click Add New
2. Enter "Google Maps Widget" in search and hit Enter
3. Plugin will show up as the first on the list, click "Install Now"
4. Activate & go to Appearance - Widgets to configure

**Or if needed, upload manually**

1. Download the plugin.
2. Unzip it and upload to _wp-content/plugin/_
3. Open WordPress admin - Plugins and click "Activate" next to the plugin
4. Configure the plugin under Appearance - Widgets


== Frequently Asked Questions ==

= Who is this plugin for? =

For anyone who needs a map on their site in 5 seconds.

= Map shows the wrong location =

Write the address differently, or more precisely. Make sure you enter the street, town and country name. If necessary enter lat/lng coordinates instead of the address. Use the numeric notation, eg: "40.7127, 74.0059"

= How to generate the API key =

We understand that creating an API key is frustrating but it takes less than a minute and it's something Google requires.
Follow <a href="https://console.developers.google.com/flows/enableapi?apiid=maps_embed_backend&keyType=CLIENT_SIDE&reusekey=true" target="_blank">wizard step #1</a> - login with any Gmail account, click next/confirm a few times with the default settings &amp; copy the key you see on the screen; it's the key you need. Then use <a href="https://console.developers.google.com/flows/enableapi?apiid=static_maps_backend&keyType=CLIENT_SIDE&reusekey=true" target="_blank">wizard step #2</a>, select the same "My Project" project from the list and that's it. Save the key in GMW settings.
If you want to protect your API key by using the "Accept requests from these HTTP referrers (web sites)" option in Google Console make sure to add your domain in these two formats: `*.mydomain.com/*` and `mydomain.com/*` and wait a few minutes until Google makes the necessary changes.

= Thumbnail map works but lightbox won't open on click =

You probably have Fancybox JS and CSS files included twice; once by the theme and second time by GMW plugin. Remove one instance of files. If that's not the case then you have a fatal JS error that's preventing execution of other JS code. Hit F12 in Firefox or Chrome and have a look at the debug console. If there are any red lines - it's a fatal error.
Open a new thread in the <a href="http://wordpress.org/support/plugin/google-maps-widget">support forums</a> but please bear in mind that support is community based and we do this in our spare time.

= It's not working!!! Arrrrrrrrr =

Read the <a href="http://wordpress.org/support/plugin/google-maps-widget">support forum</a> rules (no seriously, read them) and then if needed open new a thread.

== Screenshots ==

1. Simple & fast - you'll have a great map working in under a minute
2. Thumbnail map is shown as a widget and since it's just one image it loads super-fast (1 request, about 20KB)
3. Larger map with all interactive features is available in the lightbox
4. Widget options - Thumbnail map
5. Widget options - Interactive map
6. Widget options - Shortcode
7. Thumbnail map - light color scheme

== Changelog ==

= 3.85 =
* 2018/05/03
* added Bright thumbnail color scheme

= 3.83 =
* 2018/02/26
* pushing strong on translations!
* added Gowalla thumbnail color scheme

= 3.80 =
* 2018/02/07
* translations are going great thanks to our helpful users!
* problems with API keys continue due to users who refuse to create their own keys :(

= 3.75 =
* 2017/12/25
* continuing with translation efforts
* added Mapbox thumbnail color scheme
* plugin name changed to test for better search position
* lower agency price from 08/01/2017

= 3.70 =
* 2017/12/05
* Russian translation is at 100%
* continuing with translation efforts
* fixed a few small JS bugs

= 3.65 =
* 2017/11/17
* updates for WP 4.9
* continuing with translation

= 3.60 =
* 2017/09/04
* minor improvements
* new pricing table

= 3.58 =
* 2017/07/11
* fixed bug on <img> width & height

= 3.55 =
* 2017/05/08
* minor bug fixes
* trial is no longer available from the plugin

= 3.50 =
* 2017/02/17
* minor bug fixes
* lower PRO prices

= 3.49 =
* 2017/01/16
* minor bug fixes

= 3.47 =
* 2017/01/03
* minor bug fixes
* API improvements

= 3.45 =
* 2016/10/24
* new prices, trial 14 days
* welcome pointer added
* minor bug fixes

= 3.40 =
* 2016/08/21
* minor bug fixes
* changes in prices for PRO

= 3.39 =
* 2016/07/10
* fix for "over quota limit" error some users were getting

= 3.38 =
* 2016/06/23
* just a few bug fixes

= 3.36 =
* 2016/05/11
* minor bug fixes

= 3.35 =
* 2016/04/30
* bug fixes
* new static map color scheme
* big cleanup - plugin footprint reduced by half

= 3.30 =
* 2016/04/14
* bug fixes
* WP v4.5 updates

= 3.25 =
* 2016/03/24
* even more new map pins
* bug fixes
* 7 days trial can now be activated within the plugin

= 3.20 =
* 2016/03/10
* new map pins
* bug fixes

= 3.15 =
* 2016/03/07
* widgets can now be cloned
* minor fixes

= 3.10 =
* 2016/02/23
* security enhancements

= 3.05 =
* 2016/02/19
* few minor bug fixes
* added google maps API key tester

= 3.04 =
* 2016/02/17
* added more detailed instructions on how to generate the API key
* few minor bug fixes

= 3.0 =
* 2016/02/16
* huge upgrade - numerous functions added
* switched to new Google Maps API

= 2.92 =
* 2016/01/14
* we made it to 100 thousand active installations ;)
* minor bug fixes

= 2.90 =
* 2015/12/14
* added option for donating
* checked WP v4.4 compatibility

= 2.85 =
* 2015/12/02
* enhancements in PHP

= 2.80 =
* 2015/11/18
* fixed a big bug in JS (widget admin UI init)

= 2.75 =
* 2015/10/26
* minor JS tweaks and bug fixes

= 2.70 =
* 2015/10/12
* fixed a nasty bug with shortcode rendering (thanks Hey You!)
* JS and CSS fixes for widget UI in the theme customizer

= 2.66 =
* 2015/10/05
* minor bug fixes
* we'll be soon removing all PO files from the plugin since the strings were merged into the official WP translate project

= 2.60 =
* 2015/08/31
* added data validation on input fields
* minor CSS tweaks

= 2.51 =
* 2015/07/27
* updated PHP4 style class constructor to PHP5 one
* lowered cron for tracking to once every 14 days
* did some prep work for the upcoming 4.3 version of WP

= 2.45 =
* 2015/06/15
* fixed a bug on notice dismiss action
* added Russian translation - thanks Ivanka!

= 2.40 =
* 2015/05/25
* few small bugs fixed
* admin JS completely rebuilt
* fixed PO file
* we broke 90,000 installations ;)

= 2.35 =
* 2015/04/27
* few small bugs fixed
* WP v4.2 compatibility checked
* remove_query_arg() security issue fixed
* we broke 500,000 downloads ;)

= 2.30 =
* 2015/03/02
* JS rewrites
* few small bugs fixed

= 2.25 =
* 2015/02/23
* a few visual enhancements
* new screenshots
* shortcode name availability is checked before registering it
* visual builder compatibility fix

= 2.20 =
* 2015/02/16
* added shortcode support

= 2.15 =
* 2015/02/09
* fixed a _plugin_deactivate_ bug nobody noticed for 2 years :(
* all JS texts are now loaded via wp_localize_script()

= 2.10 =
* 2015/02/02
* auto-adjust map size on smaller screens - thanks bruzm!
* marked each widget with core version for future updates

= 2.06 =
* 2015/01/26
* language file updated
* preparing for JS rewrite

= 2.05 =
* 2015/01/19
* code rewriting
* minor bug fixes

= 2.01 =
* 2015/01/13
* somehow one JS file got renamed :(

= 2.0 =
* 2015/01/13
* lots of rewrites
* additional features can now be activated by subscribing to our newsletter

= 1.95 =
* 2014/12/19
* minor WP v4.1 updates

= 1.93 =
* 2014/12/03
* we can no longer offer discounts for our Envato products in GMW
* so no changes to the plugin, just some messages edited

= 1.92 =
* 2014/11/12
* minor bug fixes
* preparations for admin JS rewrite

= 1.90 =
* 2014/10/20
* added Serbian translation; thanks Ogi!

= 1.86 =
* 2014/10/12
* updated POT file
* updated Croatian translation

= 1.85 =
* 2014/09/22
* added custom pin image option for thumbnail map - thanks Rudloff!

= 1.80 =
* 2014/09/08
* minor updates for WordPress v4.0

= 1.75 =
* 2014/07/29
* lightbox skins are back; light and dark for now, more coming soon
* updated lightbox jS

= 1.70 =
* 2014/07/10
* fixed a small bug on thumbnail
* finished up a todo

= 1.65 =
* 2014/05/06
* finished up a few todos

= 1.60 =
* 2014/04/17
* update for WordPress v3.9, widget edit GUI now works in theme customizer
* if you run into any issues please report them in the support forums

= 1.55 =
* 2014/04/07
* fixed shortcode handling in map's header & footer
* added Ukrainian translation - thank you Victor Shutovskiy!

= 1.50 =
* 2014/03/25
* minor bug fixes
* new Spanish translation - thank you Jesus!
* still working on those lightbox skins, sorry :(

= 1.47 =
* 2014/03/05
* minor bug fix
* working on those lightbox skins :)

= 1.45 =
* 2014/03/04
* switched to <a href="http://www.jacklmoore.com/colorbox/">Colorbox</a> lightbox script
* lightbox skin is still temporarily unavailable

= 1.40 =
* 2014/02/10
* due to licensing issues switched to FancyBox v1.3.4
* lightbox skin is temporarily unavailable
* minor bug fix related to activate/upgrade hook calls

= 1.35 =
* 2014/02/05
* added optional plugin usage tracking (<a href="http://www.gmapswidget.com/plugin-tracking-info/">detailed info</a>)

= 1.31 =
* 2014/02/03
* WP v3.8.1 compatibility check

= 1.30 =
* 2014/01/16
* added Dutch translation; thank you Arno!

= 1.25 =
* 2014/01/03
* preparations for opt-in plugin usage tracking
* Spanish translation updated; thanks Jesus!

= 1.20 =
* 2013/12/17
* WP v3.8 update
* language files update

= 1.15 =
* 2013/11/25
* added option for thumbnail map to link to a custom URL which disables the lightbox; you can link to a lightbox, a custom link or remove the link all together

= 1.10 =
* 2013/11/18
* added option for thumbnail map to use the new look/color scheme

= 1.05 =
* 2013/11/04
* added Chinese traditional translation; thanks Wyeoh

= 1.0 =
* 2013/10/28
* WP 3.7 compatibility check
* added Chinese simplified translation; thanks Wyeoh

= 0.95 =
* 2013/10/21
* added French translation; thanks Karimba

= 0.90 =
* 2013/10/14
* added German translation; thanks Karimba
* we reached 100k downloads ;)

= 0.86 =
* 2013/10/07
* fixed a few strict standards errors; thanks Jay!

= 0.85 =
* 2013/10/03
* added Croatian translation; thank you Gordan

= 0.80 =
* 2013/09/28
* minor translation fixes
* added Spanish translation; thank you Jesus!

= 0.75 =
* 2013/09/24
* map language is autodetected based on user's browser language (HTTP_ACCEPT_LANGUAGE header)
* added Swedish translation; thank you Sofia!
* German and Croatian translations will be up next

= 0.71 =
* 2013/09/17
* few more preparations for translation
* Swedish translation coming in a few days

= 0.70 =
* 2013/09/05
* prepared everything for translation, POT file is available and all strings are wrapped in <i>__()</i>
* protocols should now match http/https for both thumbnail and ligtbox map
* <a href="http://www.gmapswidget.com/">www.gmapswidget.com</a> is up and running

= 0.65 =
* 2013/08/05
* updated JS for WP v3.6

= 0.60 =
* 2013/04/06
* fixed zoom bug in lightbox

= 0.55 =
* 2013/04/05
* added 2 new options - text above and below thumbnail map
* updated fancyBox JS to the latest version
* minor code improvements

= 0.50 =
* 2012/12/12
* small WP 3.5 compatibility fixes

= 0.41 =
* 2012/12/03
* removed screenshots from plugin package

= 0.4 =
* 2012/11/28
* fixed non UTF-8 address bug

= 0.37 =
* 2012/11/19
* fixed bug to use google.com instead of google.co.uk

= 0.35 =
* 2012/09/28
* added 4 skins for lightbox

= 0.31 =
* 2012/09/14
* fix for bad themes which don't respect proper sidebar markup

= 0.3 =
* 2012/09/04
* lightbox script changed from jQuery UI Dialog to <a href="http://fancyapps.com/fancybox/">fancyBox2</a>
* added "show map title on lightbox" option
* significant speed improvements
* preparations for lightbox skins

= 0.22 =
* 2012/08/31
* Fixed small JS related GUI bug

= 0.2 =
* 2012/08/28
* Complete GUI rewrite
* Added header text option
* Added address bubble visibility option
* Fixed thumbnail map scaling bug
* Fixed lightbox map size bug

= 0.13 =
* 2012/08/09
* Added pin size for thumbnail map

= 0.12 =
* 2012/08/07
* Added pin color for thumbnail map
* Fixed a few minor bugs

= 0.11 =
* 2012/08/06
* Fixed a few minor bugs

= 0.1 =
* 2012/08/03
* Initial release