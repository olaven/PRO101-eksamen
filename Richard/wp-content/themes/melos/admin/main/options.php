<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "thinkup_redux_variables";

    // This line is adding in extensions.
//    Redux::setExtensions( $opt_name, dirname(__FILE__).'/../main-extensions');

    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();

    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => false,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Theme Options', 'melos' ),
        'page_title'           => __( 'Theme Options', 'melos' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => false,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer_only'      => true,
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
//    $args['admin_bar_links'][] = array(
//        'id'    => 'redux-docs',
//        'href'  => 'http://docs.reduxframework.com/',
//        'title' => __( 'Documentation', 'melos' ),
//    );

//    $args['admin_bar_links'][] = array(
//        //'id'    => 'redux-support',
//        'href'  => 'https://github.com/ReduxFramework/redux-framework/issues',
//        'title' => __( 'Support', 'melos' ),
//    );

//    $args['admin_bar_links'][] = array(
//        'id'    => 'redux-extensions',
//        'href'  => 'reduxframework.com/extensions',
//        'title' => __( 'Extensions', 'melos' ),
//    );

    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
//    $args['share_icons'][] = array(
//        'url'   => 'https://github.com/',
//        'title' => 'Visit us on GitHub',
//        'icon'  => 'el el-github'
//        //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
//    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/thinkupthemes',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://www.twitter.com/thinkupthemes',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
//    $args['share_icons'][] = array(
//        'url'   => 'http://www.linkedin.com/',
//        'title' => 'Find us on LinkedIn',
//        'icon'  => 'el el-linkedin'
//    );

    // Panel Intro text -> before the form
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
//        $args['intro_text'] = sprintf( __( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'melos' ), $v );
    } else {
//        $args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'melos' );
    }

    // Add content after the form.
//    $args['footer_text'] = __( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'melos' );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
     */

