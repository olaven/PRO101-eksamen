(function( $ ) {
	
	$(document).ready(function (){

		// Only needed on customizer page - theme options page handled using Redux core customization
		if( jQuery( 'body' ).hasClass( 'wp-customizer' ) ) {

			// ----------------------------------------------------------------------------------------------------------
			// 1. CUSTOMIZER PAGE
			// ----------------------------------------------------------------------------------------------------------

			// Add active class to customizer
			$('body.wp-customizer #accordion-panel-thinkup_theme_options > h3').click(function(e){ 

				var target_control = '#customize-controls';
				var target_preview = '#customize-preview';

				// Remove width classes
				$( target_control ).removeClass( 'thinkup-width-450' );
				$( target_preview ).removeClass( 'thinkup-width-450' );

				// Remove width classes for upgrade section - needed for WordPress pre v4.3.
				$( target_control ).removeClass( 'thinkup-width-950' );
				$( target_preview ).removeClass( 'thinkup-width-950' );

				// Add width classes
				$( target_control ).addClass( 'thinkup-width-450' );
				$( target_preview ).addClass( 'thinkup-width-450' );
			});


			// Remove width classes WordPress v4.3+
			$( 'body.wp-customizer [id*="panel-thinkup_theme_options"] .accordion-section > button, body.wp-customizer [id*="section-thinkup_section_upgrade"] .customize-section-title > button' ).click(function(e){ 

				var target_control = '#customize-controls';
				var target_preview = '#customize-preview';

				$( target_control ).removeClass( 'thinkup-width-450' );
				$( target_preview ).removeClass( 'thinkup-width-450' );

				// Remove width classes for upgrade section
				$( target_control ).removeClass( 'thinkup-width-950' );
				$( target_preview ).removeClass( 'thinkup-width-950' );

			});

			// Remove width classes WordPress pre v4.3
			$( 'body.wp-customizer #customize-header-actions > .primary-actions > .control-panel-back' ).click(function(e){ 

				var target_control = '#customize-controls';
				var target_preview = '#customize-preview';

				$( target_control ).removeClass( 'thinkup-width-450' );
				$( target_preview ).removeClass( 'thinkup-width-450' );

				// Remove width classes for upgrade section
				$( target_control ).removeClass( 'thinkup-width-950' );
				$( target_preview ).removeClass( 'thinkup-width-950' );

			});
		}

	});


	// ----------------------------------------------------------------------------------
	//	2.1. HIDE / SHOW OPTION WHEN CHANGED BY USER - CUSTOMIZER
	// ----------------------------------------------------------------------------------
	jQuery(document).ready(function(){

		// Only needed on customizer page - theme options page handled using Redux core customization
		if( jQuery( 'body' ).hasClass( 'wp-customizer' ) ) {

			jQuery('input[type=radio]').change(function() {

				// General - Logo Settings (Option 1)
				if(jQuery('#thinkup_redux_variables-thinkup_general_logoswitch input[value=option1]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_general_logolink').addClass('thinkup-show').removeClass('thinkup-hide');
					jQuery('#thinkup_redux_variables-thinkup_general_logolinkretina').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_general_logoswitch input[value=option1]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_general_logolink').addClass('thinkup-hide').removeClass('thinkup-show');
					jQuery('#thinkup_redux_variables-thinkup_general_logolinkretina').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// General - Logo Settings (Option 2)
				if(jQuery('#thinkup_redux_variables-thinkup_general_logoswitch input[value=option2]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_general_sitetitle').addClass('thinkup-show').removeClass('thinkup-hide');
					jQuery('#thinkup_redux_variables-thinkup_general_sitedescription').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_general_logoswitch input[value=option2]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_general_sitetitle').addClass('thinkup-hide').removeClass('thinkup-show');
					jQuery('#thinkup_redux_variables-thinkup_general_sitedescription').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Homepage - Enable Slider
				if(jQuery('#thinkup_homepage_sliderswitch-buttonsetoption1').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_sliderpreset').addClass('thinkup-show').removeClass('thinkup-hide');
					jQuery('#thinkup_redux_variables-thinkup_homepage_sliderspeed').addClass('thinkup-show').removeClass('thinkup-hide');
					jQuery('#thinkup_redux_variables-thinkup_homepage_sliderstyle').addClass('thinkup-show').removeClass('thinkup-hide');
					jQuery('#thinkup_redux_variables-thinkup_homepage_sliderpresetwidth').addClass('thinkup-show').removeClass('thinkup-hide');
					jQuery('#thinkup_redux_variables-thinkup_homepage_sliderpresetheight').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_homepage_sliderswitch-buttonsetoption1').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_sliderpreset').addClass('thinkup-hide').removeClass('thinkup-show');
					jQuery('#thinkup_redux_variables-thinkup_homepage_sliderspeed').addClass('thinkup-hide').removeClass('thinkup-show');
					jQuery('#thinkup_redux_variables-thinkup_homepage_sliderstyle').addClass('thinkup-hide').removeClass('thinkup-show');
					jQuery('#thinkup_redux_variables-thinkup_homepage_sliderpresetwidth').addClass('thinkup-hide').removeClass('thinkup-show');
					jQuery('#thinkup_redux_variables-thinkup_homepage_sliderpresetheight').addClass('thinkup-hide').removeClass('thinkup-show');
				}
				if(jQuery('#thinkup_homepage_sliderswitch-buttonsetoption2').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_slidername').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_homepage_sliderswitch-buttonsetoption2').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_slidername').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Homepage - Call To Action Intro Link (Option 1)
				if(jQuery('#thinkup_redux_variables-thinkup_homepage_introactionlink input[value=option1]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_introactionpage').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_homepage_introactionlink input[value=option1]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_introactionpage').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Homepage - Call To Action Intro Link (Option 2)
				if(jQuery('#thinkup_redux_variables-thinkup_homepage_introactionlink input[value=option2]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_introactioncustom').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_homepage_introactionlink input[value=option2]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_introactioncustom').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Homepage - Button 1 Call To Action Intro Link (Option 1)
				if(jQuery('#thinkup_redux_variables-thinkup_homepage_introactionlink1 input[value=option1]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_introactionpage1').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_homepage_introactionlink1 input[value=option1]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_introactionpage1').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Homepage - Button 1 Call To Action Intro Link (Option 2)
				if(jQuery('#thinkup_redux_variables-thinkup_homepage_introactionlink1 input[value=option2]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_introactioncustom1').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_homepage_introactionlink1 input[value=option2]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_introactioncustom1').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Homepage - Button 2 Call To Action Intro Link (Option 1)
				if(jQuery('#thinkup_redux_variables-thinkup_homepage_introactionlink2 input[value=option1]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_introactionpage2').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_homepage_introactionlink2 input[value=option1]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_introactionpage2').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Homepage - Button 2 Call To Action Intro Link (Option 2)
				if(jQuery('#thinkup_redux_variables-thinkup_homepage_introactionlink2 input[value=option2]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_introactioncustom2').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_homepage_introactionlink2 input[value=option2]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_introactioncustom2').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Homepage - Call To Action Outro Link (Option 1)
				if(jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionlink input[value=option1]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionpage').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionlink input[value=option1]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionpage').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Homepage - Call To Action Outro Link (Option 2)
				if(jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionlink input[value=option2]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_outroactioncustom').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionlink input[value=option2]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_outroactioncustom').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Homepage - Button 1 Call To Action Outro Link (Option 1)
				if(jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionlink1 input[value=option1]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionpage1').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionlink1 input[value=option1]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionpage1').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Homepage - Button 1 Call To Action Outro Link (Option 2)
				if(jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionlink1 input[value=option2]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_outroactioncustom1').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionlink1 input[value=option2]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_outroactioncustom1').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Homepage - Button 2 Call To Action Outro Link (Option 1)
				if(jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionlink2 input[value=option1]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionpage2').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionlink2 input[value=option1]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionpage2').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Homepage - Button 2 Call To Action Outro Link (Option 2)
				if(jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionlink2 input[value=option2]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_outroactioncustom2').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_homepage_outroactionlink2 input[value=option2]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_homepage_outroactioncustom2').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Header - Choose Header Style (Option 1)
				if(jQuery('#thinkup_redux_variables-thinkup_header_styleswitch input[value=option1]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_header_locationswitch').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_header_styleswitch input[value=option1]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_header_locationswitch').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Footer - Call To Action Outro Link (Option 1)
				if(jQuery('#thinkup_redux_variables-thinkup_footer_outroactionlink input[value=option1]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_footer_outroactionpage').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_footer_outroactionlink input[value=option1]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_footer_outroactionpage').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Footer - Call To Action Outro Link (Option 2)
				if(jQuery('#thinkup_redux_variables-thinkup_footer_outroactionlink input[value=option2]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_footer_outroactioncustom').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_footer_outroactionlink input[value=option2]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_footer_outroactioncustom').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Footer - Button 1 Call To Action Outro Link (Option 1)
				if(jQuery('#thinkup_redux_variables-thinkup_footer_outroactionlink1 input[value=option1]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_footer_outroactionpage1').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_footer_outroactionlink1 input[value=option1]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_footer_outroactionpage1').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Footer - Button 1 Call To Action Outro Link (Option 2)
				if(jQuery('#thinkup_redux_variables-thinkup_footer_outroactionlink1 input[value=option2]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_footer_outroactioncustom1').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_footer_outroactionlink1 input[value=option2]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_footer_outroactioncustom1').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Footer - Button 2 Call To Action Outro Link (Option 1)
				if(jQuery('#thinkup_redux_variables-thinkup_footer_outroactionlink2 input[value=option1]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_footer_outroactionpage2').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_footer_outroactionlink2 input[value=option1]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_footer_outroactionpage2').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Footer - Button 2 Call To Action Outro Link (Option 2)
				if(jQuery('#thinkup_redux_variables-thinkup_footer_outroactionlink2 input[value=option2]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_footer_outroactioncustom2').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_footer_outroactionlink2 input[value=option2]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_footer_outroactioncustom2').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Notification Bar - Add Button Link (Option 1)
				if(jQuery('#thinkup_redux_variables-thinkup_notification_link input[value=option1]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_notification_linkpage').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_notification_link input[value=option1]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_notification_linkpage').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Notification Bar - Add Button Link (Option 2)
				if(jQuery('#thinkup_redux_variables-thinkup_notification_link input[value=option2]').is(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_notification_linkcustom').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_notification_link input[value=option2]').not(":checked")){
					jQuery('#thinkup_redux_variables-thinkup_notification_linkcustom').addClass('thinkup-hide').removeClass('thinkup-show');
				}
			});
		}
	});

	// ----------------------------------------------------------------------------------
	//	2.2. HIDE / SHOW OPTIONS ON SIDEBAR IMAGE CLICK - CUSTOMIZER
	// ----------------------------------------------------------------------------------
	jQuery(document).ready(function(){

		// Only needed on customizer page - theme options page handled using Redux core customization
		if( jQuery( 'body' ).hasClass( 'wp-customizer' ) ) {

			jQuery('input[type=radio]').change(function() {

				// Select sidebar for Page Layout
				if( jQuery('#thinkup_redux_variables-thinkup_general_layout input[value=option2]').is(":checked") || jQuery('#thinkup_redux_variables-thinkup_general_layout input[value=option3]').is(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_general_sidebars').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_general_layout input[value=option2]').not(":checked") || jQuery('#thinkup_redux_variables-thinkup_general_layout input[value=option3]').not(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_general_sidebars').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Select sidebar for Homepage Layout
				if( jQuery('#thinkup_redux_variables-thinkup_homepage_layout input[value=option2]').is(":checked") || jQuery('#thinkup_redux_variables-thinkup_homepage_layout input[value=option3]').is(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_homepage_sidebars').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_homepage_layout input[value=option2]').not(":checked") || jQuery('#thinkup_redux_variables-thinkup_homepage_layout input[value=option3]').not(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_homepage_sidebars').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Select sidebar for Blog Layout
				if( jQuery('#thinkup_redux_variables-thinkup_blog_layout input[value=option2]').is(":checked") || jQuery('#thinkup_redux_variables-thinkup_blog_layout input[value=option3]').is(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_blog_sidebars').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_blog_layout input[value=option2]').not(":checked") || jQuery('#thinkup_redux_variables-thinkup_blog_layout input[value=option3]').not(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_blog_sidebars').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Select Blog Style - DONE
				if( jQuery('#thinkup_redux_variables-thinkup_blog_style input[value=option1]').is(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_blog_style1layout').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_blog_style input[value=option1]').not(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_blog_style1layout').addClass('thinkup-hide').removeClass('thinkup-show');
				}
				if( jQuery('#thinkup_redux_variables-thinkup_blog_style input[value=option2]').is(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_blog_style2layout').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_blog_style input[value=option2]').not(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_blog_style2layout').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Select Blog Style - DONE
				if( jQuery('#thinkup_redux_variables-thinkup_blog_postswitch input[value=option1]').is(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_blog_postexcerpt').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_blog_postswitch input[value=option1]').not(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_blog_postexcerpt').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Select sidebar for Post Layout
				if( jQuery('#thinkup_redux_variables-thinkup_post_layout input[value=option2]').is(":checked") || jQuery('#thinkup_redux_variables-thinkup_post_layout input[value=option3]').is(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_post_sidebars').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_post_layout input[value=option2]').not(":checked") || jQuery('#thinkup_redux_variables-thinkup_post_layout input[value=option3]').not(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_post_sidebars').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Select sidebar for Portfolio Layout
				if( jQuery('#thinkup_redux_variables-thinkup_portfolio_layout input[value=option5]').is(":checked") || jQuery('#thinkup_redux_variables-thinkup_portfolio_layout input[value=option6]').is(":checked") || jQuery('#thinkup_redux_variables-thinkup_portfolio_layout input[value=option7]').is(":checked") || jQuery('#thinkup_redux_variables-thinkup_portfolio_layout input[value=option8]').is(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_portfolio_sidebars').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_portfolio_layout input[value=option5]').not(":checked") || jQuery('#thinkup_redux_variables-thinkup_portfolio_layout input[value=option6]').not(":checked") || jQuery('#thinkup_redux_variables-thinkup_portfolio_layout input[value=option7]').not(":checked") || jQuery('#thinkup_redux_variables-thinkup_portfolio_layout input[value=option8]').not(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_portfolio_sidebars').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Select sidebar for Project Layout
				if( jQuery('#thinkup_redux_variables-thinkup_project_layout input[value=option2]').is(":checked") || jQuery('#thinkup_redux_variables-thinkup_project_layout input[value=option3]').is(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_project_sidebars').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_project_layout input[value=option2]').not(":checked") || jQuery('#thinkup_redux_variables-thinkup_project_layout input[value=option3]').not(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_project_sidebars').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Select sidebar for WooCommerce Shop Layout
				if( jQuery('#thinkup_redux_variables-thinkup_woocommerce_layout input[value=option5]').is(":checked") || jQuery('#thinkup_redux_variables-thinkup_woocommerce_layout input[value=option6]').is(":checked") || jQuery('#thinkup_redux_variables-thinkup_woocommerce_layout input[value=option7]').is(":checked") || jQuery('#thinkup_redux_variables-thinkup_woocommerce_layout input[value=option8]').is(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_woocommerce_sidebars').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_woocommerce_layout input[value=option5]').not(":checked") || jQuery('#thinkup_redux_variables-thinkup_woocommerce_layout input[value=option6]').not(":checked") || jQuery('#thinkup_redux_variables-thinkup_woocommerce_layout input[value=option7]').not(":checked") || jQuery('#thinkup_redux_variables-thinkup_woocommerce_layout input[value=option8]').not(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_woocommerce_sidebars').addClass('thinkup-hide').removeClass('thinkup-show');
				}

				// Select sidebar for WooCommerce Product Layout  - DONE
				if( jQuery('#thinkup_redux_variables-thinkup_woocommerce_layoutproduct input[value=option2]').is(":checked") || jQuery('#thinkup_redux_variables-thinkup_woocommerce_layoutproduct input[value=option3]').is(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_woocommerce_sidebarsproduct').addClass('thinkup-show').removeClass('thinkup-hide');
				}
				else if(jQuery('#thinkup_redux_variables-thinkup_woocommerce_layoutproduct input[value=option2]').not(":checked") || jQuery('#thinkup_redux_variables-thinkup_woocommerce_layoutproduct input[value=option3]').not(":checked") ){
					jQuery('#thinkup_redux_variables-thinkup_woocommerce_sidebarsproduct').addClass('thinkup-hide').removeClass('thinkup-show');
				}
			});
		}
	});

})( jQuery );
