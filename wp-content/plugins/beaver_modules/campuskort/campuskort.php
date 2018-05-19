<?php

class campuskort extends FLBuilderModule {
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __( 'Campuskort', 'fl-builder' ),
            'description'     => __( 'Kort for å velge et campus', 'fl-builder' ),
            'group'           => __( 'My Group', 'fl-builder' ),
            'category'        => __( 'Kristiania', 'fl-builder' ),
            'dir'             => BEAVER_PLUGIN_DIR . 'campuskort/',
            'url'             => BEAVER_PLUGIN_URL . 'campuskort/',
            'icon'            => 'button.svg',
            'editor_export'   => true, // Defaults to true and can be omitted.
            'enabled'         => true, // Defaults to true and can be omitted.
            'partial_refresh' => false, // Defaults to false and can be omitted.
        ));
    }
}

FLBuilder::register_module( 'campuskort', array(
    'info-tab'      => array(
        'title'         => __( 'Info', 'fl-builder' ),
        'sections'      => array(
            'my-section-1'  => array(
                'title'         => __( 'Section 1', 'fl-builder' ),
                'fields'        => array(
                    'bilde'     => array(
                        'type'          => 'photo',
                        'label'         => __( 'Bilde', 'fl-builder' ),
                    ),
                    'tekst'     => array(
                        'type'          => 'text',
                        'label'         => __( 'Tekst', 'fl-builder' ),
                    )
                )
            )
        )
    ),
    'farger-tab'      => array(
        'title'         => __( 'Farger', 'fl-builder' ),
    ),
) );

?>