<?php
/**
 * Theme setup functions.
 *
 * @package ThinkUpThemes
 */


/* ----------------------------------------------------------------------------------
	ADD CUSTOM VARIABLES
---------------------------------------------------------------------------------- */

/* Add global variables used in Redux framework */
function thinkup_reduxvariables() { 

	// Fetch options stored in $data.
	global $thinkup_redux_variables;

	//  1.1.     General settings.
	$GLOBALS['thinkup_general_logoswitch']                  = thinkup_var ( 'thinkup_general_logoswitch' );
	$GLOBALS['thinkup_general_logolink']                    = thinkup_var ( 'thinkup_general_logolink', 'url' );
	$GLOBALS['thinkup_general_logolinkretina']              = thinkup_var ( 'thinkup_general_logolinkretina', 'url' );
	$GLOBALS['thinkup_general_sitetitle']                   = thinkup_var ( 'thinkup_general_sitetitle' );
	$GLOBALS['thinkup_general_sitedescription']             = thinkup_var ( 'thinkup_general_sitedescription' );
	$GLOBALS['thinkup_general_faviconlink']                 = thinkup_var ( 'thinkup_general_faviconlink', 'url' );
	$GLOBALS['thinkup_general_layout']                      = thinkup_var ( 'thinkup_general_layout' );
	$GLOBALS['thinkup_general_sidebars']                    = thinkup_var ( 'thinkup_general_sidebars' );
	$GLOBALS['thinkup_general_fixedlayoutswitch']           = thinkup_var ( 'thinkup_general_fixedlayoutswitch' );
	$GLOBALS['thinkup_general_boxlayout']                   = thinkup_var ( 'thinkup_general_boxlayout' );
	$GLOBALS['thinkup_general_boxbackgroundcolor']          = thinkup_var ( 'thinkup_general_boxbackgroundcolor' );
	$GLOBALS['thinkup_general_boxbackgroundimage']          = thinkup_var ( 'thinkup_general_boxbackgroundimage', 'url' );
	$GLOBALS['thinkup_general_boxedposition']               = thinkup_var ( 'thinkup_general_boxedposition' );
	$GLOBALS['thinkup_general_boxedrepeat']                 = thinkup_var ( 'thinkup_general_boxedrepeat' );
	$GLOBALS['thinkup_general_boxedsize']                   = thinkup_var ( 'thinkup_general_boxedsize' );
	$GLOBALS['thinkup_general_boxedattachment']             = thinkup_var ( 'thinkup_general_boxedattachment' );
	$GLOBALS['thinkup_general_introswitch']                 = thinkup_var ( 'thinkup_general_introswitch' );
	$GLOBALS['thinkup_general_breadcrumbswitch']            = thinkup_var ( 'thinkup_general_breadcrumbswitch' );
	$GLOBALS['thinkup_general_breadcrumbdelimeter']         = thinkup_var ( 'thinkup_general_breadcrumbdelimeter' );
	$GLOBALS['thinkup_general_analyticscode']               = thinkup_var ( 'thinkup_general_analyticscode' );
	$GLOBALS['thinkup_general_customcss']                   = thinkup_var ( 'thinkup_general_customcss' );
	$GLOBALS['thinkup_general_customjavafront']             = thinkup_var ( 'thinkup_general_customjavafront' );

	//  1.2.1    Homepage.
	$GLOBALS['thinkup_homepage_layout']                     = thinkup_var ( 'thinkup_homepage_layout' );
	$GLOBALS['thinkup_homepage_sidebars']                   = thinkup_var ( 'thinkup_homepage_sidebars' );
	$GLOBALS['thinkup_homepage_sliderswitch']               = thinkup_var ( 'thinkup_homepage_sliderswitch' );
	$GLOBALS['thinkup_homepage_slidername']                 = thinkup_var ( 'thinkup_homepage_slidername' );
	$GLOBALS['thinkup_homepage_sliderpreset']               = thinkup_var ( 'thinkup_homepage_sliderpreset' );
	$GLOBALS['thinkup_homepage_sliderstyle']                = thinkup_var ( 'thinkup_homepage_sliderstyle' );
	$GLOBALS['thinkup_homepage_sliderspeed']                = thinkup_var ( 'thinkup_homepage_sliderspeed' );
	$GLOBALS['thinkup_homepage_sliderpresetwidth']          = thinkup_var ( 'thinkup_homepage_sliderpresetwidth' );
	$GLOBALS['thinkup_homepage_sliderpresetheight']         = thinkup_var ( 'thinkup_homepage_sliderpresetheight' );
	$GLOBALS['thinkup_homepage_introswitch']                = thinkup_var ( 'thinkup_homepage_introswitch' );
	$GLOBALS['thinkup_homepage_introaction']                = thinkup_var ( 'thinkup_homepage_introaction' );
	$GLOBALS['thinkup_homepage_introactionteaser']          = thinkup_var ( 'thinkup_homepage_introactionteaser' );
	$GLOBALS['thinkup_homepage_introactiontext1']           = thinkup_var ( 'thinkup_homepage_introactiontext1' );
	$GLOBALS['thinkup_homepage_introactionlink1']           = thinkup_var ( 'thinkup_homepage_introactionlink1' );
	$GLOBALS['thinkup_homepage_introactionpage1']           = thinkup_var ( 'thinkup_homepage_introactionpage1' );
	$GLOBALS['thinkup_homepage_introactioncustom1']         = thinkup_var ( 'thinkup_homepage_introactioncustom1' );

	//  1.2.2    Homepage (Content).
	$GLOBALS['thinkup_homepage_sectionswitch']              = thinkup_var ( 'thinkup_homepage_sectionswitch' );
	$GLOBALS['thinkup_homepage_section1_image']             = thinkup_var ( 'thinkup_homepage_section1_image', 'id' );
	$GLOBALS['thinkup_homepage_section1_imagesize']         = thinkup_var ( 'thinkup_homepage_section1_imagesize' );
	$GLOBALS['thinkup_homepage_section1_title']             = thinkup_var ( 'thinkup_homepage_section1_title' );
	$GLOBALS['thinkup_homepage_section1_desc']              = thinkup_var ( 'thinkup_homepage_section1_desc' );
	$GLOBALS['thinkup_homepage_section1_link']              = thinkup_var ( 'thinkup_homepage_section1_link' );
	$GLOBALS['thinkup_homepage_section1_url']               = thinkup_var ( 'thinkup_homepage_section1_url' );
	$GLOBALS['thinkup_homepage_section1_target']            = thinkup_var ( 'thinkup_homepage_section1_target' );	
	$GLOBALS['thinkup_homepage_section1_button']            = thinkup_var ( 'thinkup_homepage_section1_button' );
	$GLOBALS['thinkup_homepage_section2_image']             = thinkup_var ( 'thinkup_homepage_section2_image', 'id' );
	$GLOBALS['thinkup_homepage_section2_imagesize']         = thinkup_var ( 'thinkup_homepage_section2_imagesize' );
	$GLOBALS['thinkup_homepage_section2_title']             = thinkup_var ( 'thinkup_homepage_section2_title' );
	$GLOBALS['thinkup_homepage_section2_desc']              = thinkup_var ( 'thinkup_homepage_section2_desc' );	
	$GLOBALS['thinkup_homepage_section2_link']              = thinkup_var ( 'thinkup_homepage_section2_link' );
	$GLOBALS['thinkup_homepage_section2_url']               = thinkup_var ( 'thinkup_homepage_section2_url' );
	$GLOBALS['thinkup_homepage_section2_button']            = thinkup_var ( 'thinkup_homepage_section2_button' );
	$GLOBALS['thinkup_homepage_section2_target']            = thinkup_var ( 'thinkup_homepage_section2_target' );
	$GLOBALS['thinkup_homepage_section3_image']             = thinkup_var ( 'thinkup_homepage_section3_image', 'id' );
	$GLOBALS['thinkup_homepage_section3_imagesize']         = thinkup_var ( 'thinkup_homepage_section3_imagesize' );
	$GLOBALS['thinkup_homepage_section3_title']             = thinkup_var ( 'thinkup_homepage_section3_title' );
	$GLOBALS['thinkup_homepage_section3_desc']              = thinkup_var ( 'thinkup_homepage_section3_desc' );	
	$GLOBALS['thinkup_homepage_section3_link']              = thinkup_var ( 'thinkup_homepage_section3_link' );
	$GLOBALS['thinkup_homepage_section3_url']               = thinkup_var ( 'thinkup_homepage_section3_url' );
	$GLOBALS['thinkup_homepage_section3_button']            = thinkup_var ( 'thinkup_homepage_section3_button' );
	$GLOBALS['thinkup_homepage_section3_target']            = thinkup_var ( 'thinkup_homepage_section3_target' );

	//  1.3.     Header
	$GLOBALS['thinkup_header_styleswitchpre']               = thinkup_var ( 'thinkup_header_styleswitchpre' );
	$GLOBALS['thinkup_header_styleswitch']                  = thinkup_var ( 'thinkup_header_styleswitch' );
	$GLOBALS['thinkup_header_locationswitch']               = thinkup_var ( 'thinkup_header_locationswitch' );
	$GLOBALS['thinkup_header_stickyswitch']                 = thinkup_var ( 'thinkup_header_stickyswitch' );
	$GLOBALS['thinkup_header_searchswitchpre']              = thinkup_var ( 'thinkup_header_searchswitchpre' );
	$GLOBALS['thinkup_header_searchswitch']                 = thinkup_var ( 'thinkup_header_searchswitch' );

	//  1.4.     Footer.
	$GLOBALS['thinkup_footer_layout']                       = thinkup_var ( 'thinkup_footer_layout' );
	$GLOBALS['thinkup_footer_widgetswitch']                 = thinkup_var ( 'thinkup_footer_widgetswitch' );
	$GLOBALS['thinkup_footer_scroll']                       = thinkup_var ( 'thinkup_footer_scroll' );	
	$GLOBALS['thinkup_footer_copyright']                    = thinkup_var ( 'thinkup_footer_copyright' );
	$GLOBALS['thinkup_subfooter_layout']                    = thinkup_var ( 'thinkup_subfooter_layout' );
	$GLOBALS['thinkup_subfooter_widgetswitch']              = thinkup_var ( 'thinkup_subfooter_widgetswitch' );
	$GLOBALS['thinkup_subfooter_widgetclose']               = thinkup_var ( 'thinkup_subfooter_widgetclose' );
	$GLOBALS['thinkup_footer_outroswitch']                  = thinkup_var ( 'thinkup_footer_outroswitch' );
	$GLOBALS['thinkup_footer_outroaction']                  = thinkup_var ( 'thinkup_footer_outroaction' );
	$GLOBALS['thinkup_footer_outroactionteaser']            = thinkup_var ( 'thinkup_footer_outroactionteaser' );
	$GLOBALS['thinkup_footer_outroactiontext1']             = thinkup_var ( 'thinkup_footer_outroactiontext1' );
	$GLOBALS['thinkup_footer_outroactionlink1']             = thinkup_var ( 'thinkup_footer_outroactionlink1' );
	$GLOBALS['thinkup_footer_outroactionpage1']             = thinkup_var ( 'thinkup_footer_outroactionpage1' );
	$GLOBALS['thinkup_footer_outroactioncustom1']           = thinkup_var ( 'thinkup_footer_outroactioncustom1' );

	//  1.3. - 1.4. Social Media.
	$GLOBALS['thinkup_header_socialswitchpre']              = thinkup_var ( 'thinkup_header_socialswitchpre' );
	$GLOBALS['thinkup_header_socialswitchmain']             = thinkup_var ( 'thinkup_header_socialswitchmain' );
	$GLOBALS['thinkup_header_socialswitchfooter']           = thinkup_var ( 'thinkup_header_socialswitchfooter' );
	$GLOBALS['thinkup_header_socialmessage']                = thinkup_var ( 'thinkup_header_socialmessage' );
	$GLOBALS['thinkup_header_facebookswitch']               = thinkup_var ( 'thinkup_header_facebookswitch' );
	$GLOBALS['thinkup_header_facebooklink']                 = thinkup_var ( 'thinkup_header_facebooklink' );
	$GLOBALS['thinkup_header_facebookiconswitch']           = thinkup_var ( 'thinkup_header_facebookiconswitch' );
	$GLOBALS['thinkup_header_facebookcustomicon']           = thinkup_var ( 'thinkup_header_facebookcustomicon', 'url' );
	$GLOBALS['thinkup_header_twitterswitch']                = thinkup_var ( 'thinkup_header_twitterswitch' );
	$GLOBALS['thinkup_header_twitterlink']                  = thinkup_var ( 'thinkup_header_twitterlink' );
	$GLOBALS['thinkup_header_twittericonswitch']            = thinkup_var ( 'thinkup_header_twittericonswitch' );
	$GLOBALS['thinkup_header_twittercustomicon']            = thinkup_var ( 'thinkup_header_twittercustomicon', 'url' );
	$GLOBALS['thinkup_header_googleswitch']                 = thinkup_var ( 'thinkup_header_googleswitch' );
	$GLOBALS['thinkup_header_googlelink']                   = thinkup_var ( 'thinkup_header_googlelink' );
	$GLOBALS['thinkup_header_googleiconswitch']             = thinkup_var ( 'thinkup_header_googleiconswitch' );
	$GLOBALS['thinkup_header_googlecustomicon']             = thinkup_var ( 'thinkup_header_googlecustomicon', 'url' );
	$GLOBALS['thinkup_header_linkedinswitch']               = thinkup_var ( 'thinkup_header_linkedinswitch' );
	$GLOBALS['thinkup_header_linkedinlink']                 = thinkup_var ( 'thinkup_header_linkedinlink' );
	$GLOBALS['thinkup_header_linkediniconswitch']           = thinkup_var ( 'thinkup_header_linkediniconswitch' );
	$GLOBALS['thinkup_header_linkedincustomicon']           = thinkup_var ( 'thinkup_header_linkedincustomicon', 'url' );
	$GLOBALS['thinkup_header_flickrswitch']                 = thinkup_var ( 'thinkup_header_flickrswitch' );
	$GLOBALS['thinkup_header_flickrlink']                   = thinkup_var ( 'thinkup_header_flickrlink' );
	$GLOBALS['thinkup_header_flickriconswitch']             = thinkup_var ( 'thinkup_header_flickriconswitch' );
	$GLOBALS['thinkup_header_flickrcustomicon']             = thinkup_var ( 'thinkup_header_flickrcustomicon', 'url' );
	$GLOBALS['thinkup_header_youtubeswitch']                = thinkup_var ( 'thinkup_header_youtubeswitch' );
	$GLOBALS['thinkup_header_youtubelink']                  = thinkup_var ( 'thinkup_header_youtubelink' );
	$GLOBALS['thinkup_header_youtubeiconswitch']            = thinkup_var ( 'thinkup_header_youtubeiconswitch' );
	$GLOBALS['thinkup_header_youtubecustomicon']            = thinkup_var ( 'thinkup_header_youtubecustomicon', 'url' );
	$GLOBALS['thinkup_header_rssswitch']                    = thinkup_var ( 'thinkup_header_rssswitch' );
	$GLOBALS['thinkup_header_rsslink']                      = thinkup_var ( 'thinkup_header_rsslink' );
	$GLOBALS['thinkup_header_rssiconswitch']                = thinkup_var ( 'thinkup_header_rssiconswitch' );
	$GLOBALS['thinkup_header_rsscustomicon']                = thinkup_var ( 'thinkup_header_rsscustomicon', 'url' );

	//  1.5.1.   Blog - Main page.
	$GLOBALS['thinkup_blog_layout']                         = thinkup_var ( 'thinkup_blog_layout' );
	$GLOBALS['thinkup_blog_sidebars']                       = thinkup_var ( 'thinkup_blog_sidebars' );
	$GLOBALS['thinkup_blog_style']                          = thinkup_var ( 'thinkup_blog_style' );
	$GLOBALS['thinkup_blog_style1layout']                   = thinkup_var ( 'thinkup_blog_style1layout' );
	$GLOBALS['thinkup_blog_style2layout']                   = thinkup_var ( 'thinkup_blog_style2layout' );
	$GLOBALS['thinkup_blog_lightbox']                       = thinkup_var ( 'thinkup_blog_hovercheck', 'option1' );
	$GLOBALS['thinkup_blog_link']                           = thinkup_var ( 'thinkup_blog_hovercheck', 'option2' );
	$GLOBALS['thinkup_blog_title']                          = thinkup_var ( 'thinkup_blog_title' );
	$GLOBALS['thinkup_blog_date']                           = thinkup_var ( 'thinkup_blog_contentcheck', 'option1' );
	$GLOBALS['thinkup_blog_author']                         = thinkup_var ( 'thinkup_blog_contentcheck', 'option2' );
	$GLOBALS['thinkup_blog_comment']                        = thinkup_var ( 'thinkup_blog_contentcheck', 'option3' );
	$GLOBALS['thinkup_blog_category']                       = thinkup_var ( 'thinkup_blog_contentcheck', 'option4' );
	$GLOBALS['thinkup_blog_tag']                            = thinkup_var ( 'thinkup_blog_contentcheck', 'option5' );
	$GLOBALS['thinkup_blog_postswitch']                     = thinkup_var ( 'thinkup_blog_postswitch' );
	$GLOBALS['thinkup_blog_postexcerpt']                    = thinkup_var ( 'thinkup_blog_postexcerpt' );

	//  1.5.2.   Blog - Single post.
	$GLOBALS['thinkup_post_layout']                         = thinkup_var ( 'thinkup_post_layout' );
	$GLOBALS['thinkup_post_sidebars']                       = thinkup_var ( 'thinkup_post_sidebars' );
	$GLOBALS['thinkup_post_date']                           = thinkup_var ( 'thinkup_post_contentcheck', 'option1' );
	$GLOBALS['thinkup_post_author']                         = thinkup_var ( 'thinkup_post_contentcheck', 'option2' );
	$GLOBALS['thinkup_post_comment']                        = thinkup_var ( 'thinkup_post_contentcheck', 'option3' );
	$GLOBALS['thinkup_post_category']                       = thinkup_var ( 'thinkup_post_contentcheck', 'option4' );
	$GLOBALS['thinkup_post_tag']                            = thinkup_var ( 'thinkup_post_contentcheck', 'option5' );
	$GLOBALS['thinkup_post_title']                          = thinkup_var ( 'thinkup_post_contentcheck', 'option6' );
	$GLOBALS['thinkup_post_authorbio']                      = thinkup_var ( 'thinkup_post_authorbio' );
	$GLOBALS['thinkup_post_share']                          = thinkup_var ( 'thinkup_post_share' );
	$GLOBALS['thinkup_post_sharemessage']                   = thinkup_var ( 'thinkup_post_sharemessage' );
	$GLOBALS['thinkup_post_sharefacebook']                  = thinkup_var ( 'thinkup_post_sharecheck', 'option1' );
	$GLOBALS['thinkup_post_sharetwitter']                   = thinkup_var ( 'thinkup_post_sharecheck', 'option2' );
	$GLOBALS['thinkup_post_sharegoogle']                    = thinkup_var ( 'thinkup_post_sharecheck', 'option3' );
	$GLOBALS['thinkup_post_sharelinkedin']                  = thinkup_var ( 'thinkup_post_sharecheck', 'option4' );
	$GLOBALS['thinkup_post_sharetumblr']                    = thinkup_var ( 'thinkup_post_sharecheck', 'option5' );
	$GLOBALS['thinkup_post_sharepinterest']                 = thinkup_var ( 'thinkup_post_sharecheck', 'option6' );
	$GLOBALS['thinkup_post_shareemail']                     = thinkup_var ( 'thinkup_post_sharecheck', 'option7' );

	//  1.6.     Portfolio.
	$GLOBALS['thinkup_portfolio_layout']                    = thinkup_var ( 'thinkup_portfolio_layout' );
	$GLOBALS['thinkup_portfolio_sidebars']                  = thinkup_var ( 'thinkup_portfolio_sidebars' );
	$GLOBALS['thinkup_portfolio_filter']                    = thinkup_var ( 'thinkup_portfolio_filter' );
	$GLOBALS['thinkup_portfolio_lightbox']                  = thinkup_var ( 'thinkup_portfolio_hovercheck', 'option1' );
	$GLOBALS['thinkup_portfolio_link']                      = thinkup_var ( 'thinkup_portfolio_hovercheck', 'option2' );
	$GLOBALS['thinkup_portfolio_redirect']                  = thinkup_var ( 'thinkup_portfolio_redirect' );
	$GLOBALS['thinkup_portfolio_title']                     = thinkup_var ( 'thinkup_portfolio_check', 'option1' );
	$GLOBALS['thinkup_portfolio_excerpt']                   = thinkup_var ( 'thinkup_portfolio_check', 'option2' );
	$GLOBALS['thinkup_portfolio_contentstyleswitch']        = thinkup_var ( 'thinkup_portfolio_contentstyleswitch' );
	$GLOBALS['thinkup_portfolio_sliderswitch']              = thinkup_var ( 'thinkup_portfolio_sliderswitch' );
	$GLOBALS['thinkup_portfolio_slidercategory']            = thinkup_var ( 'thinkup_portfolio_slidercategory' );
	$GLOBALS['thinkup_portfolio_sliderheight']              = thinkup_var ( 'thinkup_portfolio_sliderheight' );
	$GLOBALS['thinkup_portfolio_featuredswitch']            = thinkup_var ( 'thinkup_portfolio_featuredswitch' );
	$GLOBALS['thinkup_portfolio_featuredcategory']          = thinkup_var ( 'thinkup_portfolio_featuredcategory' );
	$GLOBALS['thinkup_portfolio_featuredcategoryitems']     = thinkup_var ( 'thinkup_portfolio_featuredcategoryitems' );
	$GLOBALS['thinkup_portfolio_featuredcategoryscroll']    = thinkup_var ( 'thinkup_portfolio_featuredcategoryscroll' );
	$GLOBALS['thinkup_project_layout']                      = thinkup_var ( 'thinkup_project_layout' );
	$GLOBALS['thinkup_project_sidebars']                    = thinkup_var ( 'thinkup_project_sidebars' );
	$GLOBALS['thinkup_project_navigationswitch']            = thinkup_var ( 'thinkup_project_navigationswitch' );

	//  1.7.     Contact Page.
	$GLOBALS['thinkup_contact_map']                         = thinkup_var ( 'thinkup_contact_map' );
	$GLOBALS['thinkup_contact_mapposition']                 = thinkup_var ( 'thinkup_contact_mapposition' );
	$GLOBALS['thinkup_contact_form']                        = thinkup_var ( 'thinkup_contact_form' );
	$GLOBALS['thinkup_contact_info']                        = thinkup_var ( 'thinkup_contact_info' );
	$GLOBALS['thinkup_contact_address']                     = thinkup_var ( 'thinkup_contact_address' );
	$GLOBALS['thinkup_contact_phone']                       = thinkup_var ( 'thinkup_contact_phone' );
	$GLOBALS['thinkup_contact_email']                       = thinkup_var ( 'thinkup_contact_email' );
	$GLOBALS['thinkup_contact_website']                     = thinkup_var ( 'thinkup_contact_website' );
	$GLOBALS['thinkup_contact_iconswitch']                  = thinkup_var ( 'thinkup_contact_iconswitch' );

	//  1.8.     Special pages.
	$GLOBALS['thinkup_client_redirect']                     = thinkup_var ( 'thinkup_client_redirect' );
	$GLOBALS['thinkup_client_category']                     = thinkup_var ( 'thinkup_client_category' );
	$GLOBALS['thinkup_team_styleswitch']                    = thinkup_var ( 'thinkup_team_styleswitch' );
	$GLOBALS['thinkup_team_layout']                         = thinkup_var ( 'thinkup_team_layout' );
	$GLOBALS['thinkup_team_hoverstyleswitch']               = thinkup_var ( 'thinkup_team_hoverstyleswitch' );
	$GLOBALS['thinkup_team_membername']                     = thinkup_var ( 'thinkup_team_contentcheck', 'option1' );
	$GLOBALS['thinkup_team_memberposition']                 = thinkup_var ( 'thinkup_team_contentcheck', 'option2' );
	$GLOBALS['thinkup_team_memberexcerpt']                  = thinkup_var ( 'thinkup_team_contentcheck', 'option3' );
	$GLOBALS['thinkup_team_membersocial']                   = thinkup_var ( 'thinkup_team_contentcheck', 'option4' );
	$GLOBALS['thinkup_team_redirect']                       = thinkup_var ( 'thinkup_team_redirect' );
	$GLOBALS['thinkup_testimonal_styleswitch']              = thinkup_var ( 'thinkup_testimonal_styleswitch' );
	$GLOBALS['thinkup_testimonial_links']                   = thinkup_var ( 'thinkup_testimonial_links' );
	$GLOBALS['thinkup_testimonial_redirect']                = thinkup_var ( 'thinkup_testimonial_redirect' );
	$GLOBALS['thinkup_testimonial_category']                = thinkup_var ( 'thinkup_testimonial_category' );
	$GLOBALS['thinkup_404_content']                         = thinkup_var ( 'thinkup_404_content' );
	$GLOBALS['thinkup_404_contentparagraph']                = thinkup_var ( 'thinkup_404_contentparagraph' );

	//  1.9.     Notification bar.
	$GLOBALS['thinkup_notification_switch']                 = thinkup_var ( 'thinkup_notification_switch' );
	$GLOBALS['thinkup_notification_text']                   = thinkup_var ( 'thinkup_notification_text' );
	$GLOBALS['thinkup_notification_button']                 = thinkup_var ( 'thinkup_notification_button' );
	$GLOBALS['thinkup_notification_link']                   = thinkup_var ( 'thinkup_notification_link' );
	$GLOBALS['thinkup_notification_linkpage']               = thinkup_var ( 'thinkup_notification_linkpage' );
	$GLOBALS['thinkup_notification_linkcustom']             = thinkup_var ( 'thinkup_notification_linkcustom' );
	$GLOBALS['thinkup_notification_homeswitch']             = thinkup_var ( 'thinkup_notification_homeswitch' );
	$GLOBALS['thinkup_notification_fixtop']                 = thinkup_var ( 'thinkup_notification_fixtop' );
	$GLOBALS['thinkup_notification_backgroundcolourswitch'] = thinkup_var ( 'thinkup_notification_backgroundcolourswitch' );
	$GLOBALS['thinkup_notification_backgroundcolour']       = thinkup_var ( 'thinkup_notification_backgroundcolour' );
	$GLOBALS['thinkup_notification_maintextcolourswitch']   = thinkup_var ( 'thinkup_notification_maintextcolourswitch' );
	$GLOBALS['thinkup_notification_maintextcolour']         = thinkup_var ( 'thinkup_notification_maintextcolour' );
	$GLOBALS['thinkup_notification_buttoncolourswitch']     = thinkup_var ( 'thinkup_notification_buttoncolourswitch' );
	$GLOBALS['thinkup_notification_buttoncolour']           = thinkup_var ( 'thinkup_notification_buttoncolour' );
	$GLOBALS['thinkup_notification_buttontextcolourswitch'] = thinkup_var ( 'thinkup_notification_buttontextcolourswitch' );
	$GLOBALS['thinkup_notification_buttontextcolour']       = thinkup_var ( 'thinkup_notification_buttontextcolour' );

	//  1.10.     Search engine optimisation.
	$GLOBALS['thinkup_seo_switch']                          = thinkup_var ( 'thinkup_seo_switch' );
	$GLOBALS['thinkup_seo_sitetitle']                       = thinkup_var ( 'thinkup_seo_sitetitle' );
	$GLOBALS['thinkup_seo_homedescription']                 = thinkup_var ( 'thinkup_seo_homedescription' );
	$GLOBALS['thinkup_seo_sitekeywords']                    = thinkup_var ( 'thinkup_seo_sitekeywords' );
	$GLOBALS['thinkup_seo_noodp']                           = thinkup_var ( 'thinkup_seo_metarobots', 'option1' );
	$GLOBALS['thinkup_seo_noydir']                          = thinkup_var ( 'thinkup_seo_metarobots', 'option1' );

	//  1.11.     Typography.
	$GLOBALS['thinkup_font_bodyswitch']                     = thinkup_var ( 'thinkup_font_bodyswitch' );
	$GLOBALS['thinkup_font_bodystandard']                   = thinkup_var ( 'thinkup_font_bodystandard' );
	$GLOBALS['thinkup_font_bodygoogle']                     = thinkup_var ( 'thinkup_font_bodygoogle' );
	$GLOBALS['thinkup_font_bodyheadingswitch']              = thinkup_var ( 'thinkup_font_bodyheadingswitch' );
	$GLOBALS['thinkup_font_bodyheadingstandard']            = thinkup_var ( 'thinkup_font_bodyheadingstandard' );
	$GLOBALS['thinkup_font_bodyheadinggoogle']              = thinkup_var ( 'thinkup_font_bodyheadinggoogle' );
	$GLOBALS['thinkup_font_preheaderswitch']                = thinkup_var ( 'thinkup_font_preheaderswitch' );
	$GLOBALS['thinkup_font_preheaderstandard']              = thinkup_var ( 'thinkup_font_preheaderstandard' );
	$GLOBALS['thinkup_font_preheadergoogle']                = thinkup_var ( 'thinkup_font_preheadergoogle' );
	$GLOBALS['thinkup_font_mainheaderswitch']               = thinkup_var ( 'thinkup_font_mainheaderswitch' );
	$GLOBALS['thinkup_font_mainheaderstandard']             = thinkup_var ( 'thinkup_font_mainheaderstandard' );
	$GLOBALS['thinkup_font_mainheadergoogle']               = thinkup_var ( 'thinkup_font_mainheadergoogle' );
	$GLOBALS['thinkup_font_footerheadingswitch']            = thinkup_var ( 'thinkup_font_footerheadingswitch' );
	$GLOBALS['thinkup_font_footerheadingstandard']          = thinkup_var ( 'thinkup_font_footerheadingstandard' );
	$GLOBALS['thinkup_font_footerheadinggoogle']            = thinkup_var ( 'thinkup_font_footerheadinggoogle' );
	$GLOBALS['thinkup_font_mainfooterswitch']               = thinkup_var ( 'thinkup_font_mainfooterswitch' );
	$GLOBALS['thinkup_font_mainfooterstandard']             = thinkup_var ( 'thinkup_font_mainfooterstandard' );
	$GLOBALS['thinkup_font_mainfootergoogle']               = thinkup_var ( 'thinkup_font_mainfootergoogle' );
	$GLOBALS['thinkup_font_postfooterswitch']               = thinkup_var ( 'thinkup_font_postfooterswitch' );
	$GLOBALS['thinkup_font_postfooterstandard']             = thinkup_var ( 'thinkup_font_postfooterstandard' );
	$GLOBALS['thinkup_font_postfootergoogle']               = thinkup_var ( 'thinkup_font_postfootergoogle' );
	$GLOBALS['thinkup_font_slidertitleswitch']              = thinkup_var ( 'thinkup_font_slidertitleswitch' );
	$GLOBALS['thinkup_font_slidertitlestandard']            = thinkup_var ( 'thinkup_font_slidertitlestandard' );
	$GLOBALS['thinkup_font_slidertitlegoogle']              = thinkup_var ( 'thinkup_font_slidertitlegoogle' );
	$GLOBALS['thinkup_font_slidertextswitch']               = thinkup_var ( 'thinkup_font_slidertextswitch' );
	$GLOBALS['thinkup_font_slidertextstandard']             = thinkup_var ( 'thinkup_font_slidertextstandard' );
	$GLOBALS['thinkup_font_slidertextgoogle']               = thinkup_var ( 'thinkup_font_slidertextgoogle' );
	$GLOBALS['thinkup_font_bodysize']                       = thinkup_var ( 'thinkup_font_bodysize' );
	$GLOBALS['thinkup_font_h1size']                         = thinkup_var ( 'thinkup_font_h1size' );
	$GLOBALS['thinkup_font_h2size']                         = thinkup_var ( 'thinkup_font_h2size' );
	$GLOBALS['thinkup_font_h3size']                         = thinkup_var ( 'thinkup_font_h3size' );
	$GLOBALS['thinkup_font_h4size']                         = thinkup_var ( 'thinkup_font_h4size' );
	$GLOBALS['thinkup_font_h5size']                         = thinkup_var ( 'thinkup_font_h5size' );
	$GLOBALS['thinkup_font_h6size']                         = thinkup_var ( 'thinkup_font_h6size' );
	$GLOBALS['thinkup_font_sidebarsize']                    = thinkup_var ( 'thinkup_font_sidebarsize' );
	$GLOBALS['thinkup_font_preheadersize']                  = thinkup_var ( 'thinkup_font_preheadersize' );
	$GLOBALS['thinkup_font_preheadersubsize']               = thinkup_var ( 'thinkup_font_preheadersubsize' );
	$GLOBALS['thinkup_font_mainheadersize']                 = thinkup_var ( 'thinkup_font_mainheadersize' );
	$GLOBALS['thinkup_font_mainheadersubsize']              = thinkup_var ( 'thinkup_font_mainheadersubsize' );
	$GLOBALS['thinkup_font_footerheadingsize']              = thinkup_var ( 'thinkup_font_footerheadingsize' );
	$GLOBALS['thinkup_font_mainfootersize']                 = thinkup_var ( 'thinkup_font_mainfootersize' );
	$GLOBALS['thinkup_font_postfootersize']                 = thinkup_var ( 'thinkup_font_postfootersize' );
	$GLOBALS['thinkup_font_slidertitlesize']                = thinkup_var ( 'thinkup_font_slidertitlesize' );
	$GLOBALS['thinkup_font_slidertextsize']                 = thinkup_var ( 'thinkup_font_slidertextsize' );

	//  1.12.     Custom styling.
	$GLOBALS['thinkup_styles_colorswitch']                  = thinkup_var ( 'thinkup_styles_colorswitch' );
	$GLOBALS['thinkup_styles_mainimage']                    = thinkup_var ( 'thinkup_styles_mainimage', 'url' );
	$GLOBALS['thinkup_styles_mainposition']                 = thinkup_var ( 'thinkup_styles_mainposition' );
	$GLOBALS['thinkup_styles_mainrepeat']                   = thinkup_var ( 'thinkup_styles_mainrepeat' );
	$GLOBALS['thinkup_styles_mainsize']                     = thinkup_var ( 'thinkup_styles_mainsize' );
	$GLOBALS['thinkup_styles_mainattachment']               = thinkup_var ( 'thinkup_styles_mainattachment' );
	$GLOBALS['thinkup_styles_colorcustom']                  = thinkup_var ( 'thinkup_styles_colorcustom' );
	$GLOBALS['thinkup_styles_mainswitch']                   = thinkup_var ( 'thinkup_styles_mainswitch' );
	$GLOBALS['thinkup_styles_mainbg']                       = thinkup_var ( 'thinkup_styles_mainbg' );
	$GLOBALS['thinkup_styles_mainheading']                  = thinkup_var ( 'thinkup_styles_mainheading' );
	$GLOBALS['thinkup_styles_maintext']                     = thinkup_var ( 'thinkup_styles_maintext' );
	$GLOBALS['thinkup_styles_mainlink']                     = thinkup_var ( 'thinkup_styles_mainlink' );
	$GLOBALS['thinkup_styles_mainlinkhover']                = thinkup_var ( 'thinkup_styles_mainlinkhover' );
	$GLOBALS['thinkup_styles_preheaderswitch']              = thinkup_var ( 'thinkup_styles_preheaderswitch' );
	$GLOBALS['thinkup_styles_preheaderimage']               = thinkup_var ( 'thinkup_styles_preheaderimage', 'url' );
	$GLOBALS['thinkup_styles_preheaderposition']            = thinkup_var ( 'thinkup_styles_preheaderposition' );
	$GLOBALS['thinkup_styles_preheaderrepeat']              = thinkup_var ( 'thinkup_styles_preheaderrepeat' );
	$GLOBALS['thinkup_styles_preheadersize']                = thinkup_var ( 'thinkup_styles_preheadersize' );
	$GLOBALS['thinkup_styles_preheaderattachment']          = thinkup_var ( 'thinkup_styles_preheaderattachment' );
	$GLOBALS['thinkup_styles_preheaderbg']                  = thinkup_var ( 'thinkup_styles_preheaderbg' );
	$GLOBALS['thinkup_styles_preheaderposition']            = thinkup_var ( 'thinkup_styles_preheaderposition' );
	$GLOBALS['thinkup_styles_preheaderrepeat']              = thinkup_var ( 'thinkup_styles_preheaderrepeat' );
	$GLOBALS['thinkup_styles_preheadersize']                = thinkup_var ( 'thinkup_styles_preheadersize' );
	$GLOBALS['thinkup_styles_preheaderattachment']          = thinkup_var ( 'thinkup_styles_preheaderattachment' );
/*	$GLOBALS['thinkup_styles_preheaderbghover']             = thinkup_var ( 'thinkup_styles_preheaderbghover' );
	$GLOBALS['thinkup_styles_preheadertext']                = thinkup_var ( 'thinkup_styles_preheadertext' );
	$GLOBALS['thinkup_styles_preheadertexthover']           = thinkup_var ( 'thinkup_styles_preheadertexthover' );
	$GLOBALS['thinkup_styles_preheaderdropbg']              = thinkup_var ( 'thinkup_styles_preheaderdropbg' );
	$GLOBALS['thinkup_styles_preheaderdropbghover']         = thinkup_var ( 'thinkup_styles_preheaderdropbghover' );
	$GLOBALS['thinkup_styles_preheaderdroptext']            = thinkup_var ( 'thinkup_styles_preheaderdroptext' );
	$GLOBALS['thinkup_styles_preheaderdroptexthover']       = thinkup_var ( 'thinkup_styles_preheaderdroptexthover' );
	$GLOBALS['thinkup_styles_preheaderdropborder']          = thinkup_var ( 'thinkup_styles_preheaderdropborder' );*/
	$GLOBALS['thinkup_styles_headerswitch']                 = thinkup_var ( 'thinkup_styles_headerswitch' );
	$GLOBALS['thinkup_styles_headerimage']                  = thinkup_var ( 'thinkup_styles_headerimage', 'url' );
	$GLOBALS['thinkup_styles_headerposition']               = thinkup_var ( 'thinkup_styles_headerposition' );
	$GLOBALS['thinkup_styles_headerrepeat']                 = thinkup_var ( 'thinkup_styles_headerrepeat' );
	$GLOBALS['thinkup_styles_headersize']                   = thinkup_var ( 'thinkup_styles_headersize' );
	$GLOBALS['thinkup_styles_headerattachment']             = thinkup_var ( 'thinkup_styles_headerattachment' );
	$GLOBALS['thinkup_styles_headerbg']                     = thinkup_var ( 'thinkup_styles_headerbg' );
	$GLOBALS['thinkup_styles_headerbghover']                = thinkup_var ( 'thinkup_styles_headerbghover' );
	$GLOBALS['thinkup_styles_headertext']                   = thinkup_var ( 'thinkup_styles_headertext' );
	$GLOBALS['thinkup_styles_headertexthover']              = thinkup_var ( 'thinkup_styles_headertexthover' );
	$GLOBALS['thinkup_styles_headerdropbg']                 = thinkup_var ( 'thinkup_styles_headerdropbg' );
	$GLOBALS['thinkup_styles_headerdropbghover']            = thinkup_var ( 'thinkup_styles_headerdropbghover' );
	$GLOBALS['thinkup_styles_headerdroptext']               = thinkup_var ( 'thinkup_styles_headerdroptext' );
	$GLOBALS['thinkup_styles_headerdroptexthover']          = thinkup_var ( 'thinkup_styles_headerdroptexthover' );
	$GLOBALS['thinkup_styles_headerdropborder']             = thinkup_var ( 'thinkup_styles_headerdropborder' );
	$GLOBALS['thinkup_styles_footerswitch']                 = thinkup_var ( 'thinkup_styles_footerswitch' );
	$GLOBALS['thinkup_styles_footerimage']                  = thinkup_var ( 'thinkup_styles_footerimage', 'url' );
	$GLOBALS['thinkup_styles_footerposition']               = thinkup_var ( 'thinkup_styles_footerposition' );
	$GLOBALS['thinkup_styles_footerrepeat']                 = thinkup_var ( 'thinkup_styles_footerrepeat' );
	$GLOBALS['thinkup_styles_footersize']                   = thinkup_var ( 'thinkup_styles_footersize' );
	$GLOBALS['thinkup_styles_footerattachment']             = thinkup_var ( 'thinkup_styles_footerattachment' );
	$GLOBALS['thinkup_styles_footerbg']                     = thinkup_var ( 'thinkup_styles_footerbg' );
	$GLOBALS['thinkup_styles_footertitle']                  = thinkup_var ( 'thinkup_styles_footertitle' );
	$GLOBALS['thinkup_styles_footertext']                   = thinkup_var ( 'thinkup_styles_footertext' );
	$GLOBALS['thinkup_styles_footerlink']                   = thinkup_var ( 'thinkup_styles_footerlink' );
	$GLOBALS['thinkup_styles_footerlinkhover']              = thinkup_var ( 'thinkup_styles_footerlinkhover' );
	$GLOBALS['thinkup_styles_postfooterswitch']             = thinkup_var ( 'thinkup_styles_postfooterswitch' );
	$GLOBALS['thinkup_styles_postfooterimage']              = thinkup_var ( 'thinkup_styles_postfooterimage', 'url' );
	$GLOBALS['thinkup_styles_postfooterposition']           = thinkup_var ( 'thinkup_styles_postfooterposition' );
	$GLOBALS['thinkup_styles_postfooterrepeat']             = thinkup_var ( 'thinkup_styles_postfooterrepeat' );
	$GLOBALS['thinkup_styles_postfootersize']               = thinkup_var ( 'thinkup_styles_postfootersize' );
	$GLOBALS['thinkup_styles_postfooterattachment']         = thinkup_var ( 'thinkup_styles_postfooterattachment' );
	$GLOBALS['thinkup_styles_postfooterbg']                 = thinkup_var ( 'thinkup_styles_postfooterbg' );
	$GLOBALS['thinkup_styles_postfootertext']               = thinkup_var ( 'thinkup_styles_postfootertext' );
	$GLOBALS['thinkup_styles_postfooterlink']               = thinkup_var ( 'thinkup_styles_postfooterlink' );
	$GLOBALS['thinkup_styles_postfooterlinkhover']          = thinkup_var ( 'thinkup_styles_postfooterlinkhover' );

	//  1.13.     Translation.
	$GLOBALS['thinkup_translate_blogreadmore']              = thinkup_var ( 'thinkup_translate_blogreadmore' );
	$GLOBALS['thinkup_translate_contactmaptitle']           = thinkup_var ( 'thinkup_translate_contactmaptitle' );
	$GLOBALS['thinkup_translate_contactformtitle']          = thinkup_var ( 'thinkup_translate_contactformtitle' );
	$GLOBALS['thinkup_translate_contactabouttitle']         = thinkup_var ( 'thinkup_translate_contactabouttitle' );

	//  1.14.     WooCommerce.
	$GLOBALS['thinkup_woocommerce_styleswitch']             = thinkup_var ( 'thinkup_woocommerce_styleswitch' );
	$GLOBALS['thinkup_woocommerce_layout']                  = thinkup_var ( 'thinkup_woocommerce_layout' );
	$GLOBALS['thinkup_woocommerce_sidebars']                = thinkup_var ( 'thinkup_woocommerce_sidebars' );
	$GLOBALS['thinkup_woocommerce_countshop']               = thinkup_var ( 'thinkup_woocommerce_countshop' );	
	$GLOBALS['thinkup_woocommerce_quickview']               = thinkup_var ( 'thinkup_woocommerce_contentcheck', 'option1' );
	$GLOBALS['thinkup_woocommerce_lightbox']                = thinkup_var ( 'thinkup_woocommerce_contentcheck', 'option2' );
	$GLOBALS['thinkup_woocommerce_likes']                   = thinkup_var ( 'thinkup_woocommerce_contentcheck', 'option3' );
	$GLOBALS['thinkup_woocommerce_sharing']                 = thinkup_var ( 'thinkup_woocommerce_contentcheck', 'option4' );
	$GLOBALS['thinkup_woocommerce_excerptshop']             = thinkup_var ( 'thinkup_woocommerce_excerptshop' );
	$GLOBALS['thinkup_woocommerce_excerptlength']           = thinkup_var ( 'thinkup_woocommerce_excerptlength' );
	$GLOBALS['thinkup_woocommerce_layoutproduct']           = thinkup_var ( 'thinkup_woocommerce_layoutproduct' );
	$GLOBALS['thinkup_woocommerce_sidebarsproduct']         = thinkup_var ( 'thinkup_woocommerce_sidebarsproduct' );
	$GLOBALS['thinkup_woocommerce_likesproduct']            = thinkup_var ( 'thinkup_woocommerce_contentcheckproduct', 'option1' );
	$GLOBALS['thinkup_woocommerce_sharingproduct']          = thinkup_var ( 'thinkup_woocommerce_contentcheckproduct', 'option2' );
	$GLOBALS['thinkup_woocommerce_variation']               = thinkup_var ( 'thinkup_woocommerce_variation' );
	$GLOBALS['thinkup_woocommerce_variationtitle']          = thinkup_var ( 'thinkup_woocommerce_variationtitle' );
	$GLOBALS['thinkup_woocommerce_layoutrelated']           = thinkup_var ( 'thinkup_woocommerce_layoutrelated' );
	$GLOBALS['thinkup_woocommerce_countrelated']            = thinkup_var ( 'thinkup_woocommerce_countrelated' );
	$GLOBALS['thinkup_woocommerce_quickviewrelated']        = thinkup_var ( 'thinkup_woocommerce_contentcheckrelated', 'option1' );
	$GLOBALS['thinkup_woocommerce_lightboxrelated']         = thinkup_var ( 'thinkup_woocommerce_contentcheckrelated', 'option2' );
	$GLOBALS['thinkup_woocommerce_likesrelated']            = thinkup_var ( 'thinkup_woocommerce_contentcheckrelated', 'option3' );
	$GLOBALS['thinkup_woocommerce_sharingrelated']          = thinkup_var ( 'thinkup_woocommerce_contentcheckrelated', 'option4' );
	$GLOBALS['thinkup_woocommerce_excerptrelated']          = thinkup_var ( 'thinkup_woocommerce_excerptrelated' );

	//  1.14.     Support.
}
add_action( 'thinkup_hook_header', 'thinkup_reduxvariables' );

?>