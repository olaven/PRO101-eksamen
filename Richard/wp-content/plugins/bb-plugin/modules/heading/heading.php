<?php

/**
 * @class FLHeadingModule
 */
class FLHeadingModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'          	=> __( 'Heading', 'fl-builder' ),
			'description'   	=> __( 'Display a title/page heading.', 'fl-builder' ),
			'category'      	=> __( 'Basic', 'fl-builder' ),
			'partial_refresh'	=> true,
			'icon'				=> 'text.svg',
		));
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLHeadingModule', array(
	'general'       => array(
		'title'         => __( 'General', 'fl-builder' ),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'heading'        => array(
						'type'            => 'text',
						'label'           => __( 'Heading', 'fl-builder' ),
						'default'         => '',
						'preview'         => array(
							'type'            => 'text',
							'selector'        => '.fl-heading-text',
						),
						'connections'     => array( 'string' ),
					),
				),
			),
			'link'          => array(
				'title'         => __( 'Link', 'fl-builder' ),
				'fields'        => array(
					'link'          => array(
						'type'          => 'link',
						'label'         => __( 'Link', 'fl-builder' ),
						'preview'         => array(
							'type'            => 'none',
						),
						'connections'     => array( 'url' ),
					),
					'link_target'   => array(
						'type'          => 'select',
						'label'         => __( 'Link Target', 'fl-builder' ),
						'default'       => '_self',
						'options'       => array(
							'_self'         => __( 'Same Window', 'fl-builder' ),
							'_blank'        => __( 'New Window', 'fl-builder' ),
						),
						'preview'         => array(
							'type'            => 'none',
						),
					),
				),
			),
		),
	),
	'style'         => array(
		'title'         => __( 'Style', 'fl-builder' ),
		'sections'      => array(
			'colors'        => array(
				'title'         => __( 'Colors', 'fl-builder' ),
				'fields'        => array(
					'color'          => array(
						'type'          => 'color',
						'show_reset'    => true,
						'label'         => __( 'Text Color', 'fl-builder' ),
					),
				),
			),
			'structure'     => array(
				'title'         => __( 'Structure', 'fl-builder' ),
				'fields'        => array(
					'alignment'     => array(
						'type'          => 'select',
						'label'         => __( 'Alignment', 'fl-builder' ),
						'default'       => 'left',
						'options'       => array(
							'left'      => __( 'Left', 'fl-builder' ),
							'center'    => __( 'Center', 'fl-builder' ),
							'right'     => __( 'Right', 'fl-builder' ),
						),
						'preview'         => array(
							'type'            => 'css',
							'selector'        => '.fl-heading',
							'property'        => 'text-align',
						),
					),
					'tag'           => array(
						'type'          => 'select',
						'label'         => __( 'HTML Tag', 'fl-builder' ),
						'default'       => 'h3',
						'options'       => array(
							'h1'            => 'h1',
							'h2'            => 'h2',
							'h3'            => 'h3',
							'h4'            => 'h4',
							'h5'            => 'h5',
							'h6'            => 'h6',
						),
					),
					'font'          => array(
						'type'          => 'font',
						'default'		=> array(
							'family'		=> 'Default',
							'weight'		=> 300,
						),
						'label'         => __( 'Font', 'fl-builder' ),
						'preview'         => array(
							'type'            => 'font',
							'selector'        => '.fl-heading-text',
						),
					),
					'font_size'     => array(
						'type'          => 'select',
						'label'         => __( 'Font Size', 'fl-builder' ),
						'default'       => 'default',
						'options'       => array(
							'default'       => __( 'Default', 'fl-builder' ),
							'custom'        => __( 'Custom', 'fl-builder' ),
						),
						'toggle'        => array(
							'custom'        => array(
								'fields'        => array( 'custom_font_size' ),
							),
						),
					),
					'custom_font_size' => array(
						'type'          => 'text',
						'label'         => __( 'Custom Font Size', 'fl-builder' ),
						'default'       => '24',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
						'sanitize'		=> 'absint',
					),
					'line_height'     => array(
						'type'          => 'select',
						'label'         => __( 'Line Height', 'fl-builder' ),
						'default'       => 'default',
						'options'       => array(
							'default'       => __( 'Default', 'fl-builder' ),
							'custom'        => __( 'Custom', 'fl-builder' ),
						),
						'toggle'        => array(
							'custom'        => array(
								'fields'        => array( 'custom_line_height' ),
							),
						),
					),
					'custom_line_height' => array(
						'type'          => 'text',
						'label'         => __( 'Custom Line Height', 'fl-builder' ),
						'default'       => '1.4',
						'maxlength'     => '4',
						'size'          => '4',
						'description'   => 'em',
					),
					'letter_spacing'     => array(
						'type'          => 'select',
						'label'         => __( 'Letter Spacing', 'fl-builder' ),
						'default'       => 'default',
						'options'       => array(
							'default'       => __( 'Default', 'fl-builder' ),
							'custom'        => __( 'Custom', 'fl-builder' ),
						),
						'toggle'        => array(
							'custom'        => array(
								'fields'        => array( 'custom_letter_spacing' ),
							),
						),
					),
					'custom_letter_spacing' => array(
						'type'          => 'text',
						'label'         => __( 'Custom Letter Spacing', 'fl-builder' ),
						'default'       => '0',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
					),
				),
			),
			'r_structure'   => array(
				'title'         => __( 'Mobile Structure', 'fl-builder' ),
				'fields'        => array(
					'r_alignment'   => array(
						'type'          => 'select',
						'label'         => __( 'Alignment', 'fl-builder' ),
						'default'       => 'default',
						'options'       => array(
							'default'       => __( 'Default', 'fl-builder' ),
							'custom'        => __( 'Custom', 'fl-builder' ),
						),
						'toggle'        => array(
							'custom'        => array(
								'fields'        => array( 'r_custom_alignment' ),
							),
						),
						'preview'         => array(
							'type'            => 'none',
						),
					),
					'r_custom_alignment' => array(
						'type'          => 'select',
						'label'         => __( 'Custom Alignment', 'fl-builder' ),
						'default'       => 'center',
						'options'       => array(
							'left'      => __( 'Left', 'fl-builder' ),
							'center'    => __( 'Center', 'fl-builder' ),
							'right'     => __( 'Right', 'fl-builder' ),
						),
						'preview'         => array(
							'type'            => 'none',
						),
					),
					'r_font_size'   => array(
						'type'          => 'select',
						'label'         => __( 'Font Size', 'fl-builder' ),
						'default'       => 'default',
						'options'       => array(
							'default'       => __( 'Default', 'fl-builder' ),
							'custom'        => __( 'Custom', 'fl-builder' ),
						),
						'toggle'        => array(
							'custom'        => array(
								'fields'        => array( 'r_custom_font_size' ),
							),
						),
					),
					'r_custom_font_size' => array(
						'type'          => 'text',
						'label'         => __( 'Custom Font Size', 'fl-builder' ),
						'default'       => '24',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
						'sanitize'		=> 'absint',
					),
					'r_line_height'     => array(
						'type'          => 'select',
						'label'         => __( 'Line Height', 'fl-builder' ),
						'default'       => 'default',
						'options'       => array(
							'default'       => __( 'Default', 'fl-builder' ),
							'custom'        => __( 'Custom', 'fl-builder' ),
						),
						'toggle'        => array(
							'custom'        => array(
								'fields'        => array( 'r_custom_line_height' ),
							),
						),
					),
					'r_custom_line_height' => array(
						'type'          => 'text',
						'label'         => __( 'Custom Line Height', 'fl-builder' ),
						'default'       => '1.4',
						'maxlength'     => '4',
						'size'          => '4',
					),
					'r_letter_spacing'     => array(
						'type'          => 'select',
						'label'         => __( 'Letter Spacing', 'fl-builder' ),
						'default'       => 'default',
						'options'       => array(
							'default'       => __( 'Default', 'fl-builder' ),
							'custom'        => __( 'Custom', 'fl-builder' ),
						),
						'toggle'        => array(
							'custom'        => array(
								'fields'        => array( 'r_custom_letter_spacing' ),
							),
						),
					),
					'r_custom_letter_spacing' => array(
						'type'          => 'text',
						'label'         => __( 'Custom Letter Spacing', 'fl-builder' ),
						'default'       => '0',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
					),
				),
			),
		),
	),
));
