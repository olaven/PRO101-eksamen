<?php
//registerer Det som er i widget area
if ( function_exists('register_sidebar') )
    register_sidebar(
        array(
            'name' => 'widget-area',
            'before_widget' => '<div class = "widgetizedArea">',
            'after_widget' => '</div>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        )
    );
?>