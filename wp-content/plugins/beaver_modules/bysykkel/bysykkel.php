<?php

class bysykkel extends FLBuilderModule {
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __( 'Bysykkel', 'fl-builder' ),
            'description'     => __( 'Bysykkelmodul, laget for testing', 'fl-builder' ),
            'group'           => __( 'My Group', 'fl-builder' ),
            'category'        => __( 'Kristiania', 'fl-builder' ),
            'dir'             => BEAVER_PLUGIN_DIR . 'bysykkel/',
            'url'             => BEAVER_PLUGIN_URL . 'bysykkel/',
            'icon'            => 'button.svg',
            'editor_export'   => true, // Defaults to true and can be omitted.
            'enabled'         => true, // Defaults to true and can be omitted.
            'partial_refresh' => false, // Defaults to false and can be omitted.
        ));
    }
}

FLBuilder::register_module( 'bysykkel', array(
'info-tab'      => array(
        'title'         => __( 'Info', 'fl-builder' ),
        'description'   => __('Fjerdingen: lat: 59.915997, lng: 10.760110; Vulkan: lat: 59.923339, lng: 10.752497; Kvadraturen: lat: 59.911087, lng: 10.745956; Brenneriveien: lat: 59.920352, lng: 10.752798;'),
        'sections'      => array(
            'my-section-1'  => array(
                'title'         => __( 'Section 1', 'fl-builder' ),
                'fields'        => array(
                     'latitude'     => array(
                        'type'          => 'text',
                        'label'         => __( 'Lat', 'fl-builder' ),
                    ),
                    'longitude'     => array(
                        'type'          => 'text',
                        'label'         => __( 'Lng', 'fl-builder' ),
                    ),
                )
            )
        )
    ),
) );

?>