//    $tabs = array(
//        array(
//            'id'      => 'redux-help-tab-1',
//            'title'   => __( 'Theme Information 1', 'melos' ),
//            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'melos' )
//        ),
//        array(
//            'id'      => 'redux-help-tab-2',
//            'title'   => __( 'Theme Information 2', 'melos' ),
//            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'melos' )
//        )
//    );
//    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
//    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'melos' );
//    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

	// -----------------------------------------------------------------------------------
	//	0.	Customizer - Set subsections
	// -----------------------------------------------------------------------------------

	if ( is_customize_preview() ) {

		// Change subtitle text in customizer / options panel
		$thinkup_subtitle_customizer   = 'subtitle';
		$thinkup_subtitle_panel        = NULL;

		// Change section field used in customizer / options panel
		$thinkup_section_field         = 'thinkup_section';

		// Enable sub-sections in customizer
		$thinkup_customizer_subsection = true;

		// Add theme options section
		Redux::setSection( $opt_name, array(
			'title'            => __( 'Theme Options', 'melos' ),
			'id'               => 'thinkup_theme_options',
			'desc'             => __( 'Use the options below to customize your theme!', 'melos' ),
			'customizer_width' => '400px',
			'icon'             => 'el el-home',
			'customizer'       => true,
		) );

	} else {

		// Disable sub-sections in theme options panel
		$thinkup_customizer_subsection = false;

		// Change subtitle text in customizer / options panel
		$thinkup_subtitle_customizer   = NULL;
		$thinkup_subtitle_panel        = 'subtitle';

		// Change section field used in customizer / options panel
		$thinkup_section_field         = 'section';

	}
	
	 
	// -----------------------------------------------------------------------------------
	//	1.	General Settings
	// -----------------------------------------------------------------------------------

    Redux::setSection( $opt_name, array(
		'title'            => __('General Settings', 'melos'),
		'desc'             => __('<span class="redux-title">Logo & Favicon Settings</span>', 'melos'),
		'icon_class'       => '',
		'icon'             => 'el el-wrench',
        'id'               => 'thinkup_section_general',
        'subsection'       => $thinkup_customizer_subsection,
		'customizer'       => true,
		'fields'           => array(

			array(
				'title'                      => __('Logo Settings', 'melos'),
				$thinkup_subtitle_panel      => __('If you have an image logo you can upload it, otherwise you can display a text site title.', 'melos'),
				$thinkup_subtitle_customizer => __('Display image logo or site title.', 'melos'),
				'id'                         => 'thinkup_general_logoswitch',
				'type'                       => 'radio',
				'options'                    => array( 
					'option1' => 'Custom Image Logo', 
					'option2' => 'Display Site Title',
				),
			),

			array(
				'title'                      => __('Custom Image Logo', 'melos'),
				$thinkup_subtitle_panel      => __('Upload image logo or specify the image url.<br />Name the logo image logo.png.', 'melos'),
				$thinkup_subtitle_customizer => __('Upload image logo or specify the image url.<br />Name the logo image logo.png.', 'melos'),
				'id'                         => 'thinkup_general_logolink',
				'type'                       => 'media',
				'url'                        => true,
				'required'                   => array( 
					array( 'thinkup_general_logoswitch', '=', 
						array( 'option1' ),
					), 
				)
			),

			array(
				'title'                      => __('Custom Image Logo (Retina display)', 'melos'),
				$thinkup_subtitle_panel      => __('Upload a logo image twice the size of logo.png. Name the logo image logo@2x.png.', 'melos'),
				$thinkup_subtitle_customizer => __('Upload a logo image twice the size of logo.png. Name the logo image logo@2x.png.', 'melos'),
				'id'                         => 'thinkup_general_logolinkretina',
				'type'                       => 'media',
				'url'                        => true,
				'required'                   => array( 
					array( 'thinkup_general_logoswitch', '=', 
						array( 'option1' ),
					), 
				)
			),

			array(
				'title'                      => __('Site Title', 'melos'),
				$thinkup_subtitle_panel      => __('Input a message to display as your site title. Leave blank to display your default site title.', 'melos'),
				$thinkup_subtitle_customizer => __('Input a message to display as your site title. Leave blank to display your default site title.', 'melos'),
				'id'                         => 'thinkup_general_sitetitle',
				'type'                       => 'text',
				'validate'                   => 'html',
				'required'                   => array( 
					array( 'thinkup_general_logoswitch', '=', 
						array( 'option2' ),
					), 
				)
			),

			array(
				'title'                      => __('Site Description', 'melos'),
				$thinkup_subtitle_panel      => __('Input a message to display as site description. Leave blank to display default site description.', 'melos'),
				$thinkup_subtitle_customizer => __('Input a message to display as site description. Leave blank to display default site description.', 'melos'),
				'id'                         => 'thinkup_general_sitedescription',
				'type'                       => 'text',
				'validate'                   => 'html',
				'required'                   => array( 
					array( 'thinkup_general_logoswitch', '=', 
						array( 'option2' ),
					), 
				)
			),

			array(
				'title'                      => __('Custom Favicon', 'melos'),
				$thinkup_subtitle_panel      => __('Uploads favicon or specify the favicon url.', 'melos'),
				$thinkup_subtitle_customizer => __('Uploads favicon or specify the favicon url.', 'melos'),
				'id'                         => 'thinkup_general_faviconlink',
				'type'                       => 'media',
				'url'                        => true,
			),

            array(
				'id'       => 'thinkup_section_general_page',
				'type'     => $thinkup_section_field,
				'title'    => __( ' ', 'melos' ),
				'subtitle' => __( '', 'melos' ),
				'indent'   => false,
            ),

			array(
				'title'                      => __('Page Layout', 'melos'), 
				$thinkup_subtitle_panel      => __('Select page layout. This will only be applied to published Pages (I.e. Not posts, blog or home).', 'melos'),
				$thinkup_subtitle_customizer => __('Select page layout. This will only be applied to published Pages (I.e. Not posts, blog or home).', 'melos'),
				'id'                         => 'thinkup_general_layout',
				'type'                       => 'image_select',
				'compiler'                   => true,
				'default'                    => '0',
				'options'                    => array(
					'option1' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/blog/option01.png',
					'option2' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/blog/option02.png',
					'option3' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/blog/option03.png',
				),
			),

			array(
				'title'                      => __('Select a Sidebar', 'melos'), 
				$thinkup_subtitle_panel      => __('Choose a sidebar to use with the page layout.', 'melos'),
				$thinkup_subtitle_customizer => __('Choose a sidebar to use with the page layout.', 'melos'),
				'id'                         => 'thinkup_general_sidebars',
				'type'                       => 'select',
				'data'                       => 'sidebars',
				'required'                   => array( 
					array( 'thinkup_general_layout', '=', 
						array( 'option2', 'option3' ),
					), 
				)
			),

			array(
				'title'                      => __('Enable Fixed Layout', 'melos'), 
				$thinkup_subtitle_panel      => __('Check to enable fixed layout.<br />(i.e. Disable responsive layout)', 'melos'),
				$thinkup_subtitle_customizer => __('Check to enable fixed layout.<br />(i.e. Disable responsive layout)', 'melos'),
				'id'                         => 'thinkup_general_fixedlayoutswitch',
				'type'                       => 'switch',
			),

			array(
				'title'                      => __('Enable Breadcrumbs', 'melos'), 
				$thinkup_subtitle_panel      => __('Switch on to enable breadcrumbs.', 'melos'),
				$thinkup_subtitle_customizer => __('Switch on to enable breadcrumbs.', 'melos'),
				'id'                         => 'thinkup_general_breadcrumbswitch',
				'type'                       => 'switch',
				'default'                    => '1',
			),

			array(
				'title'                      => __('Breadcrumb Delimiter', 'melos'),
				$thinkup_subtitle_panel      => __('Specify a custom delimiter to use instead of the default &#40; / &#41; when displaying breadcrumbs.', 'melos'),
				$thinkup_subtitle_customizer => __('Specify a custom delimiter to use instead of the default &#40; / &#41; when displaying breadcrumbs.', 'melos'),
				'default'                    => '/',
				'id'                         => 'thinkup_general_breadcrumbdelimeter',
				'type'                       => 'text',
				'validate'                   => 'html',
				'required'                   => array( 
					array( 'thinkup_general_breadcrumbswitch', '=', 
						array( '1' ),
					), 
				)
			),

            array(
				'id'       => 'thinkup_section_general_code',
				'type'     => $thinkup_section_field,
				'title'    => __( ' ', 'melos' ),
				'subtitle' => __('<span class="redux-title">Custom Code</span>', 'melos'),
				'indent'   => false,
            ),

			array(
                'id'                         => 'thinkup_general_customcss',
                'title'                      => __( 'Custom CSS', 'melos' ),
				$thinkup_subtitle_panel      => __('Developers can use this to apply custom css. Use this to control, by styling of any element on the webpage by targeting id&#39;s and classes.', 'melos'),
				$thinkup_subtitle_customizer => __('Developers can use this to apply custom css. Use this to control, by styling of any element on the webpage by targeting id&#39;s and classes.', 'melos'),
				'type'                       => 'textarea',
				'validate'                   => 'html',
			),

//            array(
//               'id'                         => 'thinkup_general_customjavafront',
//                'title'                      => __( 'Custom jQuery - Front End', 'melos' ),
//				$thinkup_subtitle_panel      => __('Developers can use this to apply custom jQuery which will only affect the front end of the website.<br /><br />Use this to control your site by adding great jQuery features.', 'melos'),
//				$thinkup_subtitle_customizer => __('Developers can use this to apply custom jQuery which will only affect the front end of the website.<br /><br />Use this to control your site by adding great jQuery features.', 'melos'),
//				'type'                       => 'textarea',
//				'validate'                   => 'html',
//           ),

			// Ensures ThinkUpThemes custom code is output
			array(
				'title'    => __('Custom Code', 'melos'), 
				'subtitle' => __('Custom Code', 'melos'),
				'id'       => 'thinkup_customization',
				'type'     => 'thinkup_custom_code',
			),
		)
	) );

    Redux::setSection( $opt_name, array(
		'type'       => 'divide',
        'subsection' => $thinkup_customizer_subsection,
	) );

	// -----------------------------------------------------------------------------------
	//	2.1.	Home Settings
	// -----------------------------------------------------------------------------------

    Redux::setSection( $opt_name, array(
		'title'      => __('Homepage', 'melos'),
		'desc'       => __('<span class="redux-title">Control Homepage Layout</span>', 'melos'),
		'icon_class' => '',
		'icon'       => 'el el-home',
        'id'         => 'thinkup_section_homepage',
        'subsection' => $thinkup_customizer_subsection,
		'customizer' => true,
		'fields'     => array(

			array(
				'title'                      => __('Homepage Layout', 'melos'), 
				$thinkup_subtitle_panel      => __('Select page layout. This will only be applied to static homepages (front page) and not to homepage blogs.', 'melos'),
				$thinkup_subtitle_customizer => __('Select page layout. This will only be applied to static homepages (front page) and not to homepage blogs.', 'melos'),
				'id'                         => 'thinkup_homepage_layout',
				'type'                       => 'image_select',
				'compiler'                   => true,
				'default'                    => '0',
				'options'                    => array(
						'option1' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/blog/option01.png',
						'option2' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/blog/option02.png',
						'option3' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/blog/option03.png',
				),
			),

			array(
				'title'                      => __('Select a Sidebar', 'melos'), 
				$thinkup_subtitle_panel      => __('Choose a sidebar to use with the layout.', 'melos'),
				$thinkup_subtitle_customizer => __('Choose a sidebar to use with the layout.', 'melos'),
				'id'                         => 'thinkup_homepage_sidebars',
				'type'                       => 'select',
				'data'                       => 'sidebars',
				'required'                   => array( 
					array( 'thinkup_homepage_layout', '=', 
						array( 'option2', 'option3' ),
					), 
				)
			),

            array(
				'id'       => 'thinkup_section_homepage_slider',
				'type'     => $thinkup_section_field,
				'title'    => __( ' ', 'melos' ),
				'subtitle' => __('<span class="redux-title">Homepage Slider</span>', 'melos'),
				'indent'   => false,
            ),

			array(
				'title'                      => __('Choose Homepage Slider', 'melos'), 
				$thinkup_subtitle_panel      => __('Switch on to enable home page slider.', 'melos'),
				$thinkup_subtitle_customizer => __('Switch on to enable home page slider.', 'melos'),
				'id'                         => 'thinkup_homepage_sliderswitch',
				'type'                       => 'button_set',
				'options'                    => array(
					'option1' => 'ThinkUpSlider',
					'option2' => 'Custom Slider',
					'option3' => 'Disable'
				),
				'default'                    => 'option1'
			),

			array(
				'title'                      => __('Homepage Slider Shortcode', 'melos'), 
				$thinkup_subtitle_panel      => __('Input the shortcode of the slider you want to display. I.e. [shortcode_name].', 'melos'),
				$thinkup_subtitle_customizer => __('Input the shortcode of the slider you want to display. I.e. [shortcode_name].', 'melos'),
				'id'                         => 'thinkup_homepage_slidername',
				'type'                       => 'text',
				'validate'                   => 'html',
				'required'                   => array( 
					array( 'thinkup_homepage_sliderswitch', '=', 
						array( 'option2' ),
					), 
				)
			),

			array(
				'title'                      => __('Built-In Slider', 'melos'),
				$thinkup_subtitle_panel      => __('Unlimited slides with drag and drop sortings.', 'melos'),
				$thinkup_subtitle_customizer => __('Unlimited slides with drag and drop sortings.', 'melos'),
				'id'                         => 'thinkup_homepage_sliderpreset',
				'type'                       => 'thinkup_slider_free',
				'required'                   => array( 
					array( 'thinkup_homepage_sliderswitch', '=', 
						array( 'option1' ),
					), 
				)
			),

			array(
				'id'                         => 'thinkup_homepage_sliderpresetheight',
				'type'                       => 'slider', 
				'title'                      => __('Slider Height (Max)', 'melos'),
				$thinkup_subtitle_panel      => __('Specify the maximum slider height (px).', 'melos'),
				$thinkup_subtitle_customizer => __('Specify the maximum slider height (px).', 'melos'),
				"default"                    => "350",
				"min"                        => "200",
				"step"                       => "5",
				"max"                        => "1000",
				'required'                   => array( 
					array( 'thinkup_homepage_sliderswitch', '=', 
						array( 'option1' ),
					), 
				)
			),

			array(
				'title'                      => __('Enable Full-Width Slider', 'melos'),
				$thinkup_subtitle_panel      => __('Switch on to enable full-width slider.', 'melos'),
				$thinkup_subtitle_customizer => __('Switch on to enable full-width slider.', 'melos'),
				'id'                         => 'thinkup_homepage_sliderpresetwidth',
				'type'                       => 'switch',
				'default'                    => '1',
				'required'                   => array( 
					array( 'thinkup_homepage_sliderswitch', '=', 
						array( 'option1' ),
					), 
				)
			),

            array(
				'id'       => 'thinkup_section_homepage_ctaintro',
				'type'     => $thinkup_section_field,
				'title'    => __( ' ', 'melos' ),
				'subtitle' => __('<span class="redux-title">Call To Action - Intro</span>', 'melos'),
				'indent'   => false,
            ),	

			array(
				'title'   => __('Message', 'melos'), 
				'desc'    => __('Check to enable intro on home page.', 'melos'),
				'id'      => 'thinkup_homepage_introswitch',
				'type'    => 'checkbox',
				'default' => '1',
			),

			array(
				$thinkup_subtitle_panel      => __('Enter a <strong>title</strong> message.<br /><br />This will be one of the first messages your visitors see. Use this to get their attention.', 'melos'),
				$thinkup_subtitle_customizer => __('Enter a <strong>title</strong> message.<br /><br />This will be one of the first messages your visitors see. Use this to get their attention.', 'melos'),
				'id'                         => 'thinkup_homepage_introaction',
				'type'                       => 'textarea',
				'validate'                   => 'html',
			),

			array(
				$thinkup_subtitle_panel      => __('Enter a <strong>teaser</strong> message.<br /><br />Use this to provide more details about what you offer.', 'melos'),
				$thinkup_subtitle_customizer => __('Enter a <strong>teaser</strong> message.<br /><br />Use this to provide more details about what you offer.', 'melos'),
				'id'                         => 'thinkup_homepage_introactionteaser',
				'type'                       => 'textarea',
				'validate'                   => 'html',
			),		

			array(
				'title'                      => __('Button - Text', 'melos'), 
				$thinkup_subtitle_panel      => __('Specify a text for button 1.', 'melos'),
				$thinkup_subtitle_customizer => __('Specify a text for button 1.', 'melos'),
				'id'                         => 'thinkup_homepage_introactiontext1',
				'type'                       => 'text',
				'validate'                   => 'html',
			),

			array(
				'title'                      => __('Button - Link', 'melos'), 
				$thinkup_subtitle_panel      => __('Specify whether the action button should link to a page on your site, out to external webpage or disable the link altogether.', 'melos'),
				$thinkup_subtitle_customizer => __('Specify whether the action button should link to a page on your site, out to external webpage or disable the link altogether.', 'melos'),
				'id'                         => 'thinkup_homepage_introactionlink1',
				'type'                       => 'radio',
				'options'                    => array( 
					'option1' => 'Link to a Page',
					'option2' => 'Specify Custom link',
					'option3' => 'Disable Link'
				),
			),

			array(
				'title'                      => __('Button - Link to a page', 'melos'), 
				$thinkup_subtitle_panel      => __('Select a target page for action button link.', 'melos'),
				$thinkup_subtitle_customizer => __('Select a target page for action button link.', 'melos'),
				'id'                         => 'thinkup_homepage_introactionpage1',
				'type'                       => 'select',
				'data'                       => 'pages',
				'required'                   => array( 
					array( 'thinkup_homepage_introactionlink1', '=', 
						array( 'option1' ),
					), 
				)
			),

			array(
				'title'                      => __('Button - Custom link', 'melos'),
				$thinkup_subtitle_panel      => __('Input a custom url for the action button link.<br>Add http:// if linking to an external webpage.', 'melos'),
				$thinkup_subtitle_customizer => __('Input a custom url for the action button link.<br>Add http:// if linking to an external webpage.', 'melos'),
				'id'                         => 'thinkup_homepage_introactioncustom1',
				'type'                       => 'text',
				'validate'                   => 'html',
				'required'                   => array( 
					array( 'thinkup_homepage_introactionlink1', '=', 
						array( 'option2' ),
					), 
				)
			),
		)
	) );


	// -----------------------------------------------------------------------------------
	//	2.2.	Homepage (Featured)
	// -----------------------------------------------------------------------------------

    Redux::setSection( $opt_name, array(
		'title'      => __('Homepage (Featured)', 'melos'),
		'desc'       => __('<span class="redux-title">Display Pre-Designed Homepage Layout</span>', 'melos'),
		'icon_class' => '',
		'icon'       => 'el el-pencil',
        'id'         => 'thinkup_section_homepage_content',
        'subsection' => $thinkup_customizer_subsection,
        'customizer' => true,
        'fields'     => array(

			array(
				'title'                      => __('Enable Pre-Made Homepage ', 'melos'), 
				$thinkup_subtitle_panel      => __('switch on to enable pre-designed homepage layout.', 'melos'),
				$thinkup_subtitle_customizer => __('switch on to enable pre-designed homepage layout.', 'melos'),
				'id'                         => 'thinkup_homepage_sectionswitch',
				'type'                       => 'switch',
			),

			array(
				'title'    => __('Content Area 1', 'melos'),
				'desc'     => __('Add an image for the section background.', 'melos'),
				'id'       => 'thinkup_homepage_section1_image',
				'type'     => 'media',
				'url'      => true,
			),

			array(
				'id'       => 'thinkup_homepage_section1_title',
				'desc'     => __('Add a title to the section.', 'melos'),
				'type'     => 'text',
				'validate' => 'html',
			),

			array(
				'id'       => 'thinkup_homepage_section1_desc',
				'desc'     => __('Add some text to featured section 1.', 'melos'),
				'type'     => 'textarea',
				'validate' => 'html',
			),

			array(
				'id'       => 'thinkup_homepage_section1_link',
				'desc'     => __('Link to a page', 'melos'), 
				'type'     => 'select',
				'data'     => 'pages',
			),

			array(
				'title'    => __('Content Area 2', 'melos'),
				'desc'     => __('Add an image for the section background.', 'melos'),
				'id'       => 'thinkup_homepage_section2_image',
				'type'     => 'media',
				'url'      => true,
			),

			array(
				'id'       => 'thinkup_homepage_section2_title',
				'desc'     => __('Add a title to the section.', 'melos'),
				'type'     => 'text',
				'validate' => 'html',
			),

			array(
				'id'       => 'thinkup_homepage_section2_desc',
				'desc'     => __('Add some text to featured section 2.', 'melos'),
				'type'     => 'textarea',
				'validate' => 'html',
			),

			array(
				'id'       => 'thinkup_homepage_section2_link',
				'desc'     => __('Link to a page', 'melos'), 
				'type'     => 'select',
				'data'     => 'pages',
			),

			array(
				'title'    => __('Content Area 3', 'melos'),
				'desc'     => __('Add an image for the section background.', 'melos'),
				'id'       => 'thinkup_homepage_section3_image',
				'type'     => 'media',
				'url'      => true,
			),

			array(
				'id'       => 'thinkup_homepage_section3_title',
				'desc'     => __('Add a title to the section.', 'melos'),
				'type'     => 'text',
				'validate' => 'html',
			),

			array(
				'id'       => 'thinkup_homepage_section3_desc',
				'desc'     => __('Add some text to featured section 3.', 'melos'),
				'type'     => 'textarea',
				'validate' => 'html',
			),

			array(
				'id'       => 'thinkup_homepage_section3_link',
				'desc'     => __('Link to a page', 'melos'), 
				'type'     => 'select',
				'data'     => 'pages',
			),
		)
	) );


	// -----------------------------------------------------------------------------------
	//	3.	Header
	// -----------------------------------------------------------------------------------

    Redux::setSection( $opt_name, array(
		'title'      => __('Header', 'melos'),
		'desc'       => __('<span class="redux-title">Pre Header Style</span>', 'melos'),
		'icon'       => 'el el-chevron-up',
		'icon_class' => '',
        'id'         => 'thinkup_section_header',
        'subsection' => $thinkup_customizer_subsection,
		'customizer' => true,
		'fields'     => array(

			array(
				'title'                      => __('Choose Pre Header Style', 'melos'), 
				$thinkup_subtitle_panel      => __('Specify the pre header style.', 'melos'),
				$thinkup_subtitle_customizer => __('Specify the pre header style.', 'melos'),
				'id'                         => 'thinkup_header_styleswitchpre',
				'type'                       => 'radio',
				'options'                    => array(
					'option1' => 'Style 1 (Dark)',
					'option2' => 'Style 2 (Light)',
				),
			),

            array(
				'id'       => 'thinkup_section_header_content',
				'type'     => $thinkup_section_field,
				'title'    => __( ' ', 'melos' ),
				'subtitle' => __('<span class="redux-title">Control Header Content</span>', 'melos'),
				'indent'   => false,
            ),

			array(
				'title'                      => __('Enable Search (Pre Header)', 'melos'), 
				$thinkup_subtitle_panel      => __('Switch on to enable pre header search.', 'melos'),
				$thinkup_subtitle_customizer => __('Switch on to enable pre header search.', 'melos'),
				'id'                         => 'thinkup_header_searchswitchpre',
				'type'                       => 'switch',
				'default'                    => '0',
			),			

			array(
				'title'                      => __('Enable Search (Main Header)', 'melos'), 
				$thinkup_subtitle_panel      => __('Switch on to enable header search.', 'melos'),
				$thinkup_subtitle_customizer => __('Switch on to enable header search.', 'melos'),
				'id'                         => 'thinkup_header_searchswitch',
				'type'                       => 'switch',
				'default'                    => '0',
			),			
		)
	) );
	

	// -----------------------------------------------------------------------------------
	//	4.	Footer
	// -----------------------------------------------------------------------------------

    Redux::setSection( $opt_name, array(
		'title'      => __('Footer', 'melos'),
		'desc'       => __('<span class="redux-title">Control Footer Content</span>', 'melos'),
		'icon'       => 'el el-chevron-down',
		'icon_class' => '',
        'id'         => 'thinkup_section_footer',
        'subsection' => $thinkup_customizer_subsection,
		'customizer' => true,
		'fields'     => array(

			array(
				'title'                      => __('Footer Widgets Layout', 'melos'), 
				$thinkup_subtitle_panel      => __('Select footer layout. Take complete control of the footer content by adding widgets.', 'melos'),
				$thinkup_subtitle_customizer => __('Select footer layout. Take complete control of the footer content by adding widgets.', 'melos'),
				'id'                         => 'thinkup_footer_layout',
				'type'                       => 'image_select',
				'compiler'                   => true,
				'default'                    => '0',
				'options'                    => array(
					'option1' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option01.png',
					'option2' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option02.png',
					'option3' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option03.png',
					'option4' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option04.png',
					'option5' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option05.png',
					'option6' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option06.png',
					'option7' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option07.png',
					'option8' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option08.png',
					'option9' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option09.png',
					'option10' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option10.png',
					'option11' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option11.png',
					'option12' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option12.png',
					'option13' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option13.png',
					'option14' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option14.png',
					'option15' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option15.png',
					'option16' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option16.png',
					'option17' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option17.png',
					'option18' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/footer/option18.png',
				),
			),

			array(
				'title'   => __('Disable Footer Widgets', 'melos'), 
				'desc'    => __('Check to disable footer widgets.', 'melos'),
				'id'      => 'thinkup_footer_widgetswitch',
				'type'    => 'checkbox',
				'default' => '0',
			),

			array(
				'title'                      => __('Enable Scroll To Top', 'melos'), 
				$thinkup_subtitle_panel      => __('Check to enable scroll to top.', 'melos'),
				$thinkup_subtitle_customizer => __('Check to enable scroll to top.', 'melos'),
				'id'                         => 'thinkup_footer_scroll',
				'type'                       => 'switch',
				'default'                    => '0',
			),
		)
	) );


	// -----------------------------------------------------------------------------------
	//	3 & 4.	Social Media
	// -----------------------------------------------------------------------------------

    Redux::setSection( $opt_name, array(
		'title'      => __('Social Media', 'melos'),
		'desc'       => __('<span class="redux-title">Social Media Control</span>', 'melos'),
		'icon'       => 'el el-facebook',
		'icon_class' => '',
        'id'         => 'thinkup_header_social',
        'subsection' => $thinkup_customizer_subsection,
		'customizer' => true,
		'fields'     => array(

			array(
				'title'                      => __('Enable Social Media Links (Pre Header)', 'melos'), 
				$thinkup_subtitle_panel      => __('Switch on to enable links to social media pages.', 'melos'),
				$thinkup_subtitle_customizer => __('Switch on to enable links to social media pages.', 'melos'),
				'id'                         => 'thinkup_header_socialswitchpre',
				'type'                       => 'switch',
				'default'                    => '0',
			),

//			array(
//				'title'    => __('Enable Social Media Links (Main Header)', 'melos'), 
//				$thinkup_subtitle_panel      => __('Switch on to enable links to social media pages.', 'melos'),
//				$thinkup_subtitle_customizer => __('Switch on to enable links to social media pages.', 'melos'),
//				'id'       => 'thinkup_header_socialswitchmain',
//				'type'     => 'switch',
//				'default'  => '0',
//			),

			array(
				'title'                      => __('Enable Social Media Links (footer)', 'melos'), 
				$thinkup_subtitle_panel      => __('Switch on to enable links to social media pages.', 'melos'),
				$thinkup_subtitle_customizer => __('Switch on to enable links to social media pages.', 'melos'),
				'id'                         => 'thinkup_header_socialswitchfooter',
				'type'                       => 'switch',
				'default'                    => '0',
			),

            array(
				'id'       => 'thinkup_section_header_social',
				'type'     => $thinkup_section_field,
				'title'    => __( '', 'melos' ),
				'subtitle' => __('<span class="redux-title">Social Media Content</span>', 'melos'),
				'indent'   => false,
            ),	
				
			array(
				'title'                      => __('Display Message', 'melos'), 
				$thinkup_subtitle_panel      => __('Add a message here. E.g. &#34;Follow Us&#34;.<br />(Only shown in header)', 'melos'),
				$thinkup_subtitle_customizer => __('Add a message here. E.g. &#34;Follow Us&#34;.<br />(Only shown in header)', 'melos'),
				'id'                         => 'thinkup_header_socialmessage',
				'type'                       => 'text',
				'validate'                   => 'html',
			),					

			// Facebook social settings
			array(
				'title'                      => __('Facebook', 'melos'), 
				$thinkup_subtitle_panel      => __('Enable link to Facebook profile.', 'melos'),
				$thinkup_subtitle_customizer => __('Enable link to Facebook profile.', 'melos'),
				'id'                         => 'thinkup_header_facebookswitch',
				'type'                       => 'switch',
				'default'                    => '0',
			),
				
			array(
				'desc'     => __('Input the url to your Facebook page. <strong>Note:</strong> Add http:// as the url is an external link.', 'melos'),
				'id'       => 'thinkup_header_facebooklink',
				'type'     => 'text',
				'validate' => 'html',
				'required' => array( 
					array( 'thinkup_header_facebookswitch', '=', 
						array( '1' ),
					), 
				)
			),				

			array(
				'desc'     => __('Use Custom Facebook Icon', 'melos'),
				'id'       => 'thinkup_header_facebookiconswitch',
				'type'     => 'checkbox',
				'default'  => '0',
				'required' => array( 
					array( 'thinkup_header_facebookswitch', '=', 
						array( '1' ),
					), 
				)
			),

			array(
				'desc'     => __('Add a link to the image or upload one from your desktop. The image will be resized.', 'melos'),
				'id'       => 'thinkup_header_facebookcustomicon',
				'type'     => 'media',
				'url'      => true,
				'required' => array( 
					array( 'thinkup_header_facebookswitch', '=', 
						array( '1' ),
					), 
				)
			),

			// Twitter social settings
			array(
				'title'                      => __('Twitter', 'melos'), 
				$thinkup_subtitle_panel      => __('Enable link to Twitter profile.', 'melos'),
				$thinkup_subtitle_customizer => __('Enable link to Twitter profile.', 'melos'),
				'id'                         => 'thinkup_header_twitterswitch',
				'type'                       => 'switch',
				'default'                    => '0',
			),
				
			array(
				'desc'     => __('Input the url to your Twitter page. <strong>Note:</strong> Add http:// as the url is an external link.', 'melos'),
				'id'       => 'thinkup_header_twitterlink',
				'type'     => 'text',
				'validate' => 'html',
				'required' => array( 
					array( 'thinkup_header_twitterswitch', '=', 
						array( '1' ),
					), 
				)
			),				

			array(
				'desc'     => __('Use Custom Twitter Icon', 'melos'),
				'id'       => 'thinkup_header_twittericonswitch',
				'type'     => 'checkbox',
				'default'  => '0',
				'required' => array( 
					array( 'thinkup_header_twitterswitch', '=', 
						array( '1' ),
					), 
				)
			),

			array(
				'desc'     => __('Add a link to the image or upload one from your desktop. The image will be resized.', 'melos'),
				'id'       => 'thinkup_header_twittercustomicon',
				'type'     => 'media',
				'url'      => true,
				'required' => array( 
					array( 'thinkup_header_twitterswitch', '=', 
						array( '1' ),
					), 
				)
			),

			// Google+ social settings
			array(
				'title'                      => __('Google+', 'melos'), 
				$thinkup_subtitle_panel      => __('Enable link to Google+ profile.', 'melos'),
				$thinkup_subtitle_customizer => __('Enable link to Google+ profile.', 'melos'),
				'id'                         => 'thinkup_header_googleswitch',
				'type'                       => 'switch',
				'default'                    => '0',
			),
				
			array(
				'desc'     => __('Input the url to your Google+ page. <strong>Note:</strong> Add http:// as the url is an external link.', 'melos'),
				'id'       => 'thinkup_header_googlelink',
				'type'     => 'text',
				'validate' => 'html',
				'required' => array( 
					array( 'thinkup_header_googleswitch', '=', 
						array( '1' ),
					), 
				)
			),				

			array(
				'desc'     => __('Use Custom Google+ Icon', 'melos'),
				'id'       => 'thinkup_header_googleiconswitch',
				'type'     => 'checkbox',
				'default'  => '0',
				'required' => array( 
					array( 'thinkup_header_googleswitch', '=', 
						array( '1' ),
					), 
				)
			),

			array(
				'desc'     => __('Add a link to the image or upload one from your desktop. The image will be resized.', 'melos'),
				'id'       => 'thinkup_header_googlecustomicon',
				'type'     => 'media',
				'url'      => true,
				'required' => array( 
					array( 'thinkup_header_googleswitch', '=', 
						array( '1' ),
					), 
				)
			),

			// LinkedIn social settings
			array(
				'title'                      => __('LinkedIn', 'melos'), 
				$thinkup_subtitle_panel      => __('Enable link to LinkedIn profile.', 'melos'),
				$thinkup_subtitle_customizer => __('Enable link to LinkedIn profile.', 'melos'),
				'id'                         => 'thinkup_header_linkedinswitch',
				'type'                       => 'switch',
				'default'                    => '0',
			),
				
			array(
				'desc'     => __('Input the url to your LinkedIn page. <strong>Note:</strong> Add http:// as the url is an external link.', 'melos'),
				'id'       => 'thinkup_header_linkedinlink',
				'type'     => 'text',
				'validate' => 'html',
				'required' => array( 
					array( 'thinkup_header_linkedinswitch', '=', 
						array( '1' ),
					), 
				)
			),				

			array(
				'desc'     => __('Use Custom LinkedIn Icon', 'melos'),
				'id'       => 'thinkup_header_linkediniconswitch',
				'type'     => 'checkbox',
				'default'  => '0',
				'required' => array( 
					array( 'thinkup_header_linkedinswitch', '=', 
						array( '1' ),
					), 
				)
			),

			array(
				'desc'     => __('Add a link to the image or upload one from your desktop. The image will be resized.', 'melos'),
				'id'       => 'thinkup_header_linkedincustomicon',
				'type'     => 'media',
				'url'      => true,
				'required' => array( 
					array( 'thinkup_header_linkedinswitch', '=', 
						array( '1' ),
					), 
				)
			),				

			// Flickr social settings
			array(
				'title'                      => __('Flickr', 'melos'), 
				$thinkup_subtitle_panel      => __('Enable link to Flickr profile.', 'melos'),
				$thinkup_subtitle_customizer => __('Enable link to Flickr profile.', 'melos'),
				'id'                         => 'thinkup_header_flickrswitch',
				'type'                       => 'switch',
				'default'                    => '0',
			),
				
			array(
				'desc'     => __('Input the url to your Flickr page. <strong>Note:</strong> Add http:// as the url is an external link.', 'melos'),
				'id'       => 'thinkup_header_flickrlink',
				'type'     => 'text',
				'validate' => 'html',
				'required' => array( 
					array( 'thinkup_header_flickrswitch', '=', 
						array( '1' ),
					), 
				)
			),				

			array(
				'desc'     => __('Use Custom Flickr Icon', 'melos'),
				'id'       => 'thinkup_header_flickriconswitch',
				'type'     => 'checkbox',
				'default'  => '0',
				'required' => array( 
					array( 'thinkup_header_flickrswitch', '=', 
						array( '1' ),
					), 
				)
			),

			array(
				'desc'     => __('Add a link to the image or upload one from your desktop. The image will be resized.', 'melos'),
				'id'       => 'thinkup_header_flickrcustomicon',
				'type'     => 'media',
				'url'      => true,
				'required' => array( 
					array( 'thinkup_header_flickrswitch', '=', 
						array( '1' ),
					), 
				)
			),

			// YouTube social settings
			array(
				'title'                      => __('YouTube', 'melos'), 
				$thinkup_subtitle_panel      => __('Enable link to YouTube profile.', 'melos'),
				$thinkup_subtitle_customizer => __('Enable link to YouTube profile.', 'melos'),
				'id'                         => 'thinkup_header_youtubeswitch',
				'type'                       => 'switch',
				'default'                    => '0',
			),
				
			array(
				'desc'     => __('Input the url to your YouTube page. <strong>Note:</strong> Add http:// as the url is an external link.', 'melos'),
				'id'       => 'thinkup_header_youtubelink',
				'type'     => 'text',
				'validate' => 'html',
				'required' => array( 
					array( 'thinkup_header_youtubeswitch', '=', 
						array( '1' ),
					), 
				)
			),				

			array(
				'desc'     => __('Use Custom YouTube Icon', 'melos'),
				'id'       => 'thinkup_header_youtubeiconswitch',
				'type'     => 'checkbox',
				'default'  => '0',
				'required' => array( 
					array( 'thinkup_header_youtubeswitch', '=', 
						array( '1' ),
					), 
				)
			),

			array(
				'desc'     => __('Add a link to the image or upload one from your desktop. The image will be resized.', 'melos'),
				'id'       => 'thinkup_header_youtubecustomicon',
				'type'     => 'media',
				'url'      => true,
				'required' => array( 
					array( 'thinkup_header_youtubeswitch', '=', 
						array( '1' ),
					), 
				)
			),

			// RSS social settings
			array(
				'title'                      => __('RSS', 'melos'), 
				$thinkup_subtitle_panel      => __('Enable link to RSS profile.', 'melos'),
				$thinkup_subtitle_customizer => __('Enable link to RSS profile.', 'melos'),
				'id'                         => 'thinkup_header_rssswitch',
				'type'                       => 'switch',
				'default'                    => '0',
			),
				
			array(
				'desc'     => __('Input the url to your RSS page. <strong>Note:</strong> Add http:// as the url is an external link.', 'melos'),
				'id'       => 'thinkup_header_rsslink',
				'type'     => 'text',
				'validate' => 'html',
				'required' => array( 
					array( 'thinkup_header_rssswitch', '=', 
						array( '1' ),
					), 
				)
			),				

			array(
				'desc'     => __('Use Custom RSS Icon', 'melos'),
				'id'       => 'thinkup_header_rssiconswitch',
				'type'     => 'checkbox',
				'default'  => '0',
				'required' => array( 
					array( 'thinkup_header_rssswitch', '=', 
						array( '1' ),
					), 
				)
			),

			array(
				'desc'     => __('Add a link to the image or upload one from your desktop. The image will be resized.', 'melos'),
				'id'       => 'thinkup_header_rsscustomicon',
				'type'     => 'media',
				'url'      => true,
				'required' => array( 
					array( 'thinkup_header_rssswitch', '=', 
						array( '1' ),
					), 
				)
			),
		)
	) );


	// -----------------------------------------------------------------------------------
	//	5.	Blog
	// -----------------------------------------------------------------------------------

    Redux::setSection( $opt_name, array(
		'title'      => __('Blog', 'melos'),
		'desc'       => __('<span class="redux-title">Control Blog (Archive) Pages</span>', 'melos'),
		'icon'       => 'el el-comment',
		'icon_class' => '',
        'id'         => 'thinkup_section_blog',
        'subsection' => $thinkup_customizer_subsection,
		'customizer' => true,
		'fields'     => array(

			array(
				'title'                      => __('Blog Layout', 'melos'), 
				$thinkup_subtitle_panel      => __('Select blog page layout. Only applied to the main blog page and not individual posts.', 'melos'),
				$thinkup_subtitle_customizer => __('Select blog page layout. Only applied to the main blog page and not individual posts.', 'melos'),
				'id'                         => 'thinkup_blog_layout',
				'type'                       => 'image_select',
				'compiler'                   => true,
				'options'                    => array(
					'option1' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/blog/option01.png',
					'option2' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/blog/option02.png',
					'option3' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/blog/option03.png',
				),
			),

			array(
				'title'                      => __('Select a Sidebar', 'melos'), 
				$thinkup_subtitle_panel      => __('<strong>Note:</strong> Sidebars will not be applied to homepage Blog. Control sidebars on the homepage from the &#39;Home Settings&#39; option.', 'melos'),
				$thinkup_subtitle_customizer => __('<strong>Note:</strong> Sidebars will not be applied to homepage Blog. Control sidebars on the homepage from the &#39;Home Settings&#39; option.', 'melos'),
				'id'                         => 'thinkup_blog_sidebars',
				'type'                       => 'select',
				'data'                       => 'sidebars',
				'required'                   => array( 
					array( 'thinkup_blog_layout', '=', 
						array( 'option2', 'option3' ),
					), 
				)
			),

			array(
				'title'                      => __('Blog Traditional Layout', 'melos'), 
				$thinkup_subtitle_panel      => __('Select a layout for your blog page. This will also be applied to all pages set using the blog template.', 'melos'),
				$thinkup_subtitle_customizer => __('Select a layout for your blog page. This will also be applied to all pages set using the blog template.', 'melos'),
				'id'                         => 'thinkup_blog_style1layout',
				'type'                       => 'radio',
				'options'                    => array( 
					'option1' => 'Style 1 (Quarter Width)',
					'option2' => 'Style 2 (Full Width)',
				),
			),

			array(
				'title'                      => __('Post Content', 'melos'), 
				$thinkup_subtitle_panel      => __('Control how much content you want to show from each post on the main blog page. Remember to control the full article content by using the Wordpress <a href="http://en.support.wordpress.com/splitting-content/more-tag/">more</a> tag in your post.', 'melos'),
				$thinkup_subtitle_customizer => __('Control how much content you want to show from each post on the main blog page. Remember to control the full article content by using the Wordpress <a href="http://en.support.wordpress.com/splitting-content/more-tag/">more</a> tag in your post.', 'melos'),
				'id'                         => 'thinkup_blog_postswitch',
				'type'                       => 'radio',
				'options'                    => array( 
					'option1' => 'Show excerpt',
					'option2' => 'Show full article',
					'option3' => 'Hide article',
				),
			),

            array(
				'id'       => 'thinkup_section_post_layout',
				'type'     => $thinkup_section_field,
				'title'    => __( ' ', 'melos' ),
				'subtitle' => __('<span class="redux-title">Control Single Post Page</span>', 'melos'),
				'indent'   => false,
            ),

			array(
				'title'                      => __('Post Layout', 'melos'), 
				$thinkup_subtitle_panel      => __('Select blog page layout. This will only be applied to individual posts and not the main blog page.', 'melos'),
				$thinkup_subtitle_customizer => __('Select blog page layout. This will only be applied to individual posts and not the main blog page.', 'melos'),
				'id'                         => 'thinkup_post_layout',
				'type'                       => 'image_select',
				'compiler'                   => true,
				'options'                    => array(
					'option1' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/blog/option01.png',
					'option2' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/blog/option02.png',
					'option3' => trailingslashit( get_template_directory_uri() ) . 'admin/main/assets/img/layout/blog/option03.png',
				),
			),

			array(
				'title'                      => __('Select a Sidebar', 'melos'), 
				$thinkup_subtitle_panel      => __('Choose a sidebar to use with the layout.', 'melos'),
				$thinkup_subtitle_customizer => __('Choose a sidebar to use with the layout.', 'melos'),
				'id'                         => 'thinkup_post_sidebars',
				'type'                       => 'select',
				'data'                       => 'sidebars',
				'required'                   => array( 
					array( 'thinkup_post_layout', '=', 
						array( 'option2', 'option3' ),
					), 
				)
			),

			array(
				'title'                      => __('Show Social Sharing', 'melos'), 
				$thinkup_subtitle_panel      => __('Check to enable social media sharing.', 'melos'),
				$thinkup_subtitle_customizer => __('Check to enable social media sharing.', 'melos'),
				'id'                         => 'thinkup_post_share',
				'type'                       => 'switch',
				'default'                    => '0',
			),

			array(
				'title'                      => __('Sharing Message', 'melos'), 
				$thinkup_subtitle_panel      => __('Specify a message to encourage sharing.<br />Leave blank to display the default message.', 'melos'),
				$thinkup_subtitle_customizer => __('Specify a message to encourage sharing.<br />Leave blank to display the default message.', 'melos'),
				'id'                         => 'thinkup_post_sharemessage',
				'type'                       => 'text',
				'validate'                   => 'html',
				'required'                   => array( 
					array( 'thinkup_post_share', '=', 
						array( '1' ),
					), 
				)
			),

			array(
				'id'          => 'thinkup_post_sharecheck',
				'type'        => 'checkbox',
				'options'     => array(
					'option1' => 'Enable sharing on Facebook',
					'option2' => 'Enable sharing on Twitter',
					'option3' => 'Enable sharing on Google+',
					'option4' => 'Enable sharing on LinkedIn',
					'option5' => 'Enable sharing on Tumblr',
					'option6' => 'Enable sharing on Pinterest',
					'option7' => 'Enable sharing on email',
					),
				'required'    => array( 
					array( 'thinkup_post_share', '=', 
						array( '1' ),
					), 
				)
			),	
		)
	) );


	// -----------------------------------------------------------------------------------
	//	15.	Support
	// -----------------------------------------------------------------------------------

    Redux::setSection( $opt_name, array(
		'title'      => __('Support', 'melos'),
		'desc'       => __('For premium support direct from the theme developers, or advice on customizations please <a href="http://www.thinkupthemes.com/themes/melos/" target="_blank">upgrade</a> to Melos Pro or purchase a <a href="http://www.thinkupthemes.com/pricing/" target="_blank">Theme Subscription</a>.', 'melos'),
		'icon'       => 'el el-user',
		'icon_class' => '',
        'id'         => 'thinkup_section_support',
        'subsection' => $thinkup_customizer_subsection,
        'customizer' => true,
		'fields'     => array(

		)
	) );


	// -----------------------------------------------------------------------------------
	//	15.	Documentation
	// -----------------------------------------------------------------------------------

	Redux::setSection( $opt_name, array(
		'title'            => __( 'Documentation', 'melos' ),
		'id'               => 'thinkup_theme_documentation',
		'desc'             => __( 'Click the button below to view the theme documentation.', 'melos' ),
		'customizer_width' => '400px',
		'icon'             => 'el el-home',
		'customizer'       => true,
		'fields'           => array(
			array(
				$thinkup_subtitle_panel      => __('', 'melos'),
				$thinkup_subtitle_customizer => __('', 'melos'),
				'id'                         => 'thinkup_theme_documentation_button',
				'type'                       => 'raw',
				'content'                    => '<a href="' . admin_url( 'themes.php?page=thinkup-welcome&tab=documentation' ) . '" target="_blank" class="button button-secondary" style="text-align: center;width: 100%;height: 45px;line-height: 45px;padding: 0;margin: -5px auto 19px;">' . __( 'View Theme Docs', 'melos' ) . '</a>',
				'default'                    => '' 
			),
		)
	) );


	// -----------------------------------------------------------------------------------
	//	16.	Upgrade Now
	// -----------------------------------------------------------------------------------

    Redux::setSection( $opt_name, array(
		'title'      => __('Upgrade (10% off)', 'melos'),
		'desc'       => __('', 'melos'),
		'icon'       => 'el el-arrow-up',
		'icon_class' => '',
        'id'         => 'thinkup_section_upgrade',
        'subsection' => false,
        'customizer' => true,
		'fields'     => array(

			// Ensures ThinkUpThemes upgrade code is output
			array(
				'title'                      => __('', 'melos'), 
				$thinkup_subtitle_panel      => __('', 'melos'),
				$thinkup_subtitle_customizer => __('', 'melos'),
				'id'                         => 'thinkup_upgrade_content',
				'type'                       => 'thinkup_upgrade',
				'upgrade_url'                => '//www.thinkupthemes.com/themes/melos/',
			),
		)
	) );

    Redux::setSection( $opt_name, array(
		'type' => 'divide',
	) );


/**/
    /*
     * <--- END SECTIONS
     */

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=> true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $return['error'] = $field;
                $field['msg']    = 'your custom error message';
            }

            if ( $warning == true ) {
                $return['warning'] = $field;
                $field['msg']      = 'your custom warning message';
            }

            return $return;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }

