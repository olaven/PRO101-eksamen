# Sticky Menu (or Anything!) on Scroll
* Contributors: senff
* Donate link: http://www.senff.com/donate
* Tags: sticky header, sticky menu, sticky, header, menu
* Plugin URI: http://www.senff.com/plugins/sticky-anything-wp
* Requires at least: 3.6
* Tested up to: 4.9
* Stable tag: 2.1.1
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html

Sticky Menu (Or Anything) On Scroll will let you choose any element on your page that will be "sticky" at the top once you scroll down.

## Description

### Summary

The Sticky Menu (Or Anything) On Scroll plugin for WordPress allows you to make any element on your pages "sticky" as soon as it hits the top of the page when you scroll down. Although this is commonly used to keep menus at the top of your page, the plugin allows you to make ANY element sticky (such as a Call To Action box, a logo, etc.)

A little bit of basic HTML/CSS knowledge is required. You just need to know how to pick the right selector for the element you want to make sticky, and you need to be sure it's a unique selector. Sometimes a simple selector like "nav", "#main-menu", ".menu-main-menu-1" is enough. Other times you will have to be more detailed and use a more specific selector such as "header > ul:first-child" or "nav.top .menu-header ul.main".

### Features

* **Any element can stick**: although common use is for navigation menus, the plugin will let you pick any unique element with a name, class or ID to stick at the top of the page once you scroll past it. Use it for a sidebar, Call-to-action box, banner ad, etc.
* **Positioning from top**: optionally, you can add any amount of space between the sticky element and the top of the page, so that the element is not always stuck at the "ceiling" of the page.
* **Enable for certain screen sizes only**: optionally, you can set a minimum and/or maximum screen size where the stickiness should work. This can be handy if you have a responsive site and you don't want your element to be sticky on smaller screens, for example. 
* **Push-up element**: optionally, you can pick any other element lower on the page that will push the sticky element up again (for example a sidebar widget).
* **Admin Bar aware**: checks if the current user has an Admin Toolbar at the top of the page. If it has, the sticky element will not obscure it (or be obscured by it).
* **Z-index**: in case there are other elements on the page that obscure or peek through your sticky element, you can add a Z-index easily.
* **Legacy Mode**: in 2.0, a new method of making things sticky was introduced. In Legacy Mode, the old method will be used. See FAQ for details.
* **Dynamic Mode**: some issues that frequently appear in responsive themes have been address by adding a Dynamic Mode (Legacy Mode only). See FAQ for details.
* **Debug Mode:** find out possible reasons why your element doesn't stick by switching on Debug Mode, and error messages will appear in your browser's console.


## Installation 

1. Upload the "sticky-menu-or-anything" directory to your "wp-content/plugins" directory.
2. In your WordPress admin, go to PLUGINS and activate "Sticky Menu (or Anything!)"
3. Go to SETTINGS - STICKY MENU (OR ANYTHING!)
4. Pick the element you want to make sticky
5. Party!

## Frequently Asked Questions

### I selected a class/ID in the settings screen, but the element doesn't stick when I scroll down. Why not?
First, make sure that if you select the element by its classname, it is preceded by a dot (e.g. `.main-menu`), and if you select it by its ID, that it's preceded by a pound/hash/number sign (e.g. `#main-menu`). Also, make sure there is only ONE element on the page with the selector you're using. If there is none, or more than one element that matches your selector, nothing will happen.

### Once the element becomes sticky, it's not positioned/sized properly at all.
Due to the nature of CSS, there are situations where an element will not stick properly, usually if it has specific properties that are used to manipulate its location and/or dimensions. If your sticky element has any of the following properties, this could cause conflicts:

- negative margins
- absolute positioning
- top/left/bottom/right properties
- `display: inline`
- `!important` applied to any of its properties

Try to avoid all this where possible, but if you can't, using the plugin in Legacy Mode (see below) helps sometimes.
Another situation that can cause trouble, is when any parent of your sticky element has the `transform` CSS property applied to it.

### Once the element becomes sticky, it's not responsive and doesn't resize when I change the browser size.
This is a known (and annoying) bug in the plugin that I haven't been able to solve properly yet. For some sites (when the element does not contain any Javascript interactivity, usually), it sometimes helps to use the plugin in Legacy Mode (see below).

