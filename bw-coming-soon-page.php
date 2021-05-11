<?php
/*
Plugin Name:		BW Coming soon Page
Plugin URI:			https://github.com/nmorshed/bw-coming-soon-page
Description:		You can set an existing page as a coming soon/Maintenance page and you can build this page as you want with your editor or favorite page builder.
Version:			1.0.0
Requires at least:	4.0
Requires PHP:		5.6
Author:				Better Wizard
Author URI:			http://betterwizard.com
Developer:			Niaj Morshed
License: 			GPL v2 or later
License URI:		https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: 		bwcs
Domain Path:		/languages
*/


if ( ! defined( 'ABSPATH' )){
    exit();
}

/***************************************************
	Create a Coming Soon Page on Activation
***************************************************/
if ( ! function_exists( 'bw_create_coming_soon_page' ) ) {
	
	function bw_create_coming_soon_page(){

		if ( ! bw_coming_soon_if_page_exists( 'coming-soon' ) ) {

			$args = array(

				'post_title' 	=> 'Coming Soon / Maintenance Page',
				'post_name' 	=> 'coming-soon',
				'post_content' 	=> 'This is an auto-generated coming soon/maintenance page, You can update this page as you like it, you can use your favorite page builder to design this page. You also can use any other page as a coming soon/maintenance page.',
				'post_status'   => 'publish',
				'post_type'     => 'page',

			);

			wp_insert_post( $args , false );
			
		}

	}	    

	register_activation_hook( __FILE__ , 'bw_create_coming_soon_page' );

}

// Plugin basename
define( 'BWCS_PLUGIN_BASENAME' , plugin_basename(__FILE__) );


//Add Necessary Files
require_once( plugin_dir_path( __FILE__ ) . 'includes/helper-functions.php' );
require_once( plugin_dir_path( __FILE__ ) . 'includes/plugin-settings.php' );
if ( is_admin() ) {
    require_once( plugin_dir_path( __FILE__ ) . 'admin/settings-page.php' );
}