<?php

class campus extends FLBuilderModule {
    public function __construct()
    {
        parent::__construct(array(
            'name'            => __( 'Campus', 'fl-builder' ),
            'description'     => __( 'Vise campuser!', 'fl-builder' ),
            'group'           => __( 'My Group', 'fl-builder' ),
            'category'        => __( 'Kristiania', 'fl-builder' ),
            'dir'             => MY_MODULES_DIR . 'campus/',
            'url'             => MY_MODULES_URL . 'campus/',
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
                    'bilde-felt'     => array(
                        'type'          => 'photo',
                        'label'         => __( 'Bilde', 'fl-builder' ),
                    ),
                    'campusnavn-felt'     => array(
                        'type'          => 'text',
                        'label'         => __( 'Navn', 'fl-builder' ),
                    ), 
                    'apent-fra-felt'     => array(
                        'type'       => 'time',
                        'label'      => __( 'Åpningstider', 'fl-builder' ),
                        'default'		=>array(
                            'hours'		=> '08',
                            'minutes'	=> '00',
                            'day_period'	=> 'am'
                    )
                    ), 
                    'apent-til-felt'     => array(
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