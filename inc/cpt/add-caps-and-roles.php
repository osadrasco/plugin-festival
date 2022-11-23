<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || die( 'You have no power here!' );


/**
 * ADD CAPS TO ROLES
 * @source capabilities <https://wordpress.org/support/article/roles-and-capabilities/#upload_files>
*/
add_action('admin_init', function () {
    if ( !function_exists( 'populate_roles' ) ) {
      require_once( ABSPATH . 'wp-admin/includes/schema.php' );
    }
    populate_roles();
    
    $role = get_role('lojista');
    if( $role != null ){
        // $role->add_cap( 'edit_lgpd');
    }
}, 12 );