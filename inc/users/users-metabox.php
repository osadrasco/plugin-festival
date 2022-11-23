<?php
/**
 * Custom fields for Users edit
 * @author Dansp <https://t.me/dansp89>
*/
defined('ABSPATH') || die ( 'You have no power here!' );

if( !function_exists('dsp_metabox_users')){
    add_action( 'cmb2_admin_init', 'dsp_metabox_users' );
    /**
     * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
     */
    function dsp_metabox_users() {
    	/**
    	 * Sample metabox to demonstrate each field type included
    	 */
    	$cmb_user = new_cmb2_box( array(
    		'id'               => 'yourprefix_user_edit',
    		'title'            => esc_html__( 'User Profile Metabox', 'dsp_dashboard' ), // Doesn't output for user boxes
    		'object_types'     => array( 'user' ), // Tells CMB2 to use user_meta vs post_meta
    		'show_names'       => true,
    		'new_user_section' => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
    	) );
    
    	$cmb_user->add_field( array(
    		'name'     => esc_html__( 'Informaçoes extras', 'dsp_dashboard' ),
    		'id'       => 'user_extras_info',
    		'type'     => 'title',
    		'on_front' => false,
    	) );
        $cmb_user->add_field( array(
    		'name'    => esc_html__( 'CPF', 'dsp_dashboard' ),
    		'id'      => 'user_cpf',
    		'type'    => 'text',
    		'attributes'    => array(
    		    'class' => 'cpf',
    		    'placeholder' => "CPF do usuário"
    		)
    	) );
        $cmb_user->add_field( array(
    		'name'    => esc_html__( 'Lojas compradas', 'dsp_dashboard' ),
    		'id'      => 'lojas_compradas',
    		'type'    => 'text',
    		'attributes'    => array(
    		  //  'readonly'  => 'readonly',
    		),
    		'repeatable'      => true,
    	) );
    }
}