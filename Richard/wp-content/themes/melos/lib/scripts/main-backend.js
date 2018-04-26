/**
 * Wordpress Admin Area Enhancements.
 *
 * Theme options are hidden / shown so the user only see's what is required.
 */

/* ----------------------------------------------------------------------------------
	ADD MODAL BOX TO CONFIRM DEMO INSTALLATION
---------------------------------------------------------------------------------- */
jQuery(document).ready(function(){
	(function ( $ ) {
		if ( $.isFunction($.fn.confirm) ) {
			$( '.demo-installer .button-install' ).confirm({
				title:'Demo Install',
				text: '<p>Are you sure you want to install the demo content?</p><p>Installer should only be <strong>run once</strong> and should be on a <strong>fresh installation of WordPress</strong>.</p><p style="margin: 0;"><strong><u>IMPORTANT:</u></strong> Running the installer on a live site can override your existing content.</p>',
				confirmButton: 'Yes I am',
				cancelButton: 'No',
			});
		}
	}( jQuery ));
});


/* ----------------------------------------------------------------------------------
	ADD CLASSES TO MAIN THEME OPTIONS
---------------------------------------------------------------------------------- */
jQuery(document).ready(function(){
	jQuery( 'td fieldset' ).each(function() {
		var mainclass = jQuery(this).attr("id");
		jQuery('fieldset[id='+mainclass+']').closest("tr").attr('id', 'section-' + mainclass );
	});

	// Specifically to add id to homepage slider options.
	jQuery( '#redux-slides-accordion' ).closest("tr").attr('id', 'section-thinkup_homepage_sliderpreset' );
	jQuery( '#section-thinkup_homepage_sliderpresetwidth' ).prev('tr').attr( 'id', 'section-thinkup_homepage_sliderpresetheight' );
//	jQuery( '#section-thinkup_homepage_sliderpresetwidth' ).prev('tr').attr( 'id', 'section-thinkup_homepage_sliderstyle' );
	jQuery( '#section-thinkup_homepage_sliderpresetheight' ).prev('tr').attr( 'id', 'section-thinkup_homepage_sliderspeed' );
});


/* ----------------------------------------------------------------------------------
	ADD CLASSES TO META THEME OPTIONS - TICKET #29300
---------------------------------------------------------------------------------- */
jQuery(document).ready(function($){
	$( 'th label' ).each(function() {
		var label = $(this),
		metaclass = label.attr( 'for' );
		if ( metaclass !== '' && metaclass !== undefined ) {
			label.closest( 'tr' ).addClass( metaclass );
		}
	});
});


/* ----------------------------------------------------------------------------------
	HIDE / SHOW BLOG OPTIONS PANEL (PAGE POST TYPE)
---------------------------------------------------------------------------------- */

jQuery(document).ready(function(){

	// Hide / show blog options panel on page load
	if ( jQuery( '#page_template option:selected' ).attr( 'value' ) == 'template-blog.php' ) {
		jQuery( '#thinkup_bloginfo' ).slideDown();
	} else if ( jQuery( '#page_template option:selected' ).attr( 'value' ) != 'template-blog.php' ) {
		jQuery( '#thinkup_bloginfo' ).slideUp();
	}

	jQuery( '#page_template' ).change( function() {

		// Hide / show blog options panel when template option is changed
		if ( jQuery( '#page_template option:selected' ).attr( 'value' ) == 'template-blog.php' ) {
			jQuery( '#thinkup_bloginfo' ).slideDown();
		} else if ( jQuery( '#page_template option:selected' ).attr( 'value' ) != 'template-blog.php' ) {
			jQuery( '#thinkup_bloginfo' ).slideUp();
		}
	});

	// Meta Blog Options - Enable Featured Carousel
	if(jQuery('tr._thinkup_meta_blogstyle input[value=option2]').is(":checked")){
		jQuery('tr._thinkup_meta_blogstyle1layout').show();
	}
	else if(jQuery('tr._thinkup_meta_blogstyle input[value=option2]').not(":checked")){
		jQuery('tr._thinkup_meta_blogstyle1layout').hide();
	}
	if(jQuery('tr._thinkup_meta_blogstyle input[value=option3]').is(":checked")){
		jQuery('tr._thinkup_meta_blogstyle2layout').show();
	}
	else if(jQuery('tr._thinkup_meta_blogstyle input[value=option3]').not(":checked")){
		jQuery('tr._thinkup_meta_blogstyle2layout').hide();
	}

	// Meta Blog Options - Hide / Show Option on Check
	jQuery('tr._thinkup_meta_blogstyle input[type=radio]').change(function() {
		if(jQuery('tr._thinkup_meta_blogstyle input[value=option2]').is(":checked")){
			jQuery('tr._thinkup_meta_blogstyle1layout').show();
		}
		else if(jQuery('tr._thinkup_meta_blogstyle input[value=option2]').not(":checked")){
			jQuery('tr._thinkup_meta_blogstyle1layout').hide();
		}
		if(jQuery('tr._thinkup_meta_blogstyle input[value=option3]').is(":checked")){
			jQuery('tr._thinkup_meta_blogstyle2layout').show();
		}
		else if(jQuery('tr._thinkup_meta_blogstyle input[value=option3]').not(":checked")){
			jQuery('tr._thinkup_meta_blogstyle2layout').hide();
		}
	});
});


/* ----------------------------------------------------------------------------------
	HIDE / SHOW PORTFOLIO OPTIONS PANEL (PAGE POST TYPE)
---------------------------------------------------------------------------------- */

jQuery(document).ready(function(){

	// Hide / show portfolio options panel on page load
	if ( jQuery( '#page_template option:selected' ).attr( 'value' ) == 'template-portfolio.php' ) {
		jQuery( '#thinkup_portfolioinfo' ).slideDown();
	} else if ( jQuery( '#page_template option:selected' ).attr( 'value' ) != 'template-portfolio.php' ) {
		jQuery( '#thinkup_portfolioinfo' ).slideUp();
	}

	jQuery( '#page_template' ).change( function() {

		// Hide / show portfolio options panel when template option is changed
		if ( jQuery( '#page_template option:selected' ).attr( 'value' ) == 'template-portfolio.php' ) {
			jQuery( '#thinkup_portfolioinfo' ).slideDown();
		} else if ( jQuery( '#page_template option:selected' ).attr( 'value' ) != 'template-portfolio.php' ) {
			jQuery( '#thinkup_portfolioinfo' ).slideUp();
		}
	});

	// Meta Portfolio Options - Enable Slider
	if(jQuery('tr._thinkup_meta_portfoliosliderswitch input').is(":checked")){
		jQuery('tr._thinkup_meta_portfolioslidercategory').show();
		jQuery('tr._thinkup_meta_portfoliosliderheight').show();
	}
	else if(jQuery('tr._thinkup_meta_portfoliosliderswitch input').not(":checked")){
		jQuery('tr._thinkup_meta_portfolioslidercategory').hide();
		jQuery('tr._thinkup_meta_portfoliosliderheight').hide();
	}

	// Meta Portfolio Options - Enable Featured Carousel
	if(jQuery('tr._thinkup_meta_portfoliofeaturedswitch input').is(":checked")){
		jQuery('tr._thinkup_meta_portfoliofeaturedcategory').show();
		jQuery('tr._thinkup_meta_portfoliofeatureditems').show();
		jQuery('tr._thinkup_meta_portfoliofeaturedscroll').show();
	}
	else if(jQuery('tr._thinkup_meta_portfoliofeaturedswitch input').not(":checked")){
		jQuery('tr._thinkup_meta_portfoliofeaturedcategory').hide();
		jQuery('tr._thinkup_meta_portfoliofeatureditems').hide();
		jQuery('tr._thinkup_meta_portfoliofeaturedscroll').hide();
	}

	// Meta Portfolio Options - Hide / Show Option on Check
	jQuery('input[type=checkbox]').change(function() {

		// Slider
		if(jQuery('tr._thinkup_meta_portfoliosliderswitch input').is(":checked")){
			jQuery('tr._thinkup_meta_portfolioslidercategory').fadeIn();
			jQuery('tr._thinkup_meta_portfoliosliderheight').fadeIn();
		}
		else if(jQuery('tr._thinkup_meta_portfoliosliderswitch input').not(":checked")){
			jQuery('tr._thinkup_meta_portfolioslidercategory').fadeOut();
			jQuery('tr._thinkup_meta_portfoliosliderheight').fadeOut();
		}

		// Featured Carousel
		if(jQuery('tr._thinkup_meta_portfoliofeaturedswitch input').is(":checked")){
			jQuery('tr._thinkup_meta_portfoliofeaturedcategory').fadeIn();
			jQuery('tr._thinkup_meta_portfoliofeatureditems').fadeIn();
			jQuery('tr._thinkup_meta_portfoliofeaturedscroll').fadeIn();
		}
		else if(jQuery('tr._thinkup_meta_portfoliofeaturedswitch input').not(":checked")){
			jQuery('tr._thinkup_meta_portfoliofeaturedcategory').fadeOut();
			jQuery('tr._thinkup_meta_portfoliofeatureditems').fadeOut();
			jQuery('tr._thinkup_meta_portfoliofeaturedscroll').fadeOut();
		}

	});
});


