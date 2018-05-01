<?php

/**
 * @class FLRichTextModule
 */
class FLPricingTableModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'          	=> __( 'Pricing Table', 'fl-builder' ),
			'description'   	=> __( 'A simple pricing table generator.', 'fl-builder' ),
			'category'      	=> __( 'Layout', 'fl-builder' ),
			'partial_refresh'	=> true,
			'icon'				=> 'editor-table.svg',
		));
	}

	/**
	 * @method render_button
	 */
	public function render_button( $column ) {
		$btn_settings = array(
			'align'				=> $this->settings->pricing_columns[ $column ]->btn_align,
			'bg_color'          => $this->settings->pricing_columns[ $column ]->btn_bg_color,
			'bg_hover_color'    => $this->settings->pricing_columns[ $column ]->btn_bg_hover_color,
			'bg_opacity'        => $this->settings->pricing_columns[ $column ]->btn_bg_opacity,
			'border_radius'     => $this->settings->pricing_columns[ $column ]->btn_border_radius,
			'border_size'       => $this->settings->pricing_columns[ $column ]->btn_border_size,
			'font_size'         => $this->settings->pricing_columns[ $column ]->btn_font_size,
			'icon'              => $this->settings->pricing_columns[ $column ]->btn_icon,
			'icon_position'     => $this->settings->pricing_columns[ $column ]->btn_icon_position,
			'icon_animation'    => $this->settings->pricing_columns[ $column ]->btn_icon_animation,
			'link'              => $this->settings->pricing_columns[ $column ]->button_url,
			'link_nofollow'     => $this->settings->pricing_columns[ $column ]->btn_link_nofollow,
			'link_target'       => $this->settings->pricing_columns[ $column ]->btn_link_target,
			'padding'           => $this->settings->pricing_columns[ $column ]->btn_padding,
			'style'             => $this->settings->pricing_columns[ $column ]->btn_style,
			'text'              => $this->settings->pricing_columns[ $column ]->button_text,
			'text_color'        => $this->settings->pricing_columns[ $column ]->btn_text_color,
			'text_hover_color'  => $this->settings->pricing_columns[ $column ]->btn_text_hover_color,
			'width'             => $this->settings->pricing_columns[ $column ]->btn_width,
		);

		FLBuilder::render_module_html( 'button', $btn_settings );
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLPricingTableModule', array(
	'columns'      => array(
		'title'         => __( 'Pricing Boxes', 'fl-builder' ),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'pricing_columns'     => array(
						'type'         => 'form',
						'label'        => __( 'Pricing Box', 'fl-builder' ),
						'form'         => 'pricing_column_form',
						'preview_text' => 'title',
						'multiple'     => true,
					),
				),
			),
		),
	),
	'style'       => array(
		'title'         => __( 'Style', 'fl-builder' ),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'highlight'   => array(
						'type'          => 'select',
						'label'         => __( 'Highlight', 'fl-builder' ),
						'default'       => 'price',
						'options'       => array(
							'price'       => __( 'Price', 'fl-builder' ),
							'title'       => __( 'Title', 'fl-builder' ),
							'none'        => __( 'None', 'fl-builder' ),
						),
					),
					'border_radius'   => array(
						'type'          => 'select',
						'label'         => __( 'Border Style', 'fl-builder' ),
						'default'       => 'rounded',
						'options'       => array(
							'rounded'        => __( 'Rounded', 'fl-builder' ),
							'straight'       => __( 'Straight', 'fl-builder' ),
						),
					),
					'border_size'   => array(
						'type'          => 'select',
						'label'         => __( 'Border Size', 'fl-builder' ),
						'default'       => 'wide',
						'options'       => array(
							'large'     => _x( 'Large', 'Border size.', 'fl-builder' ),
							'medium'    => _x( 'Medium', 'Border size.', 'fl-builder' ),
							'small'     => _x( 'Small', 'Border size.', 'fl-builder' ),
						),
					),
					'spacing'   => array(
						'type'          => 'select',
						'label'         => __( 'Spacing', 'fl-builder' ),
						'default'       => 'wide',
						'options'       => array(
							'large'      => __( 'Large', 'fl-builder' ),
							'medium'     => __( 'Medium', 'fl-builder' ),
							'none'       => __( 'None', 'fl-builder' ),
						),
					),
					'min_height'   => array(
						'type'          => 'text',
						'label'         => __( 'Features Min Height', 'fl-builder' ),
						'default'       => '0',
						'size'          => '5',
						'description'   => 'px',
						'help'          => __( 'Use this to normalize the height of your boxes when they have different numbers of features.', 'fl-builder' ),
					),
				),
			),
		),
	),
));

