(function( $ ) {

	$(document).ready(function (){

		// Only needed on customizer page - theme options page handled using Redux core customization
		if( jQuery( 'body' ).hasClass( 'wp-customizer' ) ) {

			// ----------------------------------------------------------------------------------------------------------
			// 1. UPGRADE NOW BUTTON
			// ----------------------------------------------------------------------------------------------------------

			$( '#customize-header-actions' ).after( '<div id="customize-thinkup-upgrade" class=""><p><a href="//www.thinkupthemes.com/themes/melos/" target="_blank" class="promotion-button" style="">Upgrade Now</a></p></div>' );


			// ----------------------------------------------------------------------------------------------------------
			// 2. UPGRADE NOW TAB
			// ----------------------------------------------------------------------------------------------------------

			// Add active class to customizer
			$('body.wp-customizer #accordion-section-thinkup_section_upgrade > h3').click(function(e){

				var target_control = '#customize-controls';

				$( target_control ).addClass( 'thinkup-width-950' );
			});

			// Remove width classes WordPress v4.3+
			$( 'body.wp-customizer [id*="panel-thinkup_theme_options"] .accordion-section > button, body.wp-customizer [id*="section-thinkup_section_upgrade"] .customize-section-title > button' ).click(function(e){ 

				var target_control = '#customize-controls';
				
				$( target_control ).removeClass( 'thinkup-width-950' );
			});

			// Remove width classes WordPress pre v4.3
			$( 'body.wp-customizer #customize-header-actions .primary-actions > .control-panel-back' ).click(function(e){ 

				var target_control = '#customize-controls';
				
				$( target_control ).removeClass( 'thinkup-width-950' );
			});

		}

	});

})( jQuery );
