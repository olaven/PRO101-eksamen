<?php
/**
 * Output
 *
 * @package Arctic Black
 */

/**
 * Arctic custom logo, header and background
 */
function arctic_black_custom_logo_header_and_background(){

	/** Enable support for custom logo */
	add_theme_support( 'custom-logo', array(
		'width'       => 400,
		'height'      => 88,
		'flex-width'  => true,
		'flex-height' => false,
		'header-text' => array( 'site-title a', 'site-description' )
	) );

	/** Custom Header */
	add_theme_support( 'custom-header', apply_filters( 'arctic_black_custom_header_args', array(
		'width'       			=> 1600,
		'height'      			=> 1600,
		'default-image'          => '',
		'default-text-color'     => 'ffffff',
		'flex-width'             => true,
		'flex-height'            => true,
	) ) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'arctic_black_custom_background_args', array(
		'default-color' 		=> 'ffffff',
		'default-repeat'        => 'no-repeat',
		'default-attachment'    => 'scroll',
	) ) );

}
add_action( 'after_setup_theme', 'arctic_black_custom_logo_header_and_background' );

/**
 * Print inline style
 *
 * @return string
 */
function arctic_black_add_inline_style(){

	$setting = arctic_black_setting_default();

	$css_selector 		= arctic_black_css_color_selector();

	$primary_color 		= get_theme_mod( 'primary_color', $setting['primary_color'] );
	$secondary_color 	= get_theme_mod( 'secondary_color', $setting['secondary_color'] );

	$css= '';

	if ( display_header_text() !== true ) {
		$css .= '
			.site-title a,
			.site-description {
				clip: rect(1px, 1px, 1px, 1px);
				position: absolute;
			}
		';
	}

	if ( get_header_textcolor() !== 'blank' ) {
		$css .= '
			.site-header a,
			.site-description,
			.main-navigation a,
			.main-navigation a:hover,
			.main-navigation a:focus,
			.main-navigation li.current_page_item > a,
			.main-navigation li.current-menu-item > a,
			.main-navigation li.current_page_ancestor > a,
			.main-navigation li.current-menu-ancestor > a {
				color: #'. esc_attr( get_header_textcolor() ) .';
			}
			.sidebar-toggle span,
			.sidebar-toggle span:before,
			.sidebar-toggle span:after,
			.sidebar-toggle:hover span,
			.sidebar-toggle:focus span,
			.sidebar-toggle:hover span:before,
			.sidebar-toggle:hover span:after,
			.sidebar-toggle:focus span:before,
			.sidebar-toggle:focus span:after {
				background-color: #'. esc_attr( get_header_textcolor() ) .';
			}
			.sidebar-toggled .sidebar-toggle span {
				background: transparent;
			}
		';
	}

	if ( is_singular() && has_post_thumbnail( get_the_id() ) ) {
		$image_id 	= get_post_thumbnail_id();
		$image 		= wp_get_attachment_image_src( $image_id, 'arctic-large' );
		$css .= '
			.hero-image {
				background-image: url("'. esc_url( $image[0] ) .'");
			}
		';
	}

	$term_id 	= ( is_archive() ) ? get_queried_object()->term_id : '';
	if ( is_archive() && $term_id ) {
		$image_id 	= get_term_meta( $term_id, 'image', true );
		$image 		= wp_get_attachment_image_src( $image_id, 'arctic-large' );
		$css .= '
			.hero-image {
				background-image: url("'. esc_url( $image[0] ) .'");
			}
		';
	}

	$footer_image = get_theme_mod( 'footer_image', $setting['footer_image'] );
	if ( !empty( $footer_image ) ) {
		$css .= '
			.footer-image {
				background-image: url("'. esc_url( $footer_image ) .'");
			}
		';
	}

	if ( get_theme_mod( 'post_date', $setting['post_date'] ) == false ) {
		$css .= '.entry-meta .posted-on{ display: none }';
	}

	if ( get_theme_mod( 'post_author', $setting['post_author'] ) == false ) {
		$css .= '.entry-meta .byline{ display: none }';
	}

	if ( get_theme_mod( 'post_cat', $setting['post_cat'] ) == false ) {
		$css .= '.entry-footer .cat-links{ display: none }';
	}

	if ( get_theme_mod( 'post_tag', $setting['post_tag'] ) == false ) {
		$css .= '.entry-footer .tags-links{ display: none }';
	}


	if ( $primary_color ) {
		$css .= sprintf( '%s{ background-color: %s }', $css_selector['primary_color_background'], esc_attr( $primary_color ) );
		$css .= sprintf( '%s{ border-color: %s }', $css_selector['primary_color_border'], esc_attr( $primary_color ) );
		$css .= sprintf( '%s{ color: %s }', $css_selector['primary_color_text'], esc_attr( $primary_color ) );
	}

	if ( $secondary_color ) {
		$css .= sprintf( '%s{ background-color: %s }', $css_selector['secondary_color_background'], esc_attr( $secondary_color ) );
		$css .= sprintf( '%s{ color: %s }', $css_selector['secondary_color_text'], esc_attr( $secondary_color ) );
		$css .= sprintf( '::selection{background-color:%1$s}::-moz-selection{background-color:%1$s}', esc_attr( $secondary_color ) );
	}

    $css = str_replace( array( "\n", "\t", "\r" ), '', $css );

	if ( ! empty( $css ) ) {
		wp_add_inline_style( 'arctic-style', apply_filters( 'arctic_black_inline_style', trim( $css ) ) );
	}

}
add_action( 'wp_enqueue_scripts', 'arctic_black_add_inline_style' );

/**
 * [arctic_black_customizer_style_placeholder description]
 * @return [type] [description]
 */
function arctic_black_customizer_style_placeholder(){
	if ( is_customize_preview() ) {
		echo '<style id="primary-color"></style>';
		echo '<style id="secondary-color"></style>';
	}
}
add_action( 'wp_head', 'arctic_black_customizer_style_placeholder', 15 );

/**
 * [arctic_black_editor_style description]
 * @param  [type] $mceInit [description]
 * @return [type]          [description]
 */
function arctic_black_editor_style( $mceInit ) {

	$setting = arctic_black_setting_default();

	$primary_color 			= get_theme_mod( 'primary_color', $setting['primary_color'] );
	$secondary_color 		= get_theme_mod( 'secondary_color', $setting['secondary_color'] );

	$styles = '';
	$styles .= '.mce-content-body a{ color: ' . esc_attr( $primary_color ) . '; }';
	$styles .= '.mce-content-body a:hover, .mce-content-body a:focus{ color: ' . esc_attr( $secondary_color ) . '; }';
	$styles .= '.mce-content-body ::selection{ background-color: ' . esc_attr( $secondary_color ) . '; }';
	$styles .= '.mce-content-body ::-mozselection{ background-color: ' . esc_attr( $secondary_color ) . '; }';

	$styles = str_replace( array( "\n", "\t", "\r" ), '', $styles );

	if ( !isset( $mceInit['content_style'] ) ) {
		$mceInit['content_style'] = trim( $styles ) . ' ';
	} else {
		$mceInit['content_style'] .= ' ' . trim( $styles ) . ' ';
	}

	return $mceInit;

}
add_filter( 'tiny_mce_before_init', 'arctic_black_editor_style' );