### Is it possible to add some styles to the element but only when it's sticky?
To add styles to your sticky element when it's not sticky, use classname `.element-is-not-sticky`.
To add styles to your sticky element only when it's sticky, use classname `.element-is-sticky`.

The following code would give your element a red background when it's not sticky, and blue when it is:

```
.element-is-not-sticky {
   background: red;
   }

.element-is-sticky {
   background: blue;
   }
```

### Once the element becomes sticky, there's a brief moment where you see it twice.
If you're using the plugin in Legacy Mode (see below), this happens when the sticky element (or any of its contents) has a CSS transition applied to it. Because the original element becomes invisible (and a cloned copy of it becomes visible), the visible-to-invisible status change will take place with a transition (ie. not instantly). Either remove any of the transitions the element has, or try disabling the Legacy Mode.

### My menu sticks, but it doesn't open on the Responsive theme when it's sticky.
This was a bug in pre-2.0 versions, and an incompatibility with the theme. It has been fixed in 2.0, but in Legacy Mode, this bug is still present. If you need to enable Legacy Mode for some reason, it would be better to turn off stickiness for the mobile menu (set "Do not stick element when screen smaller than:" to 651 pixels).

### I have another plugin called Easy Smooth Scroll Links, but once my menu becomes sticky, that one doesn't work anymore.
This was a bug in pre-2.0 versions, and an incompatibility with the plugin. It has been fixed in 2.0, but in Legacy Mode, this bug is still present. If you need Legacy Mode enabled for some reason, there is no fix for this bug, however there is an alternative workaround. According to reports from users who had this issue, a plugin called Page Scroll To ID is a worthy alternative to Easy Smooth Scroll Links and works with the Sticky Anything plugin in Legacy Mode.

### Still doesn't work. What could be wrong?
Check the "Debug Mode" checkbox in the plugin's settings. Reload the page and you may see errors in your browser's console window. If you've used a selector that doesn't exist, OR there are more of them on the page, you will be notified of that in the console.

### Is it possible to have multiple sticky elements?
The current version only allows one sticky element, but this functionality will be implemented in the next major version. No expected release date, though.

### What is Legacy Mode? Should I use it?
In version 2.0 of the plugin, a new/better method for making elements sticky was introduced. Before this, a sticky element would essentially be a cloned copy of the original element. Now, the element itself becomes sticky and doesn't use copying and cloning anymore, which solves a lot of issues.

So, should you use it or not? Well, if you upgraded this plugin from an earlier version, Legacy Mode will be turned ON by default, because chances are that the old method worked perfectly fine for your site. If that's the case, there is not really a need to use the new method and you can just continue using the old, classic method. If it ain't broke, don't fix it, right?

Having said that, it's worth checking if your element works just as well with Legacy Mode turned OFF, since this is the "better" method. Just give it a quick try. If it doesn't work, you can always just go back and enable it again.

NOTE: new installs of the plugin will have the Legacy Mode turned off by default. Only UPGRADES from 1.4 (or before) should have it turned on by default.

### What is this Dynamic Mode thing exactly?
This mode is only available in Legacy Mode, and to properly explain this, we'll need to go a little deeper in the plugin's functionality. So bear with me...

In Legacy Mode, when an element becomes sticky at the top of the page (and keeps its place regardless of the scrolling), it's actually not the element itself you see, but a cloned copy of it, while the actuak original element is out of view and invisible.

The original element always stays where it originally is on the page, while the cloned element is always at the top of the browser viewport screen. However, you will never see them both at the same time; depending on your scroll position, it always just shows either one or the other.

In the original plugin version, the clone would be created right the moment when you load the page (but not visible right away). Then when you would scroll down, it would become visible (and stick at the top), while the original element would disappear from view.

However, some themes use JavaScript to dynamically create elements (menus, mostly) for mobile sites. With this method, a menu doesn't exist in the HTML source code when you load the page, but is created some time after the page is fully loaded -- in many cases, these menus would just be generated ONLY when the screen is more (or less) than a certain specific width. With the original version of the plugin, the problem would be that the original element (that you want to make sticky) may not have been fully created upon page load, so the clone would also not be fully functional.

Enter Dynamic Mode. Now, a clone of the element is not created on page load -- instead, it's only created when the user scrolls and hits the "sticky" point. This ensures that the cloned element is an actual 1-on-1 copy of what the original element consists of at that specific point in time (and not at the "page is loaded" point, which may be different if the element was altered since).

