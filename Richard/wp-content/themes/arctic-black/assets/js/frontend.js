( function( $ ) {

	var arcticBlack = arcticBlack || {};

	arcticBlack.init = function() {

		arcticBlack.$body 	= $( document.body );
		arcticBlack.$window = $( window );
		arcticBlack.$html 	= $( 'html' );

		this.inlineSVG();
		this.fitVids();
		this.smoothScroll();
		this.thumbFocus();
		this.featuredSlider();
		this.footerSlider();

	};

	arcticBlack.supportsInlineSVG = function() {

		var div = document.createElement( 'div' );
		div.innerHTML = '<svg/>';
		return 'http://www.w3.org/2000/svg' === ( 'undefined' !== typeof SVGRect && div.firstChild && div.firstChild.namespaceURI );

	};

	arcticBlack.inlineSVG = function() {

		if ( true === arcticBlack.supportsInlineSVG() ) {
			document.documentElement.className = document.documentElement.className.replace( /(\s*)no-svg(\s*)/, '$1svg$2' );
		}

	};

	arcticBlack.fitVids = function() {

		$( '#page' ).fitVids({
			customSelector: 'iframe[src^="https://videopress.com"]'
		});

	};

	arcticBlack.smoothScroll = function() {

		var $smoothScroll 		= $( 'a[href*="#site-navigation"], a[href*="#content"], a[href*="#tertiary"]' );

		$smoothScroll.click(function(event) {
	        // On-page links
	        if (
	            location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') &&
	            location.hostname === this.hostname
	        ) {
	            // Figure out element to scroll to
	            var target = $(this.hash);
	            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
	            // Does a scroll target exist?
	            if (target.length) {
	                // Only prevent default if animation is actually gonna happen
	                event.preventDefault();
	                $('html, body').animate({
	                    scrollTop: target.offset().top
	                }, 500, function() {
	                    // Callback after animation
	                    // Must change focus!
	                    var $target = $(target);
	                    $target.focus();
	                    if ($target.is(':focus')) { // Checking if the target was focused
	                        return false;
	                    } else {
	                        $target.attr( 'tabindex', '-1' ); // Adding tabindex for elements not focusable
	                        $target.focus(); // Set focus again
	                    }
	                });
	            }
	        }
		});

	};

	arcticBlack.thumbFocus = function() {

		$( '.entry' ).find( 'a' ).on( 'hover focus blur', function( e ) {
			e.preventDefault();
			$( this ).parent().prev('.post-thumbnail').toggleClass( 'focus' );
		} );

	};

	arcticBlack.featuredSlider = function() {

		var prev__btn = '<button type="button" data-role="none" class="arctic-slick-prev" aria-label="Previous" tabindex="0" role="button"></button>',
			next__btn = '<button type="button" data-role="none" class="arctic-slick-next" aria-label="Next" tabindex="0" role="button"></button>';

		$('.featured-content').not('.slick-initialized').slick({
			infinite: true,
			adaptiveHeight: true,
			slidesToScroll: 1,
			fade: true,
			slidesToShow: 1,
			autoplay: true,
			autoplaySpeed: 5000,
			arrows: true,
            dots: true,
            pauseOnHover: false,
            dotsClass: 'arctic-slick-dots',
            prevArrow: prev__btn,
            nextArrow: next__btn,
			responsive: [
				{
					breakpoint: 788,
					settings: {
						fade: true,
						slidesToShow: 1
					}
				}
			]
		});

	};

	arcticBlack.footerSlider = function() {

		$( '#quaternary .instagram-pics' ).not('.slick-initialized').slick({
			infinite: true,
			dots: false,
			adaptiveHeight: false,
			slidesToShow: 8,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 5000,
			arrows: false,
			responsive: [
				{
					breakpoint: 960,
					settings: {
						slidesToShow: 6
					}
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: 4
					}
				},
				{
					breakpoint: 480,
					settings: {
						slidesToShow: 2
					}
				}
			]
		});

	};

	/** Initialize arcticBlack.init() */
	$( function() {
		arcticBlack.init();
	});

	$( document.body ).on( 'post-load', function () {
		arcticBlack.thumbFocus();
	});

} )( jQuery );

( function() {
	var container, button, body;

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = container.getElementsByTagName( 'button' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	body = document.getElementsByTagName( 'body' )[0];


	button.onclick = function() {
		if ( -1 !== body.className.indexOf( 'sidebar-toggled' ) ) {
			body.className = body.className.replace( ' sidebar-toggled', ' sidebar-closed' );
		} else {
			body.className = body.className.replace( ' sidebar-closed', '' );
			body.className += ' sidebar-toggled';
		}
	};

} )();
/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
(function() {
	var isIe = /(trident|msie)/i.test( navigator.userAgent );

	if ( isIe && document.getElementById && window.addEventListener ) {
		window.addEventListener( 'hashchange', function() {
			var id = location.hash.substring( 1 ),
				element;

			if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
				return;
			}

			element = document.getElementById( id );

			if ( element ) {
				if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
					element.tabIndex = -1;
				}

				element.focus();
			}
		}, false );
	}
})();