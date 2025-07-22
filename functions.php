<?php
/**
 * Wyrd Northwest functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Wyrd_Northwest
 */

if ( ! function_exists( 'wyrdnorthwest_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function wyrdnorthwest_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme for public use, then include a text domain.
         */
        load_theme_textdomain( 'wyrdnorthwest', get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnail-support/
         */
        add_theme_support( 'post-thumbnails' );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary' => esc_html__( 'Primary', 'wyrdnorthwest' ),
        ) );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        // Set up the WordPress core custom background feature.
        add_theme_support( 'custom-background', apply_filters( 'wyrdnorthwest_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        ) ) );

        // Add theme support for selective refresh for widgets in Customizer.
        add_theme_support( 'customize-selective-refresh-widgets' );

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support( 'custom-logo', array(
            'height'      => 250,
            'width'       => 250,
            'flex-width'  => true,
            'flex-height' => true,
        ) );
    }
endif;
add_action( 'after_setup_theme', 'wyrdnorthwest_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * @global int $content_width
 */
function wyrdnorthwest_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'wyrdnorthwest_content_width', 640 );
}
add_action( 'after_setup_theme', 'wyrdnorthwest_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wyrdnorthwest_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'wyrdnorthwest' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'wyrdnorthwest' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'wyrdnorthwest_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wyrdnorthwest_scripts() {
    wp_enqueue_style( 'wyrdnorthwest-style', get_stylesheet_uri() );

    wp_enqueue_script( 'wyrdnorthwest-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

    wp_enqueue_script( 'wyrdnorthwest-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'wyrdnorthwest_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php'; // Ensure extras.php exists and is included

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * ----------------------------------------------------------------------------------------------------
 * Custom Post Type and Taxonomies for Comics
 * ----------------------------------------------------------------------------------------------------
 */

// Register Custom Post Type: Comic Page
function wyrdnorthwest_register_comic_post_type() {
    $labels = array(
        'name'                  => _x( 'Comics', 'Post Type General Name', 'wyrdnorthwest' ),
        'singular_name'         => _x( 'Comic', 'Post Type Singular Name', 'wyrdnorthwest' ),
        'menu_name'             => __( 'Comics', 'wyrdnorthwest' ),
        'name_admin_bar'        => __( 'Comic', 'wyrdnorthwest' ),
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
        'featured_image'        => __( 'Comic Page Image', 'wyrdnorthwest' ),
        'set_featured_image'    => __( 'Set comic page image', 'wyrdnorthwest' ),
        'remove_featured_image' => __( 'Remove comic page image', 'wyrdnorthwest' ),
        'use_featured_image'    => __( 'Use as comic page image', 'wyrdnorthwest' ),
        'insert_into_item'      => __( 'Insert into comic', 'wyrdnorthwest' ),
        'uploaded_to_this_item' => __( 'Uploaded to this comic', 'wyrdnorthwest' ),
        'items_list'            => __( 'Comics list', 'wyrdnorthwest' ),
        'items_list_navigation' => __( 'Comics list navigation', 'wyrdnorthwest' ),
        'filter_items_list'     => __( 'Filter comics list', 'wyrdnorthwest' ),
    );
    $args = array(
        'label'                 => __( 'Comic', 'wyrdnorthwest' ),
        'description'           => __( 'Comic page content', 'wyrdnorthwest' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'page-attributes' ), // 'page-attributes' for menu_order
        'taxonomies'            => array( 'comic_series', 'comic_issues' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-format-image',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false, // Comics themselves don't have an archive to avoid listing all individual pages
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'rewrite'               => array( 'slug' => 'comic-page', 'with_front' => false ),
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Enable for Gutenberg/REST API
    );
    register_post_type( 'comic', $args );
}
add_action( 'init', 'wyrdnorthwest_register_comic_post_type', 0 );

// Register Custom Taxonomy: Comic Series
function wyrdnorthwest_register_comic_series_taxonomy() {
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
        'choose_from_most_used'      => __( 'Choose from the most used series', 'wyrdnorthwest' ),
        'popular_items'              => __( 'Popular Series', 'wyrdnorthwest' ),
        'search_items'               => __( 'Search Series', 'wyrdnorthwest' ),
        'not_found'                  => __( 'Not Found', 'wyrdnorthwest' ),
        'no_terms'                   => __( 'No series', 'wyrdnorthwest' ),
        'items_list'                 => __( 'Series list', 'wyrdnorthwest' ),
        'items_list_navigation'      => __( 'Series list navigation', 'wyrdnorthwest' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true, // Series can have a hierarchy if needed
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'rewrite'                    => array( 'slug' => 'comic-series', 'with_front' => false, 'hierarchical' => true ),
        'show_in_rest'               => true, // Enable for Gutenberg/REST API
    );
    register_taxonomy( 'comic_series', array( 'comic' ), $args );
}
add_action( 'init', 'wyrdnorthwest_register_comic_series_taxonomy', 0 );

// Register Custom Taxonomy: Comic Issues
function wyrdnorthwest_register_comic_issues_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Comic Issues', 'Taxonomy General Name', 'wyrdnorthwest' ),
        'singular_name'              => _x( 'Comic Issue', 'Taxonomy Singular Name', 'wyrdnorthwest' ),
        'menu_name'                  => __( 'Comic Issues', 'wyrdnorthwest' ),
        'all_items'                  => __( 'All Issues', 'wyrdnorthwest' ),
        'parent_item'                => __( 'Parent Issue', 'wyrdnorthwest' ),
        'parent_item_colon'          => __( 'Parent Issue:', 'wyrdnorthwest' ),
        'new_item_name'              => __( 'New Issue Name', 'wyrdnorthwest' ),
        'add_new_item'               => __( 'Add New Issue', 'wyrdnorthwest' ),
        'edit_item'                  => __( 'Edit Issue', 'wyrdnorthwest' ),
        'update_item'                => __( 'Update Issue', 'wyrdnorthwest' ),
        'view_item'                  => __( 'View Issue', 'wyrdnorthwest' ),
        'separate_items_with_commas' => __( 'Separate issues with commas', 'wyrdnorthwest' ),
        'add_or_remove_items'        => __( 'Add or remove issues', 'wyrdnorthwest' ),
        'choose_from_most_used'      => __( 'Choose from the most used issues', 'wyrdnorthwest' ),
        'popular_items'              => __( 'Popular Issues', 'wyrdnorthwest' ),
        'search_items'               => __( 'Search Issues', 'wyrdnorthwest' ),
        'not_found'                  => __( 'Not Found', 'wyrdnorthwest' ),
        'no_terms'                   => __( 'No issues', 'wyrdnorthwest' ),
        'items_list'                 => __( 'Issues list', 'wyrdnorthwest' ),
        'items_list_navigation'      => __( 'Issues list navigation', 'wyrdnorthwest' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true, // Issues can have a hierarchy if needed (e.g., volumes > issues)
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'rewrite'                    => array( 'slug' => 'comic-issue', 'with_front' => false, 'hierarchical' => true ),
        'show_in_rest'               => true, // Enable for Gutenberg/REST API
    );
    register_taxonomy( 'comic_issues', array( 'comic' ), $args );
}
add_action( 'init', 'wyrdnorthwest_register_comic_issues_taxonomy', 0 );


/**
 * ----------------------------------------------------------------------------------------------------
 * Custom Meta Box for Comic Post Type (Comic Page Details)
 * ----------------------------------------------------------------------------------------------------
 */

// 1. Add the meta box
function wyrdnorthwest_add_comic_meta_box() {
    add_meta_box(
        'comic_details_meta_box', // Unique ID
        __( 'Comic Details', 'wyrdnorthwest' ), // Box title
        'wyrdnorthwest_comic_meta_box_callback', // Callback function to display the box content
        'comic', // Post type to display on
        'normal', // Context (e.g., 'normal', 'side', 'advanced')
        'high' // Priority (e.g., 'high', 'core', 'default', 'low')
    );
}
add_action( 'add_meta_boxes', 'wyrdnorthwest_add_comic_meta_box' );

// 2. Callback function to display the fields
function wyrdnorthwest_comic_meta_box_callback( $post ) {
    wp_nonce_field( 'wyrdnorthwest_save_comic_meta_box_data', 'wyrdnorthwest_comic_meta_box_nonce' );

    $comic_page_image_id = get_post_meta( $post->ID, '_comic_page_image_id', true );
    $comic_page_number = get_post_meta( $post->ID, '_comic_page_number', true );
    $comic_display_style = get_post_meta( $post->ID, '_comic_display_style', true );
    $next_comic_page_id = get_post_meta( $post->ID, '_next_comic_page_id', true );
    $previous_comic_page_id = get_post_meta( $post->ID, '_previous_comic_page_id', true );

    // Default display style if not set
    if ( empty( $comic_display_style ) ) {
        $comic_display_style = 'page_by_page'; // Default to page by page
    }

    // Output fields
    ?>
    <p>
        <label for="comic_page_image_id"><?php _e( 'Comic Page Image:', 'wyrdnorthwest' ); ?></label><br>
        <input type="hidden" id="comic_page_image_id" name="_comic_page_image_id" value="<?php echo esc_attr( $comic_page_image_id ); ?>">
        <div id="comic-page-image-preview">
            <?php if ( $comic_page_image_id ) : ?>
                <?php echo wp_get_attachment_image( $comic_page_image_id, 'medium' ); ?>
            <?php endif; ?>
        </div>
        <button type="button" class="upload-button button" data-field-id="comic_page_image_id" data-preview-id="comic-page-image-preview"><?php _e( 'Select Image', 'wyrdnorthwest' ); ?></button>
        <button type="button" class="remove-button button button-secondary" style="<?php echo $comic_page_image_id ? '' : 'display:none;'; ?>"><?php _e( 'Remove Image', 'wyrdnorthwest' ); ?></button>
    </p>

    <p>
        <label for="comic_page_number"><?php _e( 'Page Number:', 'wyrdnorthwest' ); ?></label><br>
        <input type="number" id="comic_page_number" name="_comic_page_number" value="<?php echo esc_attr( $comic_page_number ); ?>" min="1">
    </p>

    <p>
        <label for="comic_display_style"><?php _e( 'Display Style:', 'wyrdnorthwest' ); ?></label><br>
        <select id="comic_display_style" name="_comic_display_style">
            <option value="page_by_page" <?php selected( $comic_display_style, 'page_by_page' ); ?>><?php _e( 'Page by Page', 'wyrdnorthwest' ); ?></option>
            <option value="vertical_scroll" <?php selected( $comic_display_style, 'vertical_scroll' ); ?>><?php _e( 'Vertical Scroll', 'wyrdnorthwest' ); ?></option>
        </select>
    </p>

    <p>
        <label for="next_comic_page_id"><?php _e( 'Next Comic Page ID (Optional):', 'wyrdnorthwest' ); ?></label><br>
        <input type="number" id="next_comic_page_id" name="_next_comic_page_id" value="<?php echo esc_attr( $next_comic_page_id ); ?>">
        <p class="description">Enter the ID of the next comic page. Leave blank to automatically find based on menu order within the same issue.</p>
    </p>

    <p>
        <label for="previous_comic_page_id"><?php _e( 'Previous Comic Page ID (Optional):', 'wyrdnorthwest' ); ?></label><br>
        <input type="number" id="previous_comic_page_id" name="_previous_comic_page_id" value="<?php echo esc_attr( $previous_comic_page_id ); ?>">
        <p class="description">Enter the ID of the previous comic page. Leave blank to automatically find based on menu order within the same issue.</p>
    </p>
    <?php
}

// 3. Save the meta box data
function wyrdnorthwest_save_comic_meta_box_data( $post_id ) {
    // Check if our nonce is set.
    if ( ! isset( $_POST['wyrdnorthwest_comic_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['wyrdnorthwest_comic_meta_box_nonce'], 'wyrdnorthwest_save_comic_meta_box_data' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Sanitize and save custom fields.
    if ( isset( $_POST['_comic_page_image_id'] ) ) {
        update_post_meta( $post_id, '_comic_page_image_id', absint( $_POST['_comic_page_image_id'] ) );
    } else {
        delete_post_meta( $post_id, '_comic_page_image_id' );
    }

    if ( isset( $_POST['_comic_page_number'] ) ) {
        update_post_meta( $post_id, '_comic_page_number', absint( $_POST['_comic_page_number'] ) );
    }

    if ( isset( $_POST['_comic_display_style'] ) ) {
        update_post_meta( $post_id, '_comic_display_style', sanitize_text_field( $_POST['_comic_display_style'] ) );
    }

    if ( isset( $_POST['_next_comic_page_id'] ) ) {
        update_post_meta( $post_id, '_next_comic_page_id', absint( $_POST['_next_comic_page_id'] ) );
    } else {
        delete_post_meta( $post_id, '_next_comic_page_id' ); // Allow unsetting if desired
    }

    if ( isset( $_POST['_previous_comic_page_id'] ) ) {
        update_post_meta( $post_id, '_previous_comic_page_id', absint( $_POST['_previous_comic_page_id'] ) );
    } else {
        delete_post_meta( $post_id, '_previous_comic_page_id' ); // Allow unsetting if desired
    }
}
add_action( 'save_post', 'wyrdnorthwest_save_comic_meta_box_data' );


/**
 * ----------------------------------------------------------------------------------------------------
 * Custom Fields for Comic Series (Series Logo)
 * ----------------------------------------------------------------------------------------------------
 */

// 1. Add custom field for Series Logo Image to 'Add New Series' screen
function wyrd_northwest_add_comic_series_logo_field() {
    ?>
    <div class="form-field term-logo-wrap">
        <label for="series-logo"><?php _e( 'Series Logo', 'wyrdnorthwest' ); ?></label>
        <input type="hidden" id="series-logo-id" name="series_logo_id" value="">
        <div id="series-logo-preview" class="series-logo-preview">
            <?php // No image preview for new terms ?>
        </div>
        <button type="button" class="upload-button button" data-field-id="series-logo-id" data-preview-id="series-logo-preview"><?php _e( 'Upload/Add Image', 'wyrdnorthwest' ); ?></button>
        <button type="button" class="remove-button button button-secondary" style="display:none;"><?php _e( 'Remove Image', 'wyrdnorthwest' ); ?></button>
        <p class="description"><?php _e( 'Upload an image for the comic series logo.', 'wyrdnorthwest' ); ?></p>
    </div>
    <?php
}
add_action( 'comic_series_add_form_fields', 'wyrd_northwest_add_comic_series_logo_field', 10, 2 );

// 2. Add custom field for Series Logo Image to 'Edit Series' screen
function wyrd_northwest_edit_comic_series_logo_field( $term ) {
    $series_logo_id = get_term_meta( $term->term_id, 'series_logo_id', true );
    $series_logo_url = $series_logo_id ? wp_get_attachment_image_url( $series_logo_id, 'thumbnail' ) : ''; // Using 'thumbnail' for admin preview
    ?>
    <tr class="form-field term-logo-wrap">
        <th scope="row"><label for="series-logo"><?php _e( 'Series Logo', 'wyrdnorthwest' ); ?></label></th>
        <td>
            <input type="hidden" id="series-logo-id" name="series_logo_id" value="<?php echo esc_attr( $series_logo_id ); ?>">
            <div id="series-logo-preview" class="series-logo-preview">
                <?php if ( $series_logo_url ) : ?>
                    <img src="<?php echo esc_url( $series_logo_url ); ?>" style="max-width:150px; height:auto;" />
                <?php endif; ?>
            </div>
            <button type="button" class="upload-button button" data-field-id="series-logo-id" data-preview-id="series-logo-preview"><?php _e( 'Upload/Add Image', 'wyrdnorthwest' ); ?></button>
            <button type="button" class="remove-button button button-secondary" <?php echo $series_logo_id ? '' : 'style="display:none;"'; ?>><?php _e( 'Remove Image', 'wyrdnorthwest' ); ?></button>
            <p class="description"><?php _e( 'Upload an image for the comic series logo.', 'wyrdnorthwest' ); ?></p>
        </td>
    </tr>
    <?php
}
add_action( 'comic_series_edit_form_fields', 'wyrd_northwest_edit_comic_series_logo_field', 10, 2 );

// 3. Save the Series Logo Image field
function wyrd_northwest_save_comic_series_logo_field( $term_id ) {
    if ( isset( $_POST['series_logo_id'] ) ) {
        $logo_id = absint( $_POST['series_logo_id'] ); // Sanitize ID
        update_term_meta( $term_id, 'series_logo_id', $logo_id );
    }
}
add_action( 'create_comic_series', 'wyrd_northwest_save_comic_series_logo_field' );
add_action( 'edit_comic_series', 'wyrd_northwest_save_comic_series_logo_field' );

/**
 * ----------------------------------------------------------------------------------------------------
 * Custom Fields for Comic Issues (Issue Cover) - NEW CODE
 * ----------------------------------------------------------------------------------------------------
 */

// 1. Add custom field for Comic Issue Cover Image to 'Add New Issue' screen
function wyrd_northwest_add_comic_issue_cover_field() {
    ?>
    <div class="form-field term-cover-wrap">
        <label for="issue-cover-id"><?php _e( 'Issue Cover', 'wyrdnorthwest' ); ?></label>
        <input type="hidden" id="issue-cover-id" name="issue_cover_id" value="">
        <div id="issue-cover-preview" class="issue-cover-preview">
            <?php // No image preview for new terms ?>
        </div>
        <button type="button" class="upload-button button" data-field-id="issue-cover-id" data-preview-id="issue-cover-preview"><?php _e( 'Upload/Add Image', 'wyrdnorthwest' ); ?></button>
        <button type="button" class="remove-button button button-secondary" style="display:none;"><?php _e( 'Remove Image', 'wyrdnorthwest' ); ?></button>
        <p class="description"><?php _e( 'Upload an image for the issue cover.', 'wyrdnorthwest' ); ?></p>
    </div>
    <?php
}
add_action( 'comic_issues_add_form_fields', 'wyrd_northwest_add_comic_issue_cover_field', 10, 2 );

// 2. Add custom field for Comic Issue Cover Image to 'Edit Issue' screen
function wyrd_northwest_edit_comic_issue_cover_field( $term ) {
    $issue_cover_id = get_term_meta( $term->term_id, 'issue_cover_id', true );
    $issue_cover_url = $issue_cover_id ? wp_get_attachment_image_url( $issue_cover_id, 'thumbnail' ) : ''; // Using 'thumbnail' for admin preview
    ?>
    <tr class="form-field term-cover-wrap">
        <th scope="row"><label for="issue-cover-id"><?php _e( 'Issue Cover', 'wyrdnorthwest' ); ?></label></th>
        <td>
            <input type="hidden" id="issue-cover-id" name="issue_cover_id" value="<?php echo esc_attr( $issue_cover_id ); ?>">
            <div id="issue-cover-preview" class="issue-cover-preview">
                <?php if ( $issue_cover_url ) : ?>
                    <img src="<?php echo esc_url( $issue_cover_url ); ?>" style="max-width:150px; height:auto;" />
                <?php endif; ?>
            </div>
            <button type="button" class="upload-button button" data-field-id="issue-cover-id" data-preview-id="issue-cover-preview"><?php _e( 'Upload/Add Image', 'wyrdnorthwest' ); ?></button>
            <button type="button" class="remove-button button button-secondary" <?php echo $issue_cover_id ? '' : 'style="display:none;"'; ?>><?php _e( 'Remove Image', 'wyrdnorthwest' ); ?></button>
            <p class="description"><?php _e( 'Upload an image for the issue cover.', 'wyrdnorthwest' ); ?></p>
        </td>
    </tr>
    <?php
}
add_action( 'comic_issues_edit_form_fields', 'wyrd_northwest_edit_comic_issue_cover_field', 10, 2 );

// 3. Save the Comic Issue Cover Image field
function wyrd_northwest_save_comic_issue_cover_field( $term_id ) {
    if ( isset( $_POST['issue_cover_id'] ) ) {
        $cover_id = absint( $_POST['issue_cover_id'] ); // Sanitize ID
        update_term_meta( $term_id, 'issue_cover_id', $cover_id );
    }
}
add_action( 'create_comic_issues', 'wyrd_northwest_save_comic_issue_cover_field' );
add_action( 'edit_comic_issues', 'wyrd_northwest_save_comic_issue_cover_field' );


/**
 * ----------------------------------------------------------------------------------------------------
 * Enqueue Admin Scripts for Media Uploader (Updated for Series and Issues)
 * ----------------------------------------------------------------------------------------------------
 */

// 4. Enqueue WordPress media uploader and custom JS for admin screens
function wyrd_northwest_admin_enqueue_scripts() {
    // Only load on comic series or comic issues taxonomy edit/add screens
    $is_comic_series_screen = ( 'edit-tags.php' === $GLOBALS['pagenow'] && isset( $_GET['taxonomy'] ) && 'comic_series' === $_GET['taxonomy'] ) ||
                              ( 'term.php' === $GLOBALS['pagenow'] && isset( $_GET['taxonomy'] ) && 'comic_series' === $_GET['taxonomy'] );
    $is_comic_issues_screen = ( 'edit-tags.php' === $GLOBALS['pagenow'] && isset( $_GET['taxonomy'] ) && 'comic_issues' === $_GET['taxonomy'] ) ||
                              ( 'term.php' === $GLOBALS['pagenow'] && isset( $_GET['taxonomy'] ) && 'comic_issues' === $_GET['taxonomy'] );

    if ( $is_comic_series_screen || $is_comic_issues_screen ) {
        wp_enqueue_media(); // Enqueue WordPress media uploader scripts
        // Enqueue custom JS from js/media-uploader.js
        wp_enqueue_script( 'wyrd-northwest-media-uploader', get_template_directory_uri() . '/js/media-uploader.js', array( 'jquery' ), null, true );
    }
}
add_action( 'admin_enqueue_scripts', 'wyrd_northwest_admin_enqueue_scripts' );


/**
 * ----------------------------------------------------------------------------------------------------
 * Pre-get posts to ensure comic archive pages only show relevant posts
 * This filters the main query before it executes, adjusting posts_per_page and post_type
 * for specific archive views (e.g., comic_series, comic_issues).
 * ----------------------------------------------------------------------------------------------------
 */
function wyrdnorthwest_pre_get_posts_for_comics( $query ) {
    // Ensure this is the main query and not in the admin
    if ( ! is_admin() && $query->is_main_query() ) {
        // For 'comic_series' archives, we want to display issues, not individual comic posts in the main loop here.
        // The display logic for issues is handled directly in taxonomy-comic_series.php now,
        // so we can prevent the default post query for 'comic' posts on this page.
        if ( is_tax( 'comic_series' ) ) {
            // Set posts_per_page to 0 or some other value to prevent fetching actual posts
            // as the taxonomy-comic_series.php template will handle fetching issues directly.
            $query->set( 'posts_per_page', 1 ); // Fetching 1 post, just to satisfy `have_posts()` for the header, then we manually query issues.
            $query->set( 'post_type', 'comic' ); // Ensure it's still about comics for context, though we don't loop them
            return;
        }

        // For 'comic_issues' archives, ensure only 'comic' posts are queried
        // and order them by 'menu_order' for sequential pages.
        if ( is_tax( 'comic_issues' ) ) {
            $query->set( 'post_type', 'comic' );
            $query->set( 'orderby', 'menu_order' );
            $query->set( 'order', 'ASC');
            $query->set( 'posts_per_page', 1 ); // Only get the first comic for redirection
            return;
        }
    }
}
add_action( 'pre_get_posts', 'wyrdnorthwest_pre_get_posts_for_comics' );

// Allow redirects on taxonomy-comic_issues.php
// This might not be strictly necessary if wp_redirect is used before get_header(),
// but ensures headers aren't sent prematurely.
remove_action( 'template_redirect', 'redirect_canonical' );