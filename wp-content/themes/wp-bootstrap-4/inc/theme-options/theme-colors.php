<?php

if( class_exists( 'Kirki' ) ) {
    function wp_bootstrap_4_colors_section( $wp_customize ) {
        $wp_customize->get_control( 'background_color' )->label = esc_html__( 'Body Background Color', 'wp-bootstrap-4' );
        $wp_customize->get_section( 'colors' )->title = esc_html__( 'Theme Colors', 'wp-bootstrap-4' );
    }
    add_action( 'customize_register', 'wp_bootstrap_4_colors_section' );
}

WP_Bootstrap_4_Kirki::add_field( 'wp_bootstrap_4_theme', array(
	'settings' => 'styling_header_bg_color',
	'label'    => esc_html__( 'Header Background Color', 'wp-bootstrap-4' ),
	'section'  => 'colors',
	'type'     => 'color',
    'default'  => '#343a40',
    'output'   => array(
        array(
			'element'  => array( '.navbar.bg-dark' ),
			'property' => 'background-color',
            'value_pattern' => '$ !important',
		),
    ),
) );

WP_Bootstrap_4_Kirki::add_field( 'wp_bootstrap_4_theme', array(
	'settings' => 'styling_primary_color',
	'section'  => 'colors',
	'type'     => 'color',
    'label' => esc_html__( 'Links & Buttons Color', 'wp-bootstrap-4' ),
    'default'  => '#007bff',
    'output'   => array(
        array(
			'element'  => array( 'a', '.btn-outline-primary', '.content-area .sp-the-post .entry-header .entry-title a:hover', '.btn-link' ),
			'property' => 'color',
		),
        array(
			'element'  => array( '.btn-primary', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.sp-services-section .sp-single-service .sp-service-icon', '.button.add_to_cart_button', '.wc-proceed-to-checkout .checkout-button.button', '.price_slider_amount button[type="submit"]' ),
			'property' => 'background-color',
		),
        array(
			'element'  => array( '.btn-primary', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.btn-outline-primary', '.button.add_to_cart_button', '.wc-proceed-to-checkout .checkout-button.button', '.price_slider_amount button[type="submit"]' ),
			'property' => 'border-color',
		),
        array(
			'element'  => array( '.btn-outline-primary:hover' ),
			'property' => 'background-color',
		),
        array(
			'element'  => array( '.btn-outline-primary:hover' ),
			'property' => 'border-color',
		),
        array(
            'element'  => array( '.entry-title a:hover', ),
            'property' => 'color',
            'value_pattern' => '$ !important',
        ),
        array(
            'element'       => array( '.btn-primary:focus', '.btn-outline-primary:focus' ),
            'property'      => 'box-shadow',
            'value_pattern' => '0 0 0 0.1rem $',
        ),
        array(
            'element' => array( '.shop_table.shop_table_responsive.woocommerce-cart-form__contents button[type="submit"]', '.form-row.place-order button[type="submit"]', '.single-product .summary.entry-summary button[type="submit"]' ),
            'property' => 'background-color',
        ),
        array(
            'element' => array( '.shop_table.shop_table_responsive.woocommerce-cart-form__contents button[type="submit"]', '.form-row.place-order button[type="submit"]', '.single-product .summary.entry-summary button[type="submit"]' ),
            'property' => 'border-color',
        ),
    ),
) );

WP_Bootstrap_4_Kirki::add_field( 'wp_bootstrap_4_theme', array(
	'settings' => 'styling_primary_hover_color',
	'label'    => esc_html__( 'Links & Buttons Hover Color', 'wp-bootstrap-4' ),
	'section'  => 'colors',
	'type'     => 'color',
    'default'  => '#0069d9',
    'output'   => array(
        array(
			'element'  => array( 'a:hover', 'a:active', 'a:focus', '.btn-link:hover', '.entry-meta a:hover', '.comments-link a:hover', '.edit-link a:hover' ),
			'property' => 'color',
		),
        array(
			'element'  => array( '.btn-primary:hover', '.btn-primary:active', '.btn-primary:focus', 'input[type="button"]:hover', 'input[type="button"]:active', 'input[type="button"]:focus', 'input[type="submit"]:hover', 'input[type="submit"]:active', 'input[type="submit"]:focus', '.btn-primary:not(:disabled):not(.disabled):active', '.button.add_to_cart_button:hover', '.wc-proceed-to-checkout .checkout-button.button:hover', '.price_slider_amount button[type="submit"]:hover' ),
			'property' => 'background-color',
		),
        array(
			'element'  => array( '.btn-primary:hover', '.btn-primary:active', '.btn-primary:focus', 'input[type="button"]:hover', 'input[type="button"]:active', 'input[type="button"]:focus', 'input[type="submit"]:hover', 'input[type="submit"]:active', 'input[type="submit"]:focus', '.btn-primary:not(:disabled):not(.disabled):active', '.button.add_to_cart_button:hover', '.wc-proceed-to-checkout .checkout-button.button:hover', '.price_slider_amount button[type="submit"]:hover' ),
			'property' => 'border-color',
		),
        array(
            'element' => array( '.shop_table.shop_table_responsive.woocommerce-cart-form__contents button[type="submit"]:hover', '.form-row.place-order button[type="submit"]:hover', '.single-product .summary.entry-summary button[type="submit"]:hover' ),
            'property' => 'background-color',
            'value_pattern' => '$ !important',
        ),
        array(
            'element' => array( '.shop_table.shop_table_responsive.woocommerce-cart-form__contents button[type="submit"]:hover', '.form-row.place-order button[type="submit"]:hover', '.single-product .summary.entry-summary button[type="submit"]:hover' ),
            'property' => 'border-color',
            'value_pattern' => '$ !important',
        ),
    ),
) );


WP_Bootstrap_4_Kirki::add_field( 'wp_bootstrap_4_theme', array(
	'settings' => 'styling_footer_bg_color',
	'label'    => esc_html__( 'Footer Background Color', 'wp-bootstrap-4' ),
	'section'  => 'colors',
	'type'     => 'color',
    'default'  => '#ffffff',
    'output'   => array(
        array(
			'element'  => array( '.site-footer.bg-white' ),
			'property' => 'background-color',
            'value_pattern' => '$ !important',
		),
    ),
) );

WP_Bootstrap_4_Kirki::add_field( 'wp_bootstrap_4_theme', array(
	'settings' => 'styling_footer_text_color',
	'label'    => esc_html__( 'Footer Text Color', 'wp-bootstrap-4' ),
	'section'  => 'colors',
	'type'     => 'color',
    'default'  => '#6c757d',
    'output'   => array(
        array(
			'element'  => array( '.site-footer.text-muted' ),
			'property' => 'color',
            'value_pattern' => '$ !important',
		),
    ),
) );

WP_Bootstrap_4_Kirki::add_field( 'wp_bootstrap_4_theme', array(
	'settings' => 'styling_footer_link_color',
	'label'    => esc_html__( 'Footer Link Color', 'wp-bootstrap-4' ),
	'section'  => 'colors',
	'type'     => 'color',
    'default'  => '#007bff',
    'output'   => array(
        array(
			'element'  => array( '.site-footer a' ),
			'property' => 'color',
            'value_pattern' => '$ !important',
		),
    ),
) );
