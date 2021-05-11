<?php
if ( ! function_exists( 'bw_coming_soon_if_page_exists' ) ) {

	function bw_coming_soon_if_page_exists($slug) {

	    global $wpdb;

	    if( $wpdb->get_row( "SELECT post_name FROM wp_posts WHERE post_name = '" . $slug . "' AND post_type = 'page'", 'ARRAY_A' ) ) {

	        return true;

	    } else {

	        return false;
	        
	    }
	}
}