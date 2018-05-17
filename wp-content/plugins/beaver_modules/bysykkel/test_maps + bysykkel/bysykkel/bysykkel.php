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
    
) );

?>