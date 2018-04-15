<?php

//Legg til ressurser 
function kristiania_resources(){
    wp_enqueue_style('style', get_stylesheet_uri()); //style.css 
}
add_action('wp_enqueue_scripts', 'kristiania_resources'); //actions som wordpress kjører inkluderer nå funksjonen over 
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