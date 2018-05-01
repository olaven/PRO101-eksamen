<?php

/**
 * @class FLIconModule
 */
class FLIconModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'          	=> __( 'Icon', 'fl-builder' ),
			'description'   	=> __( 'Display an icon and optional title.', 'fl-builder' ),
			'category'      	=> __( 'Media', 'fl-builder' ),
			'editor_export' 	=> false,
			'partial_refresh'	=> true,
			'icon'				=> 'star-filled.svg',
		));
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLIconModule', array(
	'general'       => array( // Tab
		'title'         => __( 'General', 'fl-builder' ), // Tab title
		'sections'      => array( // Tab Sections
			'general'       => array( // Section
				'title'         => '', // Section Title
				'fields'        => array( // Section Fields
					'icon'          => array(
						'type'          => 'icon',
						'label'         => __( 'Icon', 'fl-builder' ),
					),
				),
			),
			'link'          => array(
				'title'         => __( 'Link', 'fl-builder' ),
				'fields'        => array(
					'link'          => array(
						'type'          => 'link',
						'label'         => __( 'Link', 'fl-builder' ),
						'preview'       => array(
							'type'          => 'none',
						),
						'connections'   => array( 'url' ),
					),
					'link_target'   => array(
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
				),
			),
			'text'          => array(
				'title'         => __( 'Text', 'fl-builder' ),
				'fields'        => array(
					'text'          => array(
						'type'          => 'editor',
						'label'         => '',
						'media_buttons' => false,
						'connections'   => array( 'string' ),
					),
				),
			),
		),
	),
	'style'         => array( // Tab
		'title'         => __( 'Style', 'fl-builder' ), // Tab title
		'sections'      => array( // Tab Sections
			'colors'        => array( // Section
				'title'         => __( 'Colors', 'fl-builder' ), // Section Title
				'fields'        => array( // Section Fields
					'color'         => array(
						'type'          => 'color',
						'label'         => __( 'Color', 'fl-builder' ),
						'show_reset'    => true,
					),
					'hover_color' => array(
						'type'          => 'color',
						'label'         => __( 'Hover Color', 'fl-builder' ),
						'show_reset'    => true,
						'preview'       => array(
							'type'          => 'none',
						),
					),
					'bg_color'      => array(
						'type'          => 'color',
						'label'         => __( 'Background Color', 'fl-builder' ),
						'show_reset'    => true,
					),
					'bg_hover_color' => array(
						'type'          => 'color',
						'label'         => __( 'Background Hover Color', 'fl-builder' ),
						'show_reset'    => true,
						'preview'       => array(
							'type'          => 'none',
						),
					),
					'three_d'       => array(
						'type'          => 'select',
						'label'         => __( 'Gradient', 'fl-builder' ),
						'default'       => '0',
						'options'       => array(
							'0'             => __( 'No', 'fl-builder' ),
							'1'             => __( 'Yes', 'fl-builder' ),
						),
					),
				),
			),
			'structure'     => array( // Section
				'title'         => __( 'Structure', 'fl-builder' ), // Section Title
				'fields'        => array( // Section Fields
					'size'          => array(
						'type'          => 'text',
						'label'         => __( 'Size', 'fl-builder' ),
						'default'       => '30',
						'maxlength'     => '3',
						'size'          => '4',
						'description'   => 'px',
						'sanitize'		=> 'absint',
					),
					'align'         => array(
						'type'          => 'select',
						'label'         => __( 'Alignment', 'fl-builder' ),
						'default'       => 'left',
						'options'       => array(
							'center'        => __( 'Center', 'fl-builder' ),
							'left'          => __( 'Left', 'fl-builder' ),
							'right'         => __( 'Right', 'fl-builder' ),
						),
					),
				),
			),
			'r_structure'	=> array(
				'title'			=> __( 'Mobile Structure', 'fl-builder' ),
				'fields'		=> array(
					'r_align'		=> array(
						'type'			=> 'select',
						'label'			=> __( 'Alignment', 'fl-builder' ),
						'default'		=> 'default',
						'options'		=> array(
							'default'		=> __( 'Default', 'fl-builder' ),
							'custom'		=> __( 'Custom', 'fl-builder' ),
						),
						'toggle'		=> array(
							'custom'		=> array(
								'fields'		=> array( 'r_custom_align' ),
							),
						),
					),
					'r_custom_align'	=> array(
						'type'				=> 'select',
						'label'				=> __( 'Custom Alignment', 'fl-builder' ),
						'default'			=> 'left',
						'options'			=> array(
							'left'				=> __( 'Left', 'fl-builder' ),
							'center'			=> __( 'Center', 'fl-builder' ),
							'right'				=> __( 'Right', 'fl-builder' ),
						),
					),
				),
			),
		),
	),
));
