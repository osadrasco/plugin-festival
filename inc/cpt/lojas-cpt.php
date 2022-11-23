<?php

defined("ABSPATH")|| die("You have no power here!");

// Register Custom Post Type
add_action( 'init', function() {

	$labels = array(
		'name'                  => _x( 'lojas - requests', 'Post Type General Name', 'dsp_dashboard' ),
		'singular_name'         => _x( 'lojas - request', 'Post Type Singular Name', 'dsp_dashboard' ),
		'menu_name'             => __( 'lojas', 'dsp_dashboard' ),
		'name_admin_bar'        => __( 'lojas', 'dsp_dashboard' ),
		'archives'              => __( 'Item Archives', 'dsp_dashboard' ),
		'attributes'            => __( 'Item Attributes', 'dsp_dashboard' ),
		'parent_item_colon'     => __( 'Parent Item:', 'dsp_dashboard' ),
		'all_items'             => __( 'All Requests', 'dsp_dashboard' ),
		'add_new_item'          => __( 'Add New lojas request', 'dsp_dashboard' ),
		'add_new'               => __( 'Add New', 'dsp_dashboard' ),
		'new_item'              => __( 'New lojas request', 'dsp_dashboard' ),
		'edit_item'             => __( 'Edit lojas request', 'dsp_dashboard' ),
		'update_item'           => __( 'Update lojas request', 'dsp_dashboard' ),
		'view_item'             => __( 'View lojas request', 'dsp_dashboard' ),
		'view_items'            => __( 'View lojas requests', 'dsp_dashboard' ),
		'search_items'          => __( 'Search lojas request', 'dsp_dashboard' ),
		'not_found'             => __( 'Not found', 'dsp_dashboard' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'dsp_dashboard' ),
		'featured_image'        => __( 'Featured Image', 'dsp_dashboard' ),
		'set_featured_image'    => __( 'Set featured image', 'dsp_dashboard' ),
		'remove_featured_image' => __( 'Remove featured image', 'dsp_dashboard' ),
		'use_featured_image'    => __( 'Use as featured image', 'dsp_dashboard' ),
		'insert_into_item'      => __( 'Insert into item', 'dsp_dashboard' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'dsp_dashboard' ),
		'items_list'            => __( 'Items list', 'dsp_dashboard' ),
		'items_list_navigation' => __( 'Items list navigation', 'dsp_dashboard' ),
		'filter_items_list'     => __( 'Filter items list', 'dsp_dashboard' ),
	);
	$args = array(
		'label'                 => __( 'lojas - request', 'dsp_dashboard' ),
		'description'           => __( 'List of data request calls', 'dsp_dashboard' ),
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-lock',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
// 		'query_var'             => 'dsp_lojas',
		// 'capability_type'     	=> array( 'edit_lojas','post'),
// 		'show_in_rest'          => false,
// 		'capabilities'          => array(
// 			'edit_post'			    => 'edit_lojas',
// 			'edit_posts'		    => 'edit_lojass',
// 			'edit_others_posts'	    => 'edit_others_lojas',
// 			'edit_published_posts'  => 'edit_published_lojas',
// 			'manage_options'	    => 'manage_options_lojas',
// 			'create_posts'          => false,
// 		),
// 		'map_meta_cap'			=> true,
	);
	register_post_type( 'lojas_festival', $args );
}, 99 );
