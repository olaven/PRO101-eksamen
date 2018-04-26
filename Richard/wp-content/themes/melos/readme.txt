=== Melos ===
Contributors: thinkupthemes
Requires at least: 4.6
Tested up to: 4.9.4
Version: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: black, dark, orange, red, blue, one-column, two-columns, three-columns, right-sidebar, left-sidebar, fixed-layout, responsive-layout, fluid-layout, custom-header, custom-menu, full-width-template, theme-options, threaded-comments, featured-images, post-formats, sticky-post, translation-ready, flexible-header, gray, light, white, custom-background, grid-layout, footer-widgets, blog, e-commerce, education, entertainment, news, photography, portfolio


== Description ==

Melos is the free version of the multi-purpose professional theme (Melos Pro) ideal for a business or blog website. The theme has a responsive layout, HD retina ready and comes with a powerful theme options panel with can be used to make awesome changes without touching any code. The theme also comes with a full width easy to use slider. Easily add a logo to your site and create a beautiful homepage using the built-in homepage layout.


== Installation ==

1. In your admin panel, go to Appearance -> Themes and click the 'Add New' button.
2. Type in Melos in the search form and press the 'Enter' key on your keyboard.
3. Click on the 'Activate' button to use your new theme right away.
4. Go to Appearance - About Melos in the admin area of your website for a guide on how to customize this theme.
5. Navigate to Appearance > Customize in your admin panel and customize to taste.


== Frequently Asked Questions ==

For support for Melos (free) please post a support ticket over at the https://wordpress.org/support/theme/melos.


== Limitations ==

Limitations will be added when raised.


== Copyright ==

Melos WordPress Theme, Copyright 2017 Think Up Themes Ltd
Melos is distributed under the terms of the GNU GPL

The following opensource projects, graphics, fonts, API's or other files as listed have been used in developing this theme. Thanks to the author for the creative work they made. All creative works are licensed as being GPL or GPL compatible.

    [1.01] Item:        Underscores (_s) starter theme - Copyright: Automattic, automattic.com
           Item URL:    http://underscores.me/
           Licence:     Licensed under GPLv2 or later
           Licence URL: http://www.gnu.org/licenses/gpl.html

    [1.02] Item:        Redux Framework
           Item URL:    https://github.com/ReduxFramework/ReduxFramework
           Licence:     GPLv3
           Licence URL: http://www.gnu.org/licenses/gpl.html

    [1.03] Item:        PrettyPhoto
           Item URL:    http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/
           Licence:     GPLv2
           Licence URL: http://www.gnu.org/licenses/gpl-2.0.html

    [1.04] Item:        Masonry
           Item URL:    https://github.com/desandro/masonry
           Licence:     MIT
           Licence URL: http://opensource.org/licenses/mit-license.html

    [1.05] Item:        ImagesLoaded
           Item URL:    https://github.com/desandro/imagesloaded
           Licence:     MIT
           Licence URL: http://opensource.org/licenses/mit-license.html

    [1.06] Item:        Retina js
           Item URL:    http://retinajs.com
           Licence:     MIT
           Licence URL: http://opensource.org/licenses/mit-license.html

    [1.07] Item:        ResponsiveSlides
           Item URL:    https://github.com/viljamis/ResponsiveSlides.js
           Licence:     MIT
           Licence URL: http://opensource.org/licenses/mit-license.html

    [1.08] Item:        Font Awesome
           Item URL:    http://fortawesome.github.io/Font-Awesome/#license
           Licence:     SIL Open Font &  MIT
           Licence OFL: http://scripts.sil.org/cms/scripts/page.php?site_id=nrsi&id=OFL
           Licence MIT: http://opensource.org/licenses/mit-license.html

    [1.09] Item:        Twitter Bootstrap (including images)
           Item URL:    https://github.com/twitter/bootstrap/wiki/License
           Licence:     Apache 2.0
           Licence URL: http://www.apache.org/licenses/LICENSE-2.0


== Changelog ==

= 1.2.1
- Updated: Improved escaping in function thinkup_title_select() to ensure page title displays correctly.
- Updated: Function thinkup_title_select_cpt() added remove "archive" text from custom post type archive pages.

= 1.2.0
- Updated: Readme file updated to ensure format is consistent with upcoming wordpress.org update to align themes with plugin directory.

= 1.1.19
- Updated: Improved checks for 'edit_theme_options' capability to ensure demo content only displays to site admins.

= 1.1.18
- Updated: Various styling fixes.

