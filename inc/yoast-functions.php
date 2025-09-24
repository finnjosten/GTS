<?php

if ( ! function_exists( 'gts_wpseo_breadcrumb_separator' ) ) {

    function gts_wpseo_breadcrumb_separator( $separator  ) {
        return '<i class="fa-solid fa-chevron-right"></i>';
    }

    add_filter( 'wpseo_breadcrumb_separator', 'gts_wpseo_breadcrumb_separator' );
}

if ( ! function_exists( 'gts_wpseo_breadcrumb_links' ) ) {

    function gts_wpseo_breadcrumb_links( $links ) {
        $links[0]['text'] = '<i class="fa-solid fa-house"></i>' . __("Home", "GTS");
        return $links;
    }

    add_filter( 'wpseo_breadcrumb_links', 'gts_wpseo_breadcrumb_links' );
}