/* ----------------------------------------------------------------------------------
	HIDE / SHOW TEAM OPTIONS PANEL (PAGE POST TYPE)
---------------------------------------------------------------------------------- */

jQuery(document).ready(function(){

	// Hide / show Team options panel on page load
	if ( jQuery( '#page_template option:selected' ).attr( 'value' ) == 'template-team.php' ) {
		jQuery( '#thinkup_teamsettings' ).slideDown();
	} else if ( jQuery( '#page_template option:selected' ).attr( 'value' ) != 'template-team.php' ) {
		jQuery( '#thinkup_teamsettings' ).slideUp();
	}

	jQuery( '#page_template' ).change( function() {

		// Hide / show Team options panel when template option is changed
		if ( jQuery( '#page_template option:selected' ).attr( 'value' ) == 'template-team.php' ) {
			jQuery( '#thinkup_teamsettings' ).slideDown();
		} else if ( jQuery( '#page_template option:selected' ).attr( 'value' ) != 'template-team.php' ) {
			jQuery( '#thinkup_teamsettings' ).slideUp();
		}
	});

	// Meta Team Options - Grid Layout
	if(jQuery('tr._thinkup_meta_teamstyleswitch input[value=option1]').is(":checked")){
		jQuery('tr._thinkup_meta_teamlayout').hide();
	} else if(jQuery('tr._thinkup_meta_teamstyleswitch input[value=option1]').not(":checked")){
		jQuery('tr._thinkup_meta_teamlayout').show();
	}
	
	// Meta Portfolio Options - Hide / Show Option on radio change
	jQuery('input[type=radio]').change(function() {

		if(jQuery('tr._thinkup_meta_teamstyleswitch input[value=option1]').is(":checked")){
			jQuery('tr._thinkup_meta_teamlayout').fadeOut('slow');
		} else if(jQuery('tr._thinkup_meta_teamstyleswitch input[value=option1]').not(":checked")){
			jQuery('tr._thinkup_meta_teamlayout').fadeIn('slow');
		}
	});
});


/* ----------------------------------------------------------------------------------
	HIDE / SHOW TESTIMONIAL OPTIONS PANEL (PAGE POST TYPE)
---------------------------------------------------------------------------------- */

jQuery(document).ready(function(){

	// Hide / show Testimonial options panel on page load
	if ( jQuery( '#page_template option:selected' ).attr( 'value' ) == 'template-testimonial.php' ) {
		jQuery( '#thinkup_testimonialsettings' ).slideDown();
	} else if ( jQuery( '#page_template option:selected' ).attr( 'value' ) != 'template-testimonial.php' ) {
		jQuery( '#thinkup_testimonialsettings' ).slideUp();
	}

	jQuery( '#page_template' ).change( function() {

		// Hide / show Testimonial options panel when template option is changed
		if ( jQuery( '#page_template option:selected' ).attr( 'value' ) == 'template-testimonial.php' ) {
			jQuery( '#thinkup_testimonialsettings' ).slideDown();
		} else if ( jQuery( '#page_template option:selected' ).attr( 'value' ) != 'template-testimonial.php' ) {
			jQuery( '#thinkup_testimonialsettings' ).slideUp();
		}
	});
});


/* ----------------------------------------------------------------------------------
	HIDE / SHOW POST TYPE SPECIFIC OPTIONS PANEL
---------------------------------------------------------------------------------- */

jQuery(document).ready(function(){

	// Blog Post - Enable Author Bio
	if( jQuery( 'body' ).hasClass( 'post-type-post' ) ) {
		jQuery( 'tr._thinkup_meta_authorbio' ).show();
	} else {
		jQuery( 'tr._thinkup_meta_authorbio' ).hide();
	}

});


