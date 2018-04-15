<?php
//registerer en widgetarea til wordpress backend
if ( function_exists('register_sidebar') )
    register_sidebar(
        array(
            'name' => 'map-widget-area',
            'before_widget' => '<div class = "widgetizedArea">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        )
    );
?>