FLBuilder::register_settings_form('pricing_column_form', array(
	'title' => __( 'Add Pricing Box', 'fl-builder' ),
	'tabs'  => array(
		'general'      => array(
			'title'         => __( 'General', 'fl-builder' ),
			'sections'      => array(
				'title'       => array(
					'title'         => __( 'Title', 'fl-builder' ),
					'fields'        => array(
						'title'          => array(
							'type'          => 'text',
							'label'         => __( 'Title', 'fl-builder' ),
						),
						'title_size'        => array(
							'type'          => 'text',
							'label'         => __( 'Title Size', 'fl-builder' ),
							'default'       => '24',
							'maxlength'     => '3',
							'size'          => '4',
							'description'   => 'px',
						),
					),
				),
				'price-box'       => array(
					'title'         => __( 'Price Box', 'fl-builder' ),
					'fields'        => array(
						'price'          => array(
							'type'          => 'text',
							'label'         => __( 'Price', 'fl-builder' ),
						),
						'duration'          => array(
							'type'          => 'text',
							'label'         => __( 'Duration', 'fl-builder' ),
							'placeholder'   => __( 'per Year', 'fl-builder' ),
						),
						'price_size'        => array(
							'type'          => 'text',
							'label'         => __( 'Price Size', 'fl-builder' ),
							'default'       => '31',
							'maxlength'     => '3',
							'size'          => '4',
							'description'   => 'px',
						),
					),
				),
				'features'       => array(
					'title'         => _x( 'Features', 'Price features displayed in pricing box.', 'fl-builder' ),
					'fields'        => array(
						'features'          => array(
							'type'          => 'text',
							'label'         => '',
							'placeholder'   => __( 'One feature per line. HTML is okay.', 'fl-builder' ),
							'multiple'      => true,
						),
					),
				),
			),
		),
		'button'      => array(
			'title'         => __( 'Button', 'fl-builder' ),
			'sections'      => array(
				'default'   => array(
					'title'         => '',
					'fields'        => array(
						'button_text'   => array(
							'type'          => 'text',
							'label'         => __( 'Button Text', 'fl-builder' ),
							'default'       => __( 'Get Started', 'fl-builder' ),
						),
						'button_url'    => array(
							'type'          => 'link',
							'label'         => __( 'Button URL', 'fl-builder' ),
						),
						'btn_link_target'    	=> array(
							'type'          => 'select',
							'label'         => __( 'Link Target', 'fl-builder' ),
							'default'       => '_self',
							'options'       => array(
								'_self'         => __( 'Same Window', 'fl-builder' ),
								'_blank'        => __( 'New Window', 'fl-builder' ),
							),
							'preview'       => array(
								'type'          => 'none',
							),
						),
						'btn_link_nofollow' => array(
							'type'          	=> 'select',
							'label' 	        => __( 'Link No Follow', 'fl-builder' ),
							'default'       => 'no',
							'options' 			=> array(
								'yes' 				=> __( 'Yes', 'fl-builder' ),
								'no' 				=> __( 'No', 'fl-builder' ),
							),
							'preview'       	=> array(
								'type'          	=> 'none',
							),
						),
						'btn_icon'      => array(
							'type'          => 'icon',
							'label'         => __( 'Button Icon', 'fl-builder' ),
							'show_remove'   => true,
						),
						'btn_icon_position' => array(
							'type'          => 'select',
							'label'         => __( 'Button Icon Position', 'fl-builder' ),
							'default'       => 'before',
							'options'       => array(
								'before'        => __( 'Before Text', 'fl-builder' ),
								'after'         => __( 'After Text', 'fl-builder' ),
							),
						),
						'btn_icon_animation' => array(
							'type'          => 'select',
							'label'         => __( 'Icon Visibility', 'fl-builder' ),
							'default'       => 'disable',
							'options'       => array(
								'disable'        => __( 'Always Visible', 'fl-builder' ),
								'enable'         => __( 'Fade In On Hover', 'fl-builder' ),
							),
						),
					),
				),
				'btn_colors'     => array(
					'title'         => __( 'Button Colors', 'fl-builder' ),
					'fields'        => array(
						'btn_bg_color'  => array(
							'type'          => 'color',
							'label'         => __( 'Background Color', 'fl-builder' ),
							'default'       => '',
							'show_reset'    => true,
						),
						'btn_bg_hover_color' => array(
							'type'          => 'color',
							'label'         => __( 'Background Hover Color', 'fl-builder' ),
							'default'       => '',
							'show_reset'    => true,
						),
						'btn_text_color' => array(
							'type'          => 'color',
							'label'         => __( 'Text Color', 'fl-builder' ),
							'default'       => '',
							'show_reset'    => true,
						),
						'btn_text_hover_color' => array(
							'type'          => 'color',
							'label'         => __( 'Text Hover Color', 'fl-builder' ),
							'default'       => '',
							'show_reset'    => true,
						),
					),
				),
				'btn_style'     => array(
					'title'         => __( 'Button Style', 'fl-builder' ),
					'fields'        => array(
						'btn_style'     => array(
							'type'          => 'select',
							'label'         => __( 'Style', 'fl-builder' ),
							'default'       => 'flat',
							'options'       => array(
								'flat'          => __( 'Flat', 'fl-builder' ),
								'gradient'      => __( 'Gradient', 'fl-builder' ),
								'transparent'   => __( 'Transparent', 'fl-builder' ),
							),
							'toggle'        => array(
								'transparent'   => array(
									'fields'        => array( 'btn_bg_opacity', 'btn_bg_hover_opacity', 'btn_border_size' ),
								),
							),
						),
						'btn_border_size' => array(
							'type'          => 'text',
							'label'         => __( 'Border Size', 'fl-builder' ),
							'default'       => '2',
							'description'   => 'px',
							'maxlength'     => '3',
							'size'          => '5',
							'placeholder'   => '0',
						),
						'btn_bg_opacity' => array(
							'type'          => 'text',
							'label'         => __( 'Background Opacity', 'fl-builder' ),
							'default'       => '0',
							'description'   => '%',
							'maxlength'     => '3',
							'size'          => '5',
							'placeholder'   => '0',
						),
						'btn_bg_hover_opacity' => array(
						'type'          => 'text',
						'label'         => __( 'Background Hover Opacity', 'fl-builder' ),
						'default'       => '0',
						'description'   => '%',
						'maxlength'     => '3',
						'size'          => '5',
						'placeholder'   => '0',
						),
						'btn_button_transition' => array(
							'type'          => 'select',
							'label'         => __( 'Transition', 'fl-builder' ),
							'default'       => 'disable',
							'options'       => array(
								'disable'        => __( 'Disabled', 'fl-builder' ),
								'enable'         => __( 'Enabled', 'fl-builder' ),
							),
						),
					),
				),
				'btn_structure' => array(
					'title'         => __( 'Button Structure', 'fl-builder' ),
					'fields'        => array(
						'btn_width'     => array(
							'type'          => 'select',
							'label'         => __( 'Width', 'fl-builder' ),
							'default'       => 'full',
							'options'       => array(
								'auto'          => _x( 'Auto', 'Width.', 'fl-builder' ),
								'full'          => __( 'Full Width', 'fl-builder' ),
							),
						),
						'btn_align'    	=> array(
							'type'          => 'select',
							'label'         => __( 'Alignment', 'fl-builder' ),
							'default'       => 'center',
							'options'       => array(
								'left'          => __( 'Left', 'fl-builder' ),
								'center'		=> __( 'Center', 'fl-builder' ),
								'right'         => __( 'Right', 'fl-builder' ),
							),
							'preview'       => array(
								'type'          => 'none',
							),
						),
						'btn_font_size' => array(
							'type'          => 'text',
							'label'         => __( 'Font Size', 'fl-builder' ),
							'default'       => '16',
							'maxlength'     => '3',
							'size'          => '4',
							'description'   => 'px',
						),
						'btn_padding'   => array(
							'type'          => 'text',
							'label'         => __( 'Padding', 'fl-builder' ),
							'default'       => '12',
							'maxlength'     => '3',
							'size'          => '4',
							'description'   => 'px',
						),
						'btn_border_radius' => array(
							'type'          => 'text',
							'label'         => __( 'Round Corners', 'fl-builder' ),
							'default'       => '4',
							'maxlength'     => '3',
							'size'          => '4',
							'description'   => 'px',
						),
					),
				),
			),
		),
		'style'      => array(
			'title'         => __( 'Style', 'fl-builder' ),
			'sections'      => array(
				'style'       => array(
					'title'         => 'Style',
					'fields'        => array(
						'background'          => array(
							'type'          => 'color',
							'label'         => __( 'Box Border', 'fl-builder' ),
							'default'       => 'F2F2F2',
						),
						'foreground'          => array(
							'type'          => 'color',
							'label'         => __( 'Box Foreground', 'fl-builder' ),
							'default'       => 'ffffff',
						),
						'column_background'  => array(
							'type'          => 'color',
							'default'       => '66686b',
							'label'         => __( 'Accent Color', 'fl-builder' ),
						),
						'column_color'          => array(
							'type'          => 'color',
							'default'       => 'ffffff',
							'label'         => __( 'Accent Text Color', 'fl-builder' ),
						),
						'margin'        => array(
							'type'          => 'text',
							'label'         => __( 'Box Top Margin', 'fl-builder' ),
							'default'       => '0',
							'maxlength'     => '3',
							'size'          => '3',
							'description'   => 'px',
						),
					),
				),
			),
		),
	),
));