/* ----------------------------------------------------------------------------------
	HIDE / SHOW OPTIONS ON PAGE LOAD
---------------------------------------------------------------------------------- */
jQuery(document).ready(function(){

	// General - Logo Settings (Option 1) - DONE 
//	if(jQuery('#section-thinkup_general_logoswitch input[value=option1]').is(":checked")){
//		jQuery('#section-thinkup_general_logolink').show();
//		jQuery('#section-thinkup_general_logolinkretina').show();
//	}
//	else if(jQuery('#section-thinkup_general_logoswitch input[value=option1]').not(":checked")){
//		jQuery('#section-thinkup_general_logolink').hide();
//		jQuery('#section-thinkup_general_logolinkretina').hide();
//	}

	// General - Logo Settings (Option 2) - DONE
//	if(jQuery('#section-thinkup_general_logoswitch input[value=option2]').is(":checked")){
//		jQuery('#section-thinkup_general_sitetitle').show();
//		jQuery('#section-thinkup_general_sitedescription').show();
//	}
//	else if(jQuery('#section-thinkup_general_logoswitch input[value=option2]').not(":checked")){
//		jQuery('#section-thinkup_general_sitetitle').hide();
//		jQuery('#section-thinkup_general_sitedescription').hide();
//	}

	// === Select sidebar for Page Layout - DONE
//	if( jQuery('#section-thinkup_general_layout input[value=option2]').is(":checked") || jQuery('#section-thinkup_general_layout input[value=option3]').is(":checked") ){
//		jQuery('#section-thinkup_general_sidebars').show();
//	}
//	else if(jQuery('#section-thinkup_general_layout input[value=option2]').not(":checked") || jQuery('#section-thinkup_general_layout input[value=option3]').not(":checked") ){
//		jQuery('#section-thinkup_general_sidebars').hide();
//	}

	// Select sidebar for Homepage Layout  - DONE
//	if( jQuery('#section-thinkup_homepage_layout input[value=option2]').is(":checked") || jQuery('#section-thinkup_homepage_layout input[value=option3]').is(":checked") ){
//		jQuery('#section-thinkup_homepage_sidebars').show();
//	}
//	else if(jQuery('#section-thinkup_homepage_layout input[value=option2]').not(":checked") || jQuery('#section-thinkup_homepage_layout input[value=option3]').not(":checked") ){
//		jQuery('#section-thinkup_homepage_sidebars').hide();
//	}

	// Header - Choose Header Style (Option 2) - DONE 
//	if(jQuery('#section-thinkup_header_styleswitch input[value=option1]').is(":checked")){
//		jQuery('#section-thinkup_header_locationswitch').show();
//	}
//	else if(jQuery('#section-thinkup_header_styleswitch input[value=option1]').not(":checked")){
//		jQuery('#section-thinkup_header_locationswitch').hide();
//	}

	// Select sidebar for Blog Layout - DONE
//	if( jQuery('#section-thinkup_blog_layout input[value=option2]').is(":checked") || jQuery('#section-thinkup_blog_layout input[value=option3]').is(":checked") ){
//		jQuery('#section-thinkup_blog_sidebars').show();
//	}
//	else if(jQuery('#section-thinkup_blog_layout input[value=option2]').not(":checked") || jQuery('#section-thinkup_blog_layout input[value=option3]').not(":checked") ){
//		jQuery('#section-thinkup_blog_sidebars').hide();
//	}

	// Select Blog Style - DONE
//	if( jQuery('#section-thinkup_blog_style input[value=option1]').is(":checked") ){
//		jQuery('#section-thinkup_blog_style1layout').show();
//	}
//	else if(jQuery('#section-thinkup_blog_style input[value=option1]').not(":checked") ){
//		jQuery('#section-thinkup_blog_style1layout').hide();
//	}
//	if( jQuery('#section-thinkup_blog_style input[value=option2]').is(":checked") ){
//		jQuery('#section-thinkup_blog_style2layout').show();
//	}
//	else if(jQuery('#section-thinkup_blog_style input[value=option2]').not(":checked") ){
//		jQuery('#section-thinkup_blog_style2layout').hide();
//	}

	// Select Blog Style - DONE
//	if( jQuery('#section-thinkup_blog_postswitch input[value=option1]').is(":checked") ){
//		jQuery('#section-thinkup_blog_postexcerpt').show();
//	}
//	else if(jQuery('#section-thinkup_blog_postswitch input[value=option1]').not(":checked") ){
//		jQuery('#section-thinkup_blog_postexcerpt').hide();
//	}

	// Select sidebar for Post Layout - DONE
//	if( jQuery('#section-thinkup_post_layout input[value=option2]').is(":checked") || jQuery('#section-thinkup_post_layout input[value=option3]').is(":checked") ){
//		jQuery('#section-thinkup_post_sidebars').show();
//	}
//	else if(jQuery('#section-thinkup_post_layout input[value=option2]').not(":checked") || jQuery('#section-thinkup_post_layout input[value=option3]').not(":checked") ){
//		jQuery('#section-thinkup_post_sidebars').hide();
//	}

	// Select sidebar for Portfolio Layout DONE
//	if( jQuery('#section-thinkup_portfolio_layout input[value=option5]').is(":checked") || jQuery('#section-thinkup_portfolio_layout input[value=option6]').is(":checked") || jQuery('#section-thinkup_portfolio_layout input[value=option7]').is(":checked") || jQuery('#section-thinkup_portfolio_layout input[value=option8]').is(":checked") ){
//		jQuery('#section-thinkup_portfolio_sidebars').show();
//	}
//	else if(jQuery('#section-thinkup_portfolio_layout input[value=option5]').not(":checked") || jQuery('#section-thinkup_portfolio_layout input[value=option6]').not(":checked") || jQuery('#section-thinkup_portfolio_layout input[value=option7]').not(":checked") || jQuery('#section-thinkup_portfolio_layout input[value=option8]').not(":checked") ){
//		jQuery('#section-thinkup_portfolio_sidebars').hide();
//	}

	// Select sidebar for Project Layout - DONE
//	if( jQuery('#section-thinkup_project_layout input[value=option2]').is(":checked") || jQuery('#section-thinkup_project_layout input[value=option3]').is(":checked") ){
//		jQuery('#section-thinkup_project_sidebars').show();
//	}
//	else if(jQuery('#section-thinkup_project_layout input[value=option2]').not(":checked") || jQuery('#section-thinkup_project_layout input[value=option3]').not(":checked") ){
//		jQuery('#section-thinkup_project_sidebars').hide();
//	}

	// Select sidebar for WooCommerce Shop Layout  - DONE
//	if( jQuery('#section-thinkup_woocommerce_layout input[value=option5]').is(":checked") || jQuery('#section-thinkup_woocommerce_layout input[value=option6]').is(":checked") || jQuery('#section-thinkup_woocommerce_layout input[value=option7]').is(":checked") || jQuery('#section-thinkup_woocommerce_layout input[value=option8]').is(":checked") ){
//		jQuery('#section-thinkup_woocommerce_sidebars').show();
//	}
//	else if(jQuery('#section-thinkup_woocommerce_layout input[value=option5]').not(":checked") || jQuery('#section-thinkup_woocommerce_layout input[value=option6]').not(":checked") || jQuery('#section-thinkup_woocommerce_layout input[value=option7]').not(":checked") || jQuery('#section-thinkup_woocommerce_layout input[value=option8]').not(":checked") ){
//		jQuery('#section-thinkup_woocommerce_sidebars').hide();
//	}

	// Select sidebar for WooCommerce Product Layout  - DONE
//	if( jQuery('#section-thinkup_woocommerce_layoutproduct input[value=option2]').is(":checked") || jQuery('#section-thinkup_woocommerce_layoutproduct input[value=option3]').is(":checked") ){
//		jQuery('#section-thinkup_woocommerce_sidebarsproduct').show();
//	}
//	else if(jQuery('#section-thinkup_woocommerce_layoutproduct input[value=option2]').not(":checked") || jQuery('#section-thinkup_woocommerce_layoutproduct input[value=option3]').not(":checked") ){
//		jQuery('#section-thinkup_woocommerce_sidebarsproduct').hide();
//	}

	// Homepage - Enable Homepage Blog - DONE
//	if(jQuery('#section-thinkup_homepage_blog input').is(":checked")){
//		jQuery('#section-thinkup_homepage_addtext').hide();
//		jQuery('#section-thinkup_homepage_addtextparagraph').hide();
//		jQuery('#section-thinkup_homepage_addpage').hide();
//	}
//	else if(jQuery('#section-thinkup_homepage_blog input').not(":checked")){
//		jQuery('#section-thinkup_homepage_addtext').show();
//		jQuery('#section-thinkup_homepage_addtextparagraph').show();
//		jQuery('#section-thinkup_homepage_addpage').show();
//	}

	// Homepage - Enable Slider
//	if(jQuery('#thinkup_homepage_sliderswitch-buttonsetoption1').is(":checked")){
//		jQuery('#section-thinkup_homepage_sliderpreset').show();
//		jQuery('#section-thinkup_homepage_sliderspeed').show();
//		jQuery('#section-thinkup_homepage_sliderstyle').show();
//		jQuery('#section-thinkup_homepage_sliderpresetwidth').show();
//		jQuery('#section-thinkup_homepage_sliderpresetheight').show();
//	}
//	else if(jQuery('#thinkup_homepage_sliderswitch-buttonsetoption1').not(":checked")){
//		jQuery('#section-thinkup_homepage_sliderpreset').hide();
//		jQuery('#section-thinkup_homepage_sliderspeed').hide();
//		jQuery('#section-thinkup_homepage_sliderstyle').hide();
//		jQuery('#section-thinkup_homepage_sliderpresetwidth').hide();
//		jQuery('#section-thinkup_homepage_sliderpresetheight').hide();
//	}
//	if(jQuery('#thinkup_homepage_sliderswitch-buttonsetoption2').is(":checked")){
//		jQuery('#section-thinkup_homepage_slidername').show();
//	}
//	else if(jQuery('#thinkup_homepage_sliderswitch-buttonsetoption2').not(":checked")){
//		jQuery('#section-thinkup_homepage_slidername').hide();
//	}	

	// Homepage - Button 1 Call To Action Intro Link (Option 1) - DONE
//	if(jQuery('#section-thinkup_homepage_introactionlink1 input[value=option1]').is(":checked")){
//		jQuery('#section-thinkup_homepage_introactionpage1').show();
//	}
//	else if(jQuery('#section-thinkup_homepage_introactionlink1 input[value=option1]').not(":checked")){
//		jQuery('#section-thinkup_homepage_introactionpage1').hide();
//	}

	// Homepage - Button 1 Call To Action Intro Link (Option 2) - DONE
//	if(jQuery('#section-thinkup_homepage_introactionlink1 input[value=option2]').is(":checked")){
//		jQuery('#section-thinkup_homepage_introactioncustom1').show();
//	}
//	else if(jQuery('#section-thinkup_homepage_introactionlink1 input[value=option2]').not(":checked")){
//		jQuery('#section-thinkup_homepage_introactioncustom1').hide();
//	}

	// Homepage - Button 2 Call To Action Intro Link (Option 1) - DONE
//	if(jQuery('#section-thinkup_homepage_introactionlink2 input[value=option1]').is(":checked")){
//		jQuery('#section-thinkup_homepage_introactionpage2').show();
//	}
//	else if(jQuery('#section-thinkup_homepage_introactionlink2 input[value=option1]').not(":checked")){
//		jQuery('#section-thinkup_homepage_introactionpage2').hide();
//	}

	// Homepage - Button 2 Call To Action Intro Link (Option 2) - DONE
//	if(jQuery('#section-thinkup_homepage_introactionlink2 input[value=option2]').is(":checked")){
//		jQuery('#section-thinkup_homepage_introactioncustom2').show();
//	}
//	else if(jQuery('#section-thinkup_homepage_introactionlink2 input[value=option2]').not(":checked")){
//		jQuery('#section-thinkup_homepage_introactioncustom2').hide();
//	}

	// Homepage - Button 1 Call To Action Outro Link (Option 1) - DONE
//	if(jQuery('#section-thinkup_homepage_outroactionlink1 input[value=option1]').is(":checked")){
//		jQuery('#section-thinkup_homepage_outroactionpage1').show();
//	}
//	else if(jQuery('#section-thinkup_homepage_outroactionlink1 input[value=option1]').not(":checked")){
//		jQuery('#section-thinkup_homepage_outroactionpage1').hide();
//	}

	// Homepage - Button 1 Call To Action Outro Link (Option 2) - DONE
//	if(jQuery('#section-thinkup_homepage_outroactionlink1 input[value=option2]').is(":checked")){
//		jQuery('#section-thinkup_homepage_outroactioncustom1').show();
//	}
//	else if(jQuery('#section-thinkup_homepage_outroactionlink1 input[value=option2]').not(":checked")){
//		jQuery('#section-thinkup_homepage_outroactioncustom1').hide();
//	}

	// Homepage - Button 2 Call To Action Outro Link (Option 1) - DONE
//	if(jQuery('#section-thinkup_homepage_outroactionlink2 input[value=option1]').is(":checked")){
//		jQuery('#section-thinkup_homepage_outroactionpage2').show();
//	}
//	else if(jQuery('#section-thinkup_homepage_outroactionlink2 input[value=option1]').not(":checked")){
//		jQuery('#section-thinkup_homepage_outroactionpage2').hide();
//	}

	// Homepage - Button 2 Call To Action Outro Link (Option 2) - DONE
//	if(jQuery('#section-thinkup_homepage_outroactionlink2 input[value=option2]').is(":checked")){
//		jQuery('#section-thinkup_homepage_outroactioncustom2').show();
//	}
//	else if(jQuery('#section-thinkup_homepage_outroactionlink2 input[value=option2]').not(":checked")){
//		jQuery('#section-thinkup_homepage_outroactioncustom2').hide();
//	}

	// Footer - Button 1 Call To Action Outro Link (Option 1) - DONE
//	if(jQuery('#section-thinkup_footer_outroactionlink1 input[value=option1]').is(":checked")){
//		jQuery('#section-thinkup_footer_outroactionpage1').show();
//	}
//	else if(jQuery('#section-thinkup_footer_outroactionlink1 input[value=option1]').not(":checked")){
//		jQuery('#section-thinkup_footer_outroactionpage1').hide();
//	}

	// Footer - Button 1 Call To Action Outro Link (Option 2) - DONE
//	if(jQuery('#section-thinkup_footer_outroactionlink1 input[value=option2]').is(":checked")){
//		jQuery('#section-thinkup_footer_outroactioncustom1').show();
//	}
//	else if(jQuery('#section-thinkup_footer_outroactionlink1 input[value=option2]').not(":checked")){
//		jQuery('#section-thinkup_footer_outroactioncustom1').hide();
//	}

	// Footer - Button 2 Call To Action Outro Link (Option 1) - DONE
//	if(jQuery('#section-thinkup_footer_outroactionlink2 input[value=option1]').is(":checked")){
//		jQuery('#section-thinkup_footer_outroactionpage2').show();
//	}
//	else if(jQuery('#section-thinkup_footer_outroactionlink2 input[value=option1]').not(":checked")){
//		jQuery('#section-thinkup_footer_outroactionpage2').hide();
//	}

	// Footer - Button 2 Call To Action Outro Link (Option 2) - DONE
//	if(jQuery('#section-thinkup_footer_outroactionlink2 input[value=option2]').is(":checked")){
//		jQuery('#section-thinkup_footer_outroactioncustom2').show();
//	}
//	else if(jQuery('#section-thinkup_footer_outroactionlink2 input[value=option2]').not(":checked")){
//		jQuery('#section-thinkup_footer_outroactioncustom2').hide();
//	}

	// Notification Bar - Add Button Link (Option 1) - DONE
//	if(jQuery('#section-thinkup_notification_link input[value=option1]').is(":checked")){
//		jQuery('#section-thinkup_notification_linkpage').show('slow');
//	}
//	else if(jQuery('#section-thinkup_notification_link input[value=option1]').not(":checked")){
//		jQuery('#section-thinkup_notification_linkpage').hide('slow');
//	}

	// Notification Bar - Add Button Link (Option 2) - DONE
//	if(jQuery('#section-thinkup_notification_link input[value=option2]').is(":checked")){
//		jQuery('#section-thinkup_notification_linkcustom').show('slow');
//	}
//	else if(jQuery('#section-thinkup_notification_link input[value=option2]').not(":checked")){
//		jQuery('#section-thinkup_notification_linkcustom').hide('slow');
//	}

	// Typography - Body Font (Font Family) - DONE
//	if(jQuery('#section-thinkup_font_bodyswitch input').is(":checked")){
//		jQuery('#section-thinkup_font_bodystandard').hide();
//		jQuery('#section-thinkup_font_bodygoogle').show();
//	}
//	else if(jQuery('#section-thinkup_font_bodyswitch input').not(":checked")){
//		jQuery('#section-thinkup_font_bodystandard').show();
//		jQuery('#section-thinkup_font_bodygoogle').hide();
//	}

	// Typography - Body Headings (Font Family) - DONE
//	if(jQuery('#section-thinkup_font_bodyheadingswitch input').is(":checked")){
//		jQuery('#section-thinkup_font_bodyheadingstandard').hide();
//		jQuery('#section-thinkup_font_bodyheadinggoogle').show();
//	}
//	else if(jQuery('#section-thinkup_font_bodyheadingswitch input').not(":checked")){
//		jQuery('#section-thinkup_font_bodyheadingstandard').show();
//		jQuery('#section-thinkup_font_bodyheadinggoogle').hide();
//	}

	// Typography - Footer Headings (Font Family) - DONE
//	if(jQuery('#section-thinkup_font_footerheadingswitch input').is(":checked")){
//		jQuery('#section-thinkup_font_footerheadingstandard').hide();
//		jQuery('#section-thinkup_font_footerheadinggoogle').show();
//	}
//	else if(jQuery('#section-thinkup_font_footerheadingswitch input').not(":checked")){
//		jQuery('#section-thinkup_font_footerheadingstandard').show();
//		jQuery('#section-thinkup_font_footerheadinggoogle').hide();
//	}

	// Typography - Pre Header Menu (Font Family) - DONE
//	if(jQuery('#section-thinkup_font_preheaderswitch input').is(":checked")){
//		jQuery('#section-thinkup_font_preheaderstandard').hide();
//		jQuery('#section-thinkup_font_preheadergoogle').show();
//	}
//	else if(jQuery('#section-thinkup_font_preheaderswitch input').not(":checked")){
//		jQuery('#section-thinkup_font_preheaderstandard').show();
//		jQuery('#section-thinkup_font_preheadergoogle').hide();
//	}

	// Typography - Main Header Menu (Font Family) - DONE
//	if(jQuery('#section-thinkup_font_mainheaderswitch input').is(":checked")){
//		jQuery('#section-thinkup_font_mainheaderstandard').hide();
//		jQuery('#section-thinkup_font_mainheadergoogle').show();
//	}
//	else if(jQuery('#section-thinkup_font_mainheaderswitch input').not(":checked")){
//		jQuery('#section-thinkup_font_mainheaderstandard').show();
//		jQuery('#section-thinkup_font_mainheadergoogle').hide();
//	}

	// Typography - Main Footer Menu (Font Family) - DONE
//	if(jQuery('#section-thinkup_font_mainfooterswitch input').is(":checked")){
//		jQuery('#section-thinkup_font_mainfooterstandard').hide();
//		jQuery('#section-thinkup_font_mainfootergoogle').show();
//	}
//	else if(jQuery('#section-thinkup_font_mainfooterswitch input').not(":checked")){
//		jQuery('#section-thinkup_font_mainfooterstandard').show();
//		jQuery('#section-thinkup_font_mainfootergoogle').hide();
//	}

	// Typography - Post Footer Menu (Font Family) - DONE
//	if(jQuery('#section-thinkup_font_postfooterswitch input').is(":checked")){
//		jQuery('#section-thinkup_font_postfooterstandard').hide();
//		jQuery('#section-thinkup_font_postfootergoogle').show();
//	}
//	else if(jQuery('#section-thinkup_font_postfooterswitch input').not(":checked")){
//		jQuery('#section-thinkup_font_postfooterstandard').show();
//		jQuery('#section-thinkup_font_postfootergoogle').hide();
//	}

	// Typography - Slider Title (Font Family) - DONE
//	if(jQuery('#section-thinkup_font_slidertitleswitch input').is(":checked")){
//		jQuery('#section-thinkup_font_slidertitlestandard').hide();
//		jQuery('#section-thinkup_font_slidertitlegoogle').show();
//	}
//	else if(jQuery('#section-thinkup_font_slidertitleswitch input').not(":checked")){
//		jQuery('#section-thinkup_font_slidertitlestandard').show();
//		jQuery('#section-thinkup_font_slidertitlegoogle').hide();
//	}

	// Typography - Slider Description (Font Family) - DONE
//	if(jQuery('#section-thinkup_font_slidertextswitch input').is(":checked")){
//		jQuery('#section-thinkup_font_slidertextstandard').hide();
//		jQuery('#section-thinkup_font_slidertextgoogle').show();
//	}
//	else if(jQuery('#section-thinkup_font_slidertextswitch input').not(":checked")){
//		jQuery('#section-thinkup_font_slidertextstandard').show();
//		jQuery('#section-thinkup_font_slidertextgoogle').hide();
//	}

	// Meta General Page Options - Header Position
	if( jQuery('tr._thinkup_meta_headerstyle input[value=option2]').is(":checked") ){
		jQuery('tr._thinkup_meta_headerlocation').show();
	}
	else if( jQuery('tr._thinkup_meta_headerstyle input[value=option2]').not(":checked") ){
		jQuery('tr._thinkup_meta_headerlocation').hide();
	}

	// Meta General Page Options - Enable Slider
	if(jQuery('tr._thinkup_meta_slider input').is(":checked")){
		jQuery('tr._thinkup_meta_slidername').show();
	}
	else if(jQuery('tr._thinkup_meta_slider input').not(":checked")){
		jQuery('tr._thinkup_meta_slidername').hide();
	}

	// Meta General Page Options - Page Layout (Options 3 & 4)
	if(jQuery('tr._thinkup_meta_layout input[value=option3]').is(":checked") || jQuery('tr._thinkup_meta_layout input[value=option4]').is(":checked")){
		jQuery('tr._thinkup_meta_sidebars').show();
	}
	else if(jQuery('tr._thinkup_meta_layout input[value=option3]').not(":checked") || jQuery('tr._thinkup_meta_layout input[value=option4]').not(":checked")){
		jQuery('tr._thinkup_meta_sidebars').hide();
	}
});


