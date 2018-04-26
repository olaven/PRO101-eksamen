<?php

/**
 * @class FLAccordionModule
 */
class FLAccordionModule extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'          	=> __( 'Accordion', 'fl-builder' ),
			'description'   	=> __( 'Display a collapsible accordion of items.', 'fl-builder' ),
			'category'      	=> __( 'Layout', 'fl-builder' ),
			'partial_refresh'	=> true,
			'icon'				=> 'layout.svg',
		));

		$this->add_css( 'font-awesome' );
	}
}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('FLAccordionModule', array(
	'items'         => array(
		'title'         => __( 'Items', 'fl-builder' ),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'items'         => array(
						'type'          => 'form',
						'label'         => __( 'Item', 'fl-builder' ),
						'form'          => 'accordion_items_form', // ID from registered form below
						'preview_text'  => 'label', // Name of a field to use for the preview text
						'multiple'      => true,
					),
				),
			),
		),
	),
	'style'        => array(
		'title'         => __( 'Style', 'fl-builder' ),
		'sections'      => array(
			'general'       => array(
				'title'         => '',
				'fields'        => array(
					'border_color'  => array(
						'type'          => 'color',
						'label'         => __( 'Border Color', 'fl-builder' ),
						'default'       => 'e5e5e5',
						'preview'       => array(
							'type'          => 'css',
							'selector'      => '.fl-accordion-item',
							'property'      => 'border-color',
						),
					),
					'label_size'   => array(
						'type'          => 'select',
						'label'         => __( 'Label Size', 'fl-builder' ),
						'default'       => 'small',
						'options'       => array(
							'small'         => _x( 'Small', 'Label size.', 'fl-builder' ),
							'medium'        => _x( 'Medium', 'Label size.', 'fl-builder' ),
							'large'         => _x( 'Large', 'Label size.', 'fl-builder' ),
						),
						'preview'       => array(
							'type'          => 'none',
						),
					),
					'item_spacing'     => array(
						'type'          => 'text',
						'label'         => __( 'Item Spacing', 'fl-builder' ),
						'default'       => '10',
						'maxlength'     => '2',
						'size'          => '3',
						'description'   => 'px',
						'sanitize'		=> 'absint',
						'preview'       => array(
							'type'          => 'none',
						),
					),
					'collapse'   => array(
						'type'          => 'select',
						'label'         => __( 'Collapse Inactive', 'fl-builder' ),
						'default'       => '1',
						'options'       => array(
							'1'             => __( 'Yes', 'fl-builder' ),
							'0'             => __( 'No', 'fl-builder' ),
						),
						'help'          => __( 'Choosing yes will keep only one item open at a time. Choosing no will allow multiple items to be open at the same time.', 'fl-builder' ),
						'preview'       => array(
							'type'          => 'none',
						),
					),
					'open_first'       => array(
						'type'          => 'select',
						'label'         => __( 'Expand First Item', 'fl-builder' ),
						'default'       => '0',
						'options'       => array(
							'0'             => __( 'No', 'fl-builder' ),
							'1'             => __( 'Yes', 'fl-builder' ),
						),
						'help' 			=> __( 'Choosing yes will expand the first item by default.', 'fl-builder' ),
					),
				),
			),
		),
	),
));

/**
 * Register a settings form to use in the "form" field type above.
 */
FLBuilder::register_settings_form('accordion_items_form', array(
	'title' => __( 'Add Item', 'fl-builder' ),
	'tabs'  => array(
		'general'      => array(
			'title'         => __( 'General', 'fl-builder' ),
			'sections'      => array(
				'general'       => array(
					'title'         => '',
					'fields'        => array(
						'label'         => array(
							'type'          => 'text',
							'label'         => __( 'Label', 'fl-builder' ),
							'connections'   => array( 'string' ),
						),
					),
				),
				'content'       => array(
					'title'         => __( 'Content', 'fl-builder' ),
					'fields'        => array(
						'content'       => array(
							'type'          => 'editor',
							'label'         => '',
							'wpautop'		=> false,
							'connections'   => array( 'string' ),
						),
					),
				),
			),
		),
	),
));
