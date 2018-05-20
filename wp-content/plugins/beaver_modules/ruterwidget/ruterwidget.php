<?php

class ruterwidget extends FLBuilderModule {
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __( 'Ruterwidget', 'fl-builder' ),
            'description'     => __( 'Ruter til valg sted', 'fl-builder' ),
            'group'           => __( 'My Group', 'fl-builder' ),
            'category'        => __( 'Kristiania', 'fl-builder' ),
            'dir'             => BEAVER_PLUGIN_DIR . 'ruterwidget/',
            'url'             => BEAVER_PLUGIN_URL . 'ruterwidget/',
            'icon'            => 'button.svg',
            'editor_export'   => true, // Defaults to true and can be omitted.
            'enabled'         => true, // Defaults to true and can be omitted.
            'partial_refresh' => false, // Defaults to false and can be omitted.
        ));
    }
}

FLBuilder::register_module( 'ruterwidget', array(
    'info-tab'      => array(
        'title'         => __( 'Info', 'fl-builder' ),
        'sections'      => array(
            'section-1'  => array(
                'title'         => __( 'Section 1', 'fl-builder' ),
                'fields'        => array(
                    'ruter_id'     => array(
                        'type'          => 'unit',
                        'label'         => __( 'ID til ankomststed', 'fl-builder' ),
                    ), 
                    'gatenavn' => array(
                        'type' => 'text', 
                        'label' => 'Gatenavn', 
                        'default' => "SØK ID: https://ruter.no/reiseplanlegger/#st:1,sp:0,bp:0"
                    ),
                    'navn' => array(
                        'type' => 'text', 
                        'label' => 'Navn (Display)'
                    ),
                    'height'        => array(
						'type'          => 'text',
						'label'         => __( 'Height', 'fl-builder' ),
						'default'       => '400',
						'size'          => '5',
						'description'   => 'px',
					),
                    'width'        => array(
						'type'          => 'text',
						'label'         => __( 'Width', 'fl-builder' ),
						'default'       => '400',
						'size'          => '5',
						'description'   => 'px',
					),
                )
            )
        )
    )
));

?>