/* ----------------------------------------------------------------------------------
	HIDE / SHOW OPTIONS ON RADIO CLICK
---------------------------------------------------------------------------------- */
jQuery(document).ready(function(){
	jQuery('input[type=radio]').change(function() {

		// General - Logo Settings (Option 1) - DONE
//		if(jQuery('#section-thinkup_general_logoswitch input[value=option1]').is(":checked")){
//			jQuery('#section-thinkup_general_logolink').fadeIn('slow');
//			jQuery('#section-thinkup_general_logolinkretina').fadeIn('slow');
//		}
//		else if(jQuery('#section-thinkup_general_logoswitch input[value=option1]').not(":checked")){
//			jQuery('#section-thinkup_general_logolink').fadeOut('slow');
//			jQuery('#section-thinkup_general_logolinkretina').fadeOut('slow');
//		}

		/* General - Logo Settings (Option 2) - DONE */
//		if(jQuery('#section-thinkup_general_logoswitch input[value=option2]').is(":checked")){
//			jQuery('#section-thinkup_general_sitetitle').fadeIn('slow');
//			jQuery('#section-thinkup_general_sitedescription').fadeIn('slow');
//		}
//		else if(jQuery('#section-thinkup_general_logoswitch input[value=option2]').not(":checked")){
//			jQuery('#section-thinkup_general_sitetitle').fadeOut('slow');
//			jQuery('#section-thinkup_general_sitedescription').fadeOut('slow');
//		}

		// Homepage - Enable Slider
//		if(jQuery('#thinkup_homepage_sliderswitch-buttonsetoption1').is(":checked")){
//			jQuery('#section-thinkup_homepage_sliderpreset').fadeIn('slow');
//			jQuery('#section-thinkup_homepage_sliderspeed').fadeIn('slow');
//			jQuery('#section-thinkup_homepage_sliderstyle').fadeIn('slow');
//			jQuery('#section-thinkup_homepage_sliderpresetwidth').fadeIn('slow');
//			jQuery('#section-thinkup_homepage_sliderpresetheight').fadeIn('slow');
//		}
//		else if(jQuery('#thinkup_homepage_sliderswitch-buttonsetoption1').not(":checked")){
//			jQuery('#section-thinkup_homepage_sliderpreset').fadeOut('slow');
//			jQuery('#section-thinkup_homepage_sliderspeed').fadeOut('slow');
//			jQuery('#section-thinkup_homepage_sliderstyle').fadeOut('slow');
//			jQuery('#section-thinkup_homepage_sliderpresetwidth').fadeOut('slow');
//			jQuery('#section-thinkup_homepage_sliderpresetheight').fadeOut('slow');
//		}
//		if(jQuery('#thinkup_homepage_sliderswitch-buttonsetoption2').is(":checked")){
//			jQuery('#section-thinkup_homepage_slidername').fadeIn('slow');
//		}
//		else if(jQuery('#thinkup_homepage_sliderswitch-buttonsetoption2').not(":checked")){
//			jQuery('#section-thinkup_homepage_slidername').fadeOut('slow');
//		}

		/* Homepage - Button 1 Call To Action Intro Link (Option 1) - DONE */
//		if(jQuery('#section-thinkup_homepage_introactionlink1 input[value=option1]').is(":checked")){
//			jQuery('#section-thinkup_homepage_introactionpage1').fadeIn('slow');
//		}
//		else if(jQuery('#section-thinkup_homepage_introactionlink1 input[value=option1]').not(":checked")){
//			jQuery('#section-thinkup_homepage_introactionpage1').fadeOut('slow');
//		}

		/* Homepage - Button 1 Call To Action Intro Link (Option 2) - DONE */
//		if(jQuery('#section-thinkup_homepage_introactionlink1 input[value=option2]').is(":checked")){
//			jQuery('#section-thinkup_homepage_introactioncustom1').fadeIn('slow');
//		}
//		else if(jQuery('#section-thinkup_homepage_introactionlink1 input[value=option2]').not(":checked")){
//			jQuery('#section-thinkup_homepage_introactioncustom1').fadeOut('slow');
//		}

		/* Homepage - Button 2 Call To Action Intro Link (Option 1) - DONE */
//		if(jQuery('#section-thinkup_homepage_introactionlink2 input[value=option1]').is(":checked")){
//			jQuery('#section-thinkup_homepage_introactionpage2').fadeIn('slow');
//		}
//		else if(jQuery('#section-thinkup_homepage_introactionlink2 input[value=option1]').not(":checked")){
//			jQuery('#section-thinkup_homepage_introactionpage2').fadeOut('slow');
//		}

		/* Homepage - Button 2 Call To Action Intro Link (Option 2) - DONE */
//		if(jQuery('#section-thinkup_homepage_introactionlink2 input[value=option2]').is(":checked")){
//			jQuery('#section-thinkup_homepage_introactioncustom2').fadeIn('slow');
//		}
//		else if(jQuery('#section-thinkup_homepage_introactionlink2 input[value=option2]').not(":checked")){
//			jQuery('#section-thinkup_homepage_introactioncustom2').fadeOut('slow');
//		}

		/* Homepage - Button 1 Call To Action Outro Link (Option 1) - DONE */
//		if(jQuery('#section-thinkup_homepage_outroactionlink1 input[value=option1]').is(":checked")){
//			jQuery('#section-thinkup_homepage_outroactionpage1').fadeIn('slow');
//		}
//		else if(jQuery('#section-thinkup_homepage_outroactionlink1 input[value=option1]').not(":checked")){
//			jQuery('#section-thinkup_homepage_outroactionpage1').fadeOut('slow');
//		}

		/* Homepage - Button 1 Call To Action Outro Link (Option 2) - DONE */
//		if(jQuery('#section-thinkup_homepage_outroactionlink1 input[value=option2]').is(":checked")){
//			jQuery('#section-thinkup_homepage_outroactioncustom1').fadeIn('slow');
//		}
//		else if(jQuery('#section-thinkup_homepage_outroactionlink1 input[value=option2]').not(":checked")){
//			jQuery('#section-thinkup_homepage_outroactioncustom1').fadeOut('slow');
//		}

		/* Homepage - Button 2 Call To Action Outro Link (Option 1) - DONE */
//		if(jQuery('#section-thinkup_homepage_outroactionlink2 input[value=option1]').is(":checked")){
//			jQuery('#section-thinkup_homepage_outroactionpage2').fadeIn('slow');
//		}
//		else if(jQuery('#section-thinkup_homepage_outroactionlink2 input[value=option1]').not(":checked")){
//			jQuery('#section-thinkup_homepage_outroactionpage2').fadeOut('slow');
//		}

		/* Homepage - Button 2 Call To Action Outro Link (Option 2) - DONE */
//		if(jQuery('#section-thinkup_homepage_outroactionlink2 input[value=option2]').is(":checked")){
//			jQuery('#section-thinkup_homepage_outroactioncustom2').fadeIn('slow');
//		}
//		else if(jQuery('#section-thinkup_homepage_outroactionlink2 input[value=option2]').not(":checked")){
//			jQuery('#section-thinkup_homepage_outroactioncustom2').fadeOut('slow');
//		}

		// Header - Choose Header Style (Option 1) - DONE 
//		if(jQuery('#section-thinkup_header_styleswitch input[value=option1]').is(":checked")){
//			jQuery('#section-thinkup_header_locationswitch').fadeIn('slow');
//		}
//		else if(jQuery('#section-thinkup_header_styleswitch input[value=option1]').not(":checked")){
//			jQuery('#section-thinkup_header_locationswitch').fadeOut('slow');
//		}

		/* Footer - Button 1 Call To Action Outro Link (Option 1) - DONE */
//		if(jQuery('#section-thinkup_footer_outroactionlink1 input[value=option1]').is(":checked")){
//			jQuery('#section-thinkup_footer_outroactionpage1').fadeIn('slow');
//		}
//		else if(jQuery('#section-thinkup_footer_outroactionlink1 input[value=option1]').not(":checked")){
//			jQuery('#section-thinkup_footer_outroactionpage1').fadeOut('slow');
//		}

		/* Footer - Button 1 Call To Action Outro Link (Option 2) - DONE */
//		if(jQuery('#section-thinkup_footer_outroactionlink1 input[value=option2]').is(":checked")){
//			jQuery('#section-thinkup_footer_outroactioncustom1').fadeIn('slow');
//		}
//		else if(jQuery('#section-thinkup_footer_outroactionlink1 input[value=option2]').not(":checked")){
//			jQuery('#section-thinkup_footer_outroactioncustom1').fadeOut('slow');
//		}

		/* Footer - Button 2 Call To Action Outro Link (Option 1) - DONE */
//		if(jQuery('#section-thinkup_footer_outroactionlink2 input[value=option1]').is(":checked")){
//			jQuery('#section-thinkup_footer_outroactionpage2').fadeIn('slow');
//		}
//		else if(jQuery('#section-thinkup_footer_outroactionlink2 input[value=option1]').not(":checked")){
//			jQuery('#section-thinkup_footer_outroactionpage2').fadeOut('slow');
//		}

		/* Footer - Button 2 Call To Action Outro Link (Option 2) - DONE */
//		if(jQuery('#section-thinkup_footer_outroactionlink2 input[value=option2]').is(":checked")){
//			jQuery('#section-thinkup_footer_outroactioncustom2').fadeIn('slow');
//		}
//		else if(jQuery('#section-thinkup_footer_outroactionlink2 input[value=option2]').not(":checked")){
//			jQuery('#section-thinkup_footer_outroactioncustom2').fadeOut('slow');
//		}

		/* Notification Bar - Add Button Link (Option 1) - DONE */
//		if(jQuery('#section-thinkup_notification_link input[value=option1]').is(":checked")){
//			jQuery('#section-thinkup_notification_linkpage').fadeIn('slow');
//		}
//		else if(jQuery('#section-thinkup_notification_link input[value=option1]').not(":checked")){
//			jQuery('#section-thinkup_notification_linkpage').fadeOut('slow');
//		}

		/* Notification Bar - Add Button Link (Option 2) - DONE */
//		if(jQuery('#section-thinkup_notification_link input[value=option2]').is(":checked")){
//			jQuery('#section-thinkup_notification_linkcustom').fadeIn('slow');
//		}
//		else if(jQuery('#section-thinkup_notification_link input[value=option2]').not(":checked")){
//			jQuery('#section-thinkup_notification_linkcustom').fadeOut('slow');
//		}

		// Meta General Page Options - Header Position
		if( jQuery('tr._thinkup_meta_headerstyle input[value=option2]').is(":checked") ){
			jQuery('tr._thinkup_meta_headerlocation').fadeIn();
		}
		else if( jQuery('tr._thinkup_meta_headerstyle input[value=option2]').not(":checked") ){
			jQuery('tr._thinkup_meta_headerlocation').fadeOut();
		}

		/* Meta General Page Options - Page Layout (Options 3 & 4) */
		if(jQuery('tr._thinkup_meta_layout input[value=option3]').is(":checked") || jQuery('tr._thinkup_meta_layout input[value=option4]').is(":checked")){
			jQuery('tr._thinkup_meta_sidebars').fadeIn();
		}
		else if(jQuery('tr._thinkup_meta_layout input[value=option3]').not(":checked") || jQuery('tr._thinkup_meta_layout input[value=option4]').not(":checked")){
			jQuery('tr._thinkup_meta_sidebars').fadeOut();
		}
	});
});


