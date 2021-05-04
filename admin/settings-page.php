<?php
class BWCS_Settings_Page{
    public function __construct() {
        add_action( 'admin_menu' , array( $this , 'bwcs_create_settings_page' ) );
        add_action( 'admin_post_bwcs_admin_page' , array( $this , 'bwcs_save_form' ) );
        add_filter( 'plugin_action_links_bw-coming-soon-page/coming-soon-page.php' , array( $this , 'bwcs_add_settings_link' ) );
    }

    public function bwcs_create_settings_page(){
        $page_title = __( 'Coming Soon Page' , 'bwcs' );
        $menu_title = __( 'Coming Soon Page' , 'bwcs' );
        $capability = 'manage_options';
        $slug       = 'bwcs_page';
        $callback   = array( $this, 'bwcs_page_content' );
        add_options_page( $page_title, $menu_title, $capability, $slug, $callback );
    }

    public function bwcs_page_content(){
        require_once plugin_dir_path( __FILE__ )."/form.php";
    }


    public function bwcs_save_form(){

        check_admin_referer( "bwcs_settings" );

        // Get values from user
        $enable_value       = isset( $_POST['bwcs_enable_plugin'] ) ? 1 : 0;
        $coming_soon_page   = sanitize_text_field( $_POST['bwcs_coming_soon_page'] );
        $roles              = isset( $_POST['bwcs_roles'] ) ? $_POST['bwcs_roles'] : array();
        $pages              = isset( $_POST['bwcs_other_pages'] ) ? $_POST['bwcs_other_pages'] : array();


        // Save Enable/Disable plugin        
        update_option( 'bwcs_enable_plugin' , $enable_value );

        // Save coming soon page
        update_option( 'bwcs_coming_soon_page' , $coming_soon_page );

        // Save Roles who can see other pages
        update_option( 'bwcs_roles' , $roles );

        // Save other pages that will be shown along with coming soon page
        update_option( 'bwcs_other_pages' , $pages );


        wp_redirect( admin_url( 'options-general.php?page=bwcs_page' ) );

    }

    public function bwcs_add_settings_link( $links ) {
        $newlink = sprintf( "<a href='%s'>%s</a>" , admin_url( 'options-general.php?page=bwcs_page' ) , __( 'Settings' , 'bwcs' ) );
        $links[] = $newlink;
        return $links;
    }

}

new BWCS_Settings_Page();