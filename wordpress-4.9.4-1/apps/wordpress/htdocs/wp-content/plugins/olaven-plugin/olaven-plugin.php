<?php
    /**
     * Plugin Name: olaven-plugin
     */

    //to avoid collision with other global variables -> prefix "olaven"
    function olaven_remove_metabox(){
        //https://codex.wordpress.org/Function_Reference/remove_meta_box
        //remove_meta_box("dashboard_primary", "dashboard", "post_container_1"); 
    }

    //add action to wordpress -> add new content 
    //hook -> whrer to excecute, funtion -> what to do 
    //addAction("wq_dashboard_setup", "olaven_remove_metabox"); 

    //add fileter to wordpress -> modifiy ("filter") something that already exists 
    //addFilter("a_hook", "my_function"); 
    
?>