= 1.1.17
- Updated: Function to add additional image sizes hooked into after_theme_setup instead of init.

= 1.1.16
- Fixed:   style-backend.css now loads correctly in admin area.
- Fixed:   WooCommerce v3+ gallery support added, ensured image zoom function works correctly.

= 1.1.15
- Updated: Slider updated to ensure full compatibility with child themes.

= 1.1.14
- Updated: Improved escaping in template-tags.php.
- Updated: Placeholder translation texts in comments.php now escaped.
- Updated: Function thinkup_input_imagesnav() updated to improve image page pagination.

= 1.1.13
- Updated: Support added for EDD to ensure purchase buttons display correctly on downloads page.

= 1.1.12
- Fixed:   jQuery for video responsive sizes updated to prevent issues when video sliders are used.

= 1.1.11
- Updated: Escaping improved in "media" field of framework.
- Updated: Escaping improved in "slides" field of framework.
- Updated: Escaping improved in "image_select" field of framework.

= 1.1.10
- New:     Version control now updated with use of global variable $thinkup_theme_version.
- Updated: Anchor for responsive stylesheet changed from "thinkup-retina" changed to "retina".
- Removed: imagesloaded folder removed and enqueued directly from core.

= 1.1.9
- Fixed:   Documentation display fixed to ensure compatibilty with WordPress v4.8.
- Updated: Homepage (Featured) section customizer options display regardless of if switch is on or off.

= 1.1.8
- Fixed:   Improved escaping in background and gallery options fields.

= 1.1.7
- New:     Documentation link added to customizer.
- New:     Theme information page added under Appearance in admin area.
- Updated: Text domain changed from 'redux-framework' to 'melos' in options.php.

= 1.1.6
- New:     Theme information page added under Appearance in admin area.

= 1.1.5
- Updated: Custom image size names now translation ready.
- Updated: Improved escaping of outputs in thinkup_input_breadcrumb() function in 00.theme-setup.php.

= 1.1.4
- Updated: style-shortcodes.css updated.
- Removed: Unnecesary translation wrappers removed from string containins no text in function thinkup_title_select().

= 1.1.3
- Updated: Function thinkup_check_ishome() updated to improve reliability with use of use wp_unslash.
- Updated: Function thinkup_check_currentpage() updated to improve reliability with use of use wp_unslash.

= 1.1.2
- Updated: Font Awesome updated to v4.7.0.
- Removed: Outdated vesions of jQuery removed from prettyPhoto folder.

= 1.1.1
- Updated: Improved escaping in framwork.php.
- Updated: Unused code removed from extension_customizer.php.

= 1.1.0
- Updated: Fully compatible with WordPress v4.7.

= 1.0.18
- Updated: Improved escaping of outputs in 01.general-settings.php.

= 1.0.17
- New:     Function thinkup_photon_exception() added to ensure theme theme bundled transparent.png image displays correctly when Jetpack Photon is activated.

= 1.0.16
- Updated: Logo alt tag now translation ready.
- Updated: Improved escaping of outputs in 00.theme-setup.php.
- Updated: Improved escaping of outputs in 01.general-settings.php.

= 1.0.15
- Fixed:   prettyPhoto.js now fully compatible with https sites.
- Updated: Font Awesome library updated to latest version v4.6.3. Ensures all icons in FA library are available to use.

= 1.0.14
- Fixed:   Custom Redux extensions now load correctly. Issue introduced in previous version where extensions did not load is now corrected.

= 1.0.13
- Fixed:   Custom Redux extensions now moved to folder main-extensions to ensure compatibility with Redux plugin. Ensures plugin and theme can be used without conflicting.
- Updated: "ReduxFramework::$_url . 'assets/img/layout" changed to "trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout".

= 1.0.12
- Fixed:   ThinkUpSlider now checks to see if any slide is assigned, rather than just the first slide. Corrects issue where deleting slides resulted in issues.