Why don't we use Dynamic Mode all the time then? This has to do with the fact that other plugins initialize themselves on page load and may need the full markup (including the cloned element) at that point. In Dynamic Mode, there is no clone available yet on page load, so that could cause an issue if that other plugin is looking for an element that doesn't exist yet.

(This may all sound terribly confusing. And it is! So, much work was done to fix this nonsense: since v2.0 of the plugin, a whole different method is being used to make elements sticky, and Dynamic Mode is not even an issue anymore.)

Phew!

### I'll need more help please!
Please go to the plugin's [support forum on WordPress.org](https://wordpress.org/support/plugin/sticky-menu-or-anything-on-scroll) and post a message (include a link to your site if possible). Response time is usually within a few hours maximum.

### I need some functionality that the plugin currently doesn't support. Can you help make a custom version?
If the customization is fairly minor, I can probably help out right away. However, if the requested customization is of a more complex nature, I won't be able to do it quickly/free and it may take a number of hours. If you're interested in that, please go to the plugin's [support forum on WordPress.org](https://wordpress.org/support/plugin/sticky-menu-or-anything-on-scroll) and let me know that you'll need some custom work (include a link to your site if possible). 


## Screenshots

1. Basic settings screen
2. Advanced settings screen


## Changelog

### 2.1.1
* Fixed minification bug

### 2.1
* Sticky element has specific classes to target sticky/non-sticky state: ".element-is-sticky" and ".element-is-not-sticky"

### 2.0.1
* fixed padding calculation bug (percentages are off when sticky)
* fixed bug where assigned styles loop caused JS error

### 2.0
* Introduced a new/better method for making elements sticky
* Added Legacy Mode (for those who want to continue the old method)
* Split up settings screen in Basic and Advanced
* Debug mode uses uncompressed JS file for easier remote debugging

### 1.4 
* Removed error notification if no pushup-element is selected
* Renaming class "cloned" to "sticky-element-cloned" and "original" to "sticky-element-original" to avoid conflicts with Owl Carousel
* Fixed bug where cloned element width would be rounded down if it contained sub-pixels

### 1.3.1 
* Minor bug fix for push-up element

### 1.3 
* Added functionality to move sticky element down in case there is an Administrator Toolbar at the top of the page
* Added functionality to push sticky element up by another element lower down the page

### 1.2.4 
* Fixed small bug related to version number

### 1.2.3 
* Bug with Dynamic Mode select box/label fixed
* Bug with Z-index fixed (thanks @aguseo for reporting)
* All text in plugin fully translatable
* Added FAQ tab to settings screen
* Added infobox to settings screen
* Added a few comments to source code

### 1.2
* Dynamic Mode added (addressing problems with dynamically created menus -- see Frequently Asked Questions above for details)

### 1.1.4
* Ready for WordPress 4.1 (and TwentyFifteen)
* Fixes issue when element has padding in percentages

### 1.1.3
* Fixes width calculation bug introduced in previous version (sorry about that), box sizing now supported

### 1.1.2
* Fixes element width calculation bug

### 1.1.1
* Fixes viewport calculation bug

### 1.1
* Added functionality for optional minimum/maximum screen size

### 1.0 
* Initial release (using v1.1 of the standalone jQuery plugin)


## Upgrade Notice 

## 2.1.1
* Bug fixes

## 2.1 
* Functionality for targeting sticky/non-sticky classnames added

## 2.0.1 
* A few small bug fixes

## 2.0
* Bug fixes and new/better method of making elements sticky

## 1.4
* Couple of bug fixes

### 1.3.1
* Minor bug fix for push-up element

### 1.3
* BY POPULAR DEMAND: functionalities added related to Administrator Toolbar and element that can push sticky element up

### 1.2.4
* Minor bugfix

### 1.2.3
* Bugfixes, improvements and translation-ready

### 1.2
* Dynamic Mode added

### 1.1.4
* Bugfixes, ready for WordPress 4.1 (and TwentyFifteen)

### 1.1.3
* Bugfix for new bug introduced in 1.1.2

### 1.1.2
* Bugfixes

### 1.1.1
* Bugfixes

### 1.1
* Added functionality (minimum and/or maximum screen size)

### 1.0
* Initial release of the plugin