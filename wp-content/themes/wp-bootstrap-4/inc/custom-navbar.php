<?php

class WP_bootstrap_4_walker_nav_menu extends Walker_Nav_menu {

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $object      = $item->object;
    	$type        = $item->type;
    	$title       = $item->title;
    	$description = $item->description;
    	$permalink   = $item->url;

        $active_class = '';
        if( in_array('current-menu-item', $item->classes) ) {
            $active_class = 'active';
        }

        $dropdown_class = '';
        $dropdown_link_class = '';
        if( $args->walker->has_children && $depth == 0 ) {
            $dropdown_class = 'dropdown';
            $dropdown_link_class = 'dropdown-toggle';
        }

        $output .= "<li class='nav-item $active_class $dropdown_class " .  implode(" ", $item->classes) . "'>";

        if( $args->walker->has_children && $depth == 0 ) {
            $output .= '<a href="' . esc_url($permalink) . '" class="nav-link ' . $dropdown_link_class . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        }
        else {
            $output .= '<a href="' . esc_url($permalink) . '" class="nav-link">';
        }

        $output .= $title;

        if( $description != '' && $depth == 0 ) {
            $output .= '<small class="description">' . $description . '</small>';
        }

        $output .= '</a>';
    }

    function start_lvl( &$output, $depth=0, $args = array() ){
        $submenu = ($depth > 0) ? ' sub-menu' : '';
        $output .= "<ul class='dropdown-menu $submenu depth_$depth'>";
    }


}