/* ----------------------------------------------------------------------------------
	HIDE / SHOW OPTIONS ON CHECKBOX CLICK
---------------------------------------------------------------------------------- */
jQuery(document).ready(function(){
	jQuery('input[type=checkbox]').change(function() {

		/* Homepage - Enable Homepage Blog - DONE */
//		if(jQuery('#section-thinkup_homepage_blog input').is(":checked")){
//			jQuery('#section-thinkup_homepage_addtext').fadeOut();
//			jQuery('#section-thinkup_homepage_addtextparagraph').fadeOut();
//			jQuery('#section-thinkup_homepage_addpage').fadeOut();
//		}
//		else if(jQuery('#section-thinkup_homepage_blog input').not(":checked")){
//			jQuery('#section-thinkup_homepage_addtext').fadeIn();
//			jQuery('#section-thinkup_homepage_addtextparagraph').fadeIn();
//			jQuery('#section-thinkup_homepage_addpage').fadeIn();
//		}
	
		/* Typography - Body Font (Font Family) - DONE */
//		if(jQuery('#section-thinkup_font_bodyswitch input').is(":checked")){
//			jQuery('#section-thinkup_font_bodystandard').fadeOut();
//			jQuery('#section-thinkup_font_bodygoogle').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_font_bodyswitch input').not(":checked")){
//			jQuery('#section-thinkup_font_bodystandard').fadeIn();
//			jQuery('#section-thinkup_font_bodygoogle').fadeOut();
//		}

		/* Typography - Body Headings (Font Family) - DONE */
//		if(jQuery('#section-thinkup_font_bodyheadingswitch input').is(":checked")){
//			jQuery('#section-thinkup_font_bodyheadingstandard').fadeOut();
//			jQuery('#section-thinkup_font_bodyheadinggoogle').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_font_bodyheadingswitch input').not(":checked")){
//			jQuery('#section-thinkup_font_bodyheadingstandard').fadeIn();
//			jQuery('#section-thinkup_font_bodyheadinggoogle').fadeOut();
//		}

		/* Typography - Footer Headings (Font Family) - DONE */
//		if(jQuery('#section-thinkup_font_footerheadingswitch input').is(":checked")){
//			jQuery('#section-thinkup_font_footerheadingstandard').fadeOut();
//			jQuery('#section-thinkup_font_footerheadinggoogle').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_font_footerheadingswitch input').not(":checked")){
//			jQuery('#section-thinkup_font_footerheadingstandard').fadeIn();
//			jQuery('#section-thinkup_font_footerheadinggoogle').fadeOut();
//		}

		/* Typography - Pre Header Menu (Font Family) - DONE */
//		if(jQuery('#section-thinkup_font_preheaderswitch input').is(":checked")){
//			jQuery('#section-thinkup_font_preheaderstandard').fadeOut();
//			jQuery('#section-thinkup_font_preheadergoogle').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_font_preheaderswitch input').not(":checked")){
//			jQuery('#section-thinkup_font_preheaderstandard').fadeIn();
//			jQuery('#section-thinkup_font_preheadergoogle').fadeOut();
//		}

		/* Typography - Main Header Menu (Font Family) - DONE */
//		if(jQuery('#section-thinkup_font_mainheaderswitch input').is(":checked")){
//			jQuery('#section-thinkup_font_mainheaderstandard').fadeOut();
//			jQuery('#section-thinkup_font_mainheadergoogle').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_font_mainheaderswitch input').not(":checked")){
//			jQuery('#section-thinkup_font_mainheaderstandard').fadeIn();
//			jQuery('#section-thinkup_font_mainheadergoogle').fadeOut();
//		}

		/* Typography - Main Footer Menu (Font Family) - DONE */
//		if(jQuery('#section-thinkup_font_mainfooterswitch input').is(":checked")){
//			jQuery('#section-thinkup_font_mainfooterstandard').fadeOut();
//			jQuery('#section-thinkup_font_mainfootergoogle').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_font_mainfooterswitch input').not(":checked")){
//			jQuery('#section-thinkup_font_mainfooterstandard').fadeIn();
//			jQuery('#section-thinkup_font_mainfootergoogle').fadeOut();
//		}

		/* Typography - Post Footer Menu (Font Family) - DONE */
//		if(jQuery('#section-thinkup_font_postfooterswitch input').is(":checked")){
//			jQuery('#section-thinkup_font_postfooterstandard').fadeOut();
//			jQuery('#section-thinkup_font_postfootergoogle').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_font_postfooterswitch input').not(":checked")){
//			jQuery('#section-thinkup_font_postfooterstandard').fadeIn();
//			jQuery('#section-thinkup_font_postfootergoogle').fadeOut();
//		}

		/* Typography - Slider Title (Font Family) - DONE */
//		if(jQuery('#section-thinkup_font_slidertitleswitch input').is(":checked")){
//			jQuery('#section-thinkup_font_slidertitlestandard').fadeOut();
//			jQuery('#section-thinkup_font_slidertitlegoogle').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_font_slidertitleswitch input').not(":checked")){
//			jQuery('#section-thinkup_font_slidertitlestandard').fadeIn();
//			jQuery('#section-thinkup_font_slidertitlegoogle').fadeOut();
//		}

		/* Typography - Slider Text (Font Family) - DONE */
//		if(jQuery('#section-thinkup_font_slidertextswitch input').is(":checked")){
//			jQuery('#section-thinkup_font_slidertextstandard').fadeOut();
//			jQuery('#section-thinkup_font_slidertextgoogle').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_font_slidertextswitch input').not(":checked")){
//			jQuery('#section-thinkup_font_slidertextstandard').fadeIn();
//			jQuery('#section-thinkup_font_slidertextgoogle').fadeOut();
//		}

		/* Meta General Page Options - Enable Slider */
		if(jQuery('tr._thinkup_meta_slider input').is(":checked")){
			jQuery('tr._thinkup_meta_slidername').show();
		}
		else if(jQuery('tr._thinkup_meta_slider input').not(":checked")){
			jQuery('tr._thinkup_meta_slidername').hide();
		}
	});
});


