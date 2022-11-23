<?php

defined("ABSPATH")|| die("You have no power here!");


/**
 * ADD ADMIN MENU DASHBOARD - MANAGER LGPD
*/
add_action( 'admin_menu', function(){
 
	add_menu_page(
		__('Manager LGPD', 'dsp_dashboard'), // page <title>Title</title>
		__('Manager LGPD', 'dsp_dashboard'), // link text
		'manage_options_lgpd', // user capabilities
		'dsp_manager_lgpd', // page slug
		'dsp_manager_lgpd_panel', // this function prints the page content
		'dashicons-lock', // icon (from Dashicons for example)
		4 // menu position
	);
	add_menu_page(
		__('Manager Process', 'dsp_dashboard'), // page <title>Title</title>
		__('Manager Process', 'dsp_dashboard'), // link text
		'manage_options_process', // user capabilities
		'dsp_manager_process', // page slug
		'dsp_manager_process_panel', // this function prints the page content
		'dashicons-lock', // icon (from Dashicons for example)
		4 // menu position
	);
	
}, 999);

/**
 * Adds a "My Page" link to the Toolbar.
 *
 * @param WP_Admin_Bar $wp_admin_bar Toolbar instance.
 */
function toolbar_link_to_mypage( $wp_admin_bar ) {
    // echo "<pre>";
    // print_r($wp_admin_bar);
    // echo "</pre>";
    
	if( in_array( "dsp_attendant", dsp_role_current_user() ) ) {
	    
	    $wp_admin_bar->remove_node('new-content');

    	if( !is_admin()){
    	    $args = array(
        		'id'    => 'dsp_admin',
        		'title' => __( 'Dashboard', 'dsp_dashboard' ),
        		'href'  => esc_url( admin_url() ),
        		'meta'  => array(
        			'class' => 'dsp-process-topbar'
        		)
        	);
        	$wp_admin_bar->add_node( $args );
    	}
	    
    	$args = array(
    		'id'    => 'dsp_manager',
    		'title' => __( 'LGPD', 'dsp_dashboard' ),
    		'href'  => esc_url( admin_url( 'admin.php?page=dsp_manager_lgpd' ) ),
    		'meta'  => array(
    			'class' => 'dsp-lgpd-topbar'
    		)
    	);
    	$wp_admin_bar->add_node( $args );
    	$args = array(
    		'id'    => 'dsp_process',
    		'title' => __( 'Process', 'dsp_dashboard' ),
    		'href'  => esc_url( admin_url( 'admin.php?page=dsp_manager_process' ) ),
    		'meta'  => array(
    			'class' => 'dsp-process-topbar'
    		)
    	);
    	$wp_admin_bar->add_node( $args );
	}
}
add_action( 'admin_bar_menu', 'toolbar_link_to_mypage', 999 );

/**
 * REMOVE ITEM MENU BUT NOT CONTENT
 * @source <https://wordpress.stackexchange.com/a/28784>
*/
function wpse28782_remove_plugin_admin_menu() {
    if( in_array( "dsp_attendant", dsp_role_current_user() ) ) :
        remove_menu_page('edit.php?post_type=dsp_lgpd');
        remove_menu_page('edit.php?post_type=dsp_process');
    endif;
}
add_action( 'admin_menu', 'wpse28782_remove_plugin_admin_menu', 9999 );
