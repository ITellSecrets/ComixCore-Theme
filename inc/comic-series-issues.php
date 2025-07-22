<?php
// Register Custom Post Type: Comic
function wyrd_northwest_register_comic_post_type() {
    $labels = array(
        'name'                  => _x( 'Comics', 'Post Type General Name', 'wyrdnorthwest' ),
        'singular_name'         => _x( 'Comic', 'Post Type Singular Name', 'wyrdnorthwest' ),
        'menu_name'             => _x( 'Comics', 'Admin Menu text', 'wyrdnorthwest' ),
        'name_admin_bar'        => _x( 'Comic', 'Add New on Toolbar', 'wyrdnorthwest' ),
        'archives'              => __( 'Comic Archives', 'wyrdnorthwest' ),
        'attributes'            => __( 'Comic Attributes', 'wyrdnorthwest' ),
        'parent_item_colon'     => __( 'Parent Comic:', 'wyrdnorthwest' ),
        'all_items'             => __( 'All Comics', 'wyrdnorthwest' ),
        'add_new_item'          => __( 'Add New Comic', 'wyrdnorthwest' ),
        'add_new'               => __( 'Add New', 'wyrdnorthwest' ),
        'new_item'              => __( 'New Comic', 'wyrdnorthwest' ),
        'edit_item'             => __( 'Edit Comic', 'wyrdnorthwest' ),
        'update_item'           => __( 'Update Comic', 'wyrdnorthwest' ),
        'view_item'             => __( 'View Comic', 'wyrdnorthwest' ),
        'view_items'            => __( 'View Comics', 'wyrdnorthwest' ),
        'search_items'          => __( 'Search Comic', 'wyrdnorthwest' ),
        'not_found'             => __( 'Not found', 'wyrdnorthwest' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'wyrdnorthwest' ),
        'featured_image'        => __( 'Featured Image', 'wyrdnorthwest' ),
        'set_featured_image'    => __( 'Set featured image', 'wyrdnorthwest' ),
        'remove_featured_image' => __( 'Remove featured image', 'wyrdnorthwest' ),
        'use_featured_image'    => __( 'Use as featured image', 'wyrdnorthwest' ),
        'insert_into_item'      => __( 'Insert into comic', 'wyrdnorthwest' ),
        'uploaded_to_this_item' => __( 'Uploaded to this comic', 'wyrdnorthwest' ),
        'items_list'            => __( 'Comics list', 'wyrdnorthwest' ),
        'items_list_navigation' => __( 'Comics list navigation', 'wyrdnorthwest' ),
        'filter_items_list'     => __( 'Filter comics list', 'wyrdnorthwest' ),
    );
    $args = array(
        'label'                 => __( 'Comic', 'wyrdnorthwest' ),
        'description'           => __( 'Custom post type for individual comic issues.', 'wyrdnorthwest' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-format-image',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'comics', // Slug for the archive page (e.g., yoursite.com/comics)
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Enable for Gutenberg editor and REST API
    );
    register_post_type( 'comic', $args );

    // Register Custom Taxonomy: Comic Series
    $labels = array(
        'name'                       => _x( 'Comic Series', 'Taxonomy General Name', 'wyrdnorthwest' ),
        'singular_name'              => _x( 'Comic Series', 'Taxonomy Singular Name', 'wyrdnorthwest' ),
        'menu_name'                  => __( 'Comic Series', 'wyrdnorthwest' ),
        'all_items'                  => __( 'All Series', 'wyrdnorthwest' ),
        'parent_item'                => __( 'Parent Series', 'wyrdnorthwest' ),
        'parent_item_colon'          => __( 'Parent Series:', 'wyrdnorthwest' ),
        'new_item_name'              => __( 'New Series Name', 'wyrdnorthwest' ),
        'add_new_item'               => __( 'Add New Series', 'wyrdnorthwest' ),
        'edit_item'                  => __( 'Edit Series', 'wyrdnorthwest' ),
        'update_item'                => __( 'Update Series', 'wyrdnorthwest' ),
        'view_item'                  => __( 'View Series', 'wyrdnorthwest' ),
        'separate_items_with_commas' => __( 'Separate series with commas', 'wyrdnorthwest' ),
        'add_or_remove_items'        => __( 'Add or remove series', 'wyrdnorthwest' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'wyrdnorthwest' ),
        'popular_items'              => __( 'Popular Series', 'wyrdnorthwest' ),
        'search_items'               => __( 'Search Series', 'wyrdnorthwest' ),
        'not_found'                  => __( 'Not Found', 'wyrdnorthwest' ),
        'no_terms'                   => __( 'No series', 'wyrdnorthwest' ),
        'items_list'                 => __( 'Series list', 'wyrdnorthwest' ),
        'items_list_navigation'      => __( 'Series list navigation', 'wyrdnorthwest' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true, // Make it like categories
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true, // Enable for Gutenberg and REST API
        'rewrite'                    => array( 'slug' => 'comic-series' ), // Custom slug for taxonomy archive
    );
    register_taxonomy( 'comic_series', array( 'comic' ), $args ); // Associate with 'comic' post type
}
add_action( 'init', 'wyrd_northwest_register_comic_post_type' );