/* ----------------------------------------------------------------------------------
	HIDE / SHOW OPTIONS ON SIDEBAR IMAGE CLICK - MAIN OPTIONS PANEL
---------------------------------------------------------------------------------- */
jQuery(document).ready(function(){
	jQuery('input[type=radio]').change(function() {

		/* Select sidebar for Page Layout - DONE */
//		if( jQuery('#section-thinkup_general_layout input[value=option2]').is(":checked") || jQuery('#section-thinkup_general_layout input[value=option3]').is(":checked") ){
//			jQuery('#section-thinkup_general_sidebars').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_general_layout input[value=option2]').not(":checked") || jQuery('#section-thinkup_general_layout input[value=option3]').not(":checked") ){
//			jQuery('#section-thinkup_general_sidebars').fadeOut();
//		}

		/* Select sidebar for Homepage Layout - DONE */
//		if( jQuery('#section-thinkup_homepage_layout input[value=option2]').is(":checked") || jQuery('#section-thinkup_homepage_layout input[value=option3]').is(":checked") ){
//			jQuery('#section-thinkup_homepage_sidebars').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_homepage_layout input[value=option2]').not(":checked") || jQuery('#section-thinkup_homepage_layout input[value=option3]').not(":checked") ){
//			jQuery('#section-thinkup_homepage_sidebars').fadeOut();
//		}

		/* Select sidebar for Blog Layout - DONE */
//		if( jQuery('#section-thinkup_blog_layout input[value=option2]').is(":checked") || jQuery('#section-thinkup_blog_layout input[value=option3]').is(":checked") ){
//			jQuery('#section-thinkup_blog_sidebars').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_blog_layout input[value=option2]').not(":checked") || jQuery('#section-thinkup_blog_layout input[value=option3]').not(":checked") ){
//			jQuery('#section-thinkup_blog_sidebars').fadeOut();
//		}

		// Select Blog Style - DONE
//		if( jQuery('#section-thinkup_blog_style input[value=option1]').is(":checked") ){
//			jQuery('#section-thinkup_blog_style1layout').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_blog_style input[value=option1]').not(":checked") ){
//			jQuery('#section-thinkup_blog_style1layout').fadeOut();
//		}
//		if( jQuery('#section-thinkup_blog_style input[value=option2]').is(":checked") ){
//			jQuery('#section-thinkup_blog_style2layout').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_blog_style input[value=option2]').not(":checked") ){
//			jQuery('#section-thinkup_blog_style2layout').fadeOut();
//		}

		// Select Blog Style - DONE
//		if( jQuery('#section-thinkup_blog_postswitch input[value=option1]').is(":checked") ){
//			jQuery('#section-thinkup_blog_postexcerpt').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_blog_postswitch input[value=option1]').not(":checked") ){
//			jQuery('#section-thinkup_blog_postexcerpt').fadeOut();
//		}

		/* Select sidebar for Post Layout - DONE */
//		if( jQuery('#section-thinkup_post_layout input[value=option2]').is(":checked") || jQuery('#section-thinkup_post_layout input[value=option3]').is(":checked") ){
//			jQuery('#section-thinkup_post_sidebars').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_post_layout input[value=option2]').not(":checked") || jQuery('#section-thinkup_post_layout input[value=option3]').not(":checked") ){
//			jQuery('#section-thinkup_post_sidebars').fadeOut();
//		}

		/* Select sidebar for Portfolio Layout - DONE */
//		if( jQuery('#section-thinkup_portfolio_layout input[value=option5]').is(":checked") || jQuery('#section-thinkup_portfolio_layout input[value=option6]').is(":checked") || jQuery('#section-thinkup_portfolio_layout input[value=option7]').is(":checked") || jQuery('#section-thinkup_portfolio_layout input[value=option8]').is(":checked") ){
//			jQuery('#section-thinkup_portfolio_sidebars').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_portfolio_layout input[value=option5]').not(":checked") || jQuery('#section-thinkup_portfolio_layout input[value=option6]').not(":checked") || jQuery('#section-thinkup_portfolio_layout input[value=option7]').not(":checked") || jQuery('#section-thinkup_portfolio_layout input[value=option8]').not(":checked") ){
//			jQuery('#section-thinkup_portfolio_sidebars').fadeOut();
//		}

		/* Select sidebar for Project Layout - DONE */
//		if( jQuery('#section-thinkup_project_layout input[value=option2]').is(":checked") || jQuery('#section-thinkup_project_layout input[value=option3]').is(":checked") ){
//			jQuery('#section-thinkup_project_sidebars').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_project_layout input[value=option2]').not(":checked") || jQuery('#section-thinkup_project_layout input[value=option3]').not(":checked") ){
//			jQuery('#section-thinkup_project_sidebars').fadeOut();
//		}

		/* Select sidebar for WooCommerce Shop Layout - DONE */
//		if( jQuery('#section-thinkup_woocommerce_layout input[value=option5]').is(":checked") || jQuery('#section-thinkup_woocommerce_layout input[value=option6]').is(":checked") || jQuery('#section-thinkup_woocommerce_layout input[value=option7]').is(":checked") || jQuery('#section-thinkup_woocommerce_layout input[value=option8]').is(":checked") ){
//			jQuery('#section-thinkup_woocommerce_sidebars').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_woocommerce_layout input[value=option5]').not(":checked") || jQuery('#section-thinkup_woocommerce_layout input[value=option6]').not(":checked") || jQuery('#section-thinkup_woocommerce_layout input[value=option7]').not(":checked") || jQuery('#section-thinkup_woocommerce_layout input[value=option8]').not(":checked") ){
//			jQuery('#section-thinkup_woocommerce_sidebars').fadeOut();
//		}

		// Select sidebar for WooCommerce Product Layout  - DONE
//		if( jQuery('#section-thinkup_woocommerce_layoutproduct input[value=option2]').is(":checked") || jQuery('#section-thinkup_woocommerce_layoutproduct input[value=option3]').is(":checked") ){
//			jQuery('#section-thinkup_woocommerce_sidebarsproduct').fadeIn();
//		}
//		else if(jQuery('#section-thinkup_woocommerce_layoutproduct input[value=option2]').not(":checked") || jQuery('#section-thinkup_woocommerce_layoutproduct input[value=option3]').not(":checked") ){
//			jQuery('#section-thinkup_woocommerce_sidebarsproduct').fadeOut();
//		}
	});
});