= 1.0.11
- Fixed:   Checkbox field saves as as "off" when unticked.
- Fixed:   Switch field saves as as "off" when switched off.
- Fixed:   Full post content on blog archive pages only displayed if explicitly set by user in theme options.
- Fixed:   Custom social media icons now applied to footer social media icons as well as header social media icons.
- Fixed:   Masonry script now output on all archive pages. Fixes issue where masonry layout didn't work on category and tags pages.
- Updated: Links in breadcrumb function sanitized.
- Updated: thinkup_input_wptitle() outputs at start of wp_head().
- Updated: style-shortcodes.css updated to be consistent with all themes.
- Updated: Link to gmpg.org in header.php now compatible with https sites.
- Updated: All references to textdomain 'themecheck' changed to 'redux-framework'.
- Updated: Links to widgets page changed from /wp-admin/widgets.php to esc_url( admin_url( 'widgets.php' ) ).
- Updated: Homepage (Content) section renamed to Homepage (Featured) to make it clear that the section is intended for minimal content.
- Updated: Theme tags updated to reflect new tags. Old rags will be removed once WP v4.6 is released and users can no longer filter with old tags.
- Removed: alert( 'test000' ); removed from jquery.serializeForm.js.
- Removed: //alert( 'test11-22' ); removed from extension_customizer.min.js.
- Removed: Code for sc-progress removed from style.css as it's not being used and causes design issues.
- Removed: Deregistered redux scripts removed for compliance with .org requirements 'wpb_ace' and 'jquerySelect2'.

= 1.0.10
- Fixed:   Post content displayed on main blog page can be set by user using core WordPress <!--more--> tag.
- Updated: Logo image width set to "auto".

= 1.0.9
- Fixed:   PHP notices fixed for comments form - changes made comments.php file.
- Fixed:   Custom titles now display correctly on mobile layouts. Issue previously caused titles to be squashed on smaller screens.
- Updated: Minor css changes made in style.css to header, breadcrumbs and footer links.

= 1.0.8
- Updated: Post share icons now display correctly on single post pages.
- Removed: Old files .mo and .po removed.

= 1.0.7
- Fixed:   Function home_page_menu_args() renamed to thinkup_menu_homelink() to ensure correct prefixing and reduce change of conflict with 3rd party code.
- Updated: Various unused variables deleted from 00.variables.php.
- Updated: Portfolio masonry container checks updated in main-frontend.js.
- Updated: Variable $open_sans renamed to $font_translate in function thinkup_googlefonts_url().
- Updated: Function thinkup_input_logoretinaja() renamed to thinkup_input_logoretinaja() to be inline with proper naming convention.
- Updated: Function thinkup_get_comments_number_str() renamed to thinkup_comments_returnstring() to be inline with proper naming convention.
- Updated: Function thinkup_get_comments_popup_link() renamed to thinkup_input_commentspopuplink() to be inline with proper naming convention.

= 1.0.6
- Updated: Social media links in pre-header now open in new tab.
- Updated: Translation .pot file updated to use correct translation file for Melos.

= 1.0.5
- Fixed:   Disables sortable slides in Customizer. This prevents issues where phantom slides still appear after deleting slides.
- Updated: Various minor styling updates for theme options in customizer.

= 1.0.4
- Fixed:   "$this->_extension_url" used for redux extensions fixed to ensure custom extensions are loaded correctly on all sites.

= 1.0.3
- Updated: Masonry now enqueued directly from WordPress core.
- Updated: All references to "lan-thinkupthemes" text domain changed to "melos".
- Updated: All references to "themecheck" text domain changed to "redux-framework".
- Updated: Font awesome anchor changed to "font-awesome" to reduce risk of conflict with 3rd party plugins.
- Removed: Masonry 3rd part folder removed.
- Removed: Custom JS option removed. Causes potential issues with customizer options if user inputs code incorrectly.
 
= 1.0.2
- Fixed:   Sitemap template updated to clear all floating elements.
- Fixed:   Preview of slider images now correctly display in customizer.
- Fixed:   Pagination now displays correctly on all pages. Float cleared using "clearboth" class.
- Updated: Padding added to slider content.
- Updated: Stying added for input[type=tel].
- Updated: Custom js output sanitized using wp_kses_post().
- Updated: Screenshot now shows Melos default preview in mobile device.
- Updated: Margin removed from .alignright class when used in pre-header area.
- Updated: URL validation changed to HTML to ensure any type of link can be used.

= 1.0.1
- Fixed:   Bradcrumb switch now works correctly.
- Fixed:   Customizer settings now work correctly.
- Fixed:   Scroll to top setting now works correctly.
- Fixed:   Function thinkup_input_postauthorbio() removed from single.php to correct php error.
- Updated: Logo height maximum height reduced from 60px to 50px.
- Updated: Screenshot updated to show responsive theme screenshot.
- Updated: Css added to customizer to alow background image settings to show fully.
- Updated: Top spacing added to post title on single post pages when post has no featured image.
- Updated: Left spacing added to post title on archive post pages when post has no featured image.

= 1.0.0
- Initial release.