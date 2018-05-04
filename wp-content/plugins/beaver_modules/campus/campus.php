<?php

class campus extends FLBuilderModule {
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __( 'Campus', 'fl-builder' ),
            'description'     => __( 'Vise campuser!', 'fl-builder' ),
            'group'           => __( 'My Group', 'fl-builder' ),
            'category'        => __( 'Kristiania', 'fl-builder' ),
            'dir'             => BEAVER_PLUGIN_DIR . 'campus/',
            'url'             => BEAVER_PLUGIN_URL . 'campus/',
            'icon'            => 'button.svg',
            'editor_export'   => true, // Defaults to true and can be omitted.
            'enabled'         => true, // Defaults to true and can be omitted.
            'partial_refresh' => false, // Defaults to false and can be omitted.
        ));
    }
}

FLBuilder::register_module( 'campus', array(
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
                    'navn'     => array(
                        'type'          => 'text',
                        'label'         => __( 'Navn', 'fl-builder' ),
                    ), 
                    'apent_fra'     => array(
                        'type'       => 'time',
                        'label'      => __( 'Åpningstider', 'fl-builder' ),
                        'default'		=>array(
                            'hours'		=> '08',
                            'minutes'	=> '00',
                            'day_period'	=> 'am'
                    )
                    ), 
                    'apent_til'     => array(
                        'type'       => 'time',
                        'label'      => __( 'Åpningstider', 'fl-builder' ),
                        'default'		=>array(
                            'hours'		=> '11',
                            'minutes'	=> '00',
                            'day_period'	=> 'pm'
                        )
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