<?php
/**
 * ComixCore functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ComixCore
 */

if ( ! function_exists( 'comixcore_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function comixcore_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme for public use, then include a text domain.
         */
        load_theme_textdomain( 'comixcore', get_template_directory() . '/languages' );

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
            'primary' => esc_html__( 'Primary', 'comixcore' ),
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
        add_theme_support( 'custom-background', apply_filters( 'comixcore_custom_background_args', array(
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
add_action( 'after_setup_theme', 'comixcore_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * @global int $content_width
 */
function comixcore_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'comixcore_content_width', 640 );
}
add_action( 'after_setup_theme', 'comixcore_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function comixcore_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'comixcore' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'comixcore' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'comixcore_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function comixcore_scripts() {
    wp_enqueue_style( 'comixcore-style', get_stylesheet_uri() );

    wp_enqueue_script( 'comixcore-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

    wp_enqueue_script( 'comixcore-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'comixcore_scripts' );

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

// Ensure this code is wrapped in a function and hooked correctly.

/**
 * Sets up custom logo support for the theme.
 * This needs to run early in the theme setup process.
 */
function comixcore_custom_logo_setup() {
    add_theme_support( 'custom-logo', array(
        'height'      => 256, // Adjust to your logo's height
        'width'       => 256, // Adjust to your logo's width
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    ) );
}
add_action( 'after_setup_theme', 'comixcore_custom_logo_setup' );


/**
 * Sets the default custom logo upon theme activation.
 * This runs ONLY when the theme is activated for the first time.
 */
function comixcore_set_default_logo_on_activation() {
    // A flag to ensure this setup only runs once per theme activation.
    // This prevents re-uploading the logo or overriding user's changes if theme is deactivated/reactivated.
    if ( get_option( 'comixcore_default_logo_set' ) ) {
        return; // Default logo already set, do nothing.
    }

    // Define the path to your default logo image within your theme folder.
    $default_logo_path = get_template_directory() . '/images/comixcore-logo.png';

    // Check if the logo file exists in the theme.
    if ( file_exists( $default_logo_path ) ) {

        // Prepare file data for WordPress media handling.
        $filename = basename( $default_logo_path );

        // This function handles copying the file to the uploads directory
        // and sanitizing the filename.
        $upload_file = wp_upload_bits( $filename, null, file_get_contents( $default_logo_path ) );

        if ( ! $upload_file['error'] ) {
            // Include necessary WordPress files for media handling functions.
            // These are only needed when you're programmatically handling media.
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
            require_once( ABSPATH . 'wp-admin/includes/media.php' );

            // Define attachment properties for inserting into the Media Library.
            $wp_filetype = wp_check_filetype( $filename, null );
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title'     => sanitize_file_name( $filename ),
                'post_content'   => '',
                'post_status'    => 'inherit',
                'guid'           => $upload_file['url'] // The URL to the image, crucial for database reference.
            );

            // Insert the attachment (image) into the WordPress database.
            $attach_id = wp_insert_attachment( $attachment, $upload_file['file'] );

            // Generate metadata (like image sizes) for the attachment and update the database record.
            $attach_data = wp_generate_attachment_metadata( $attach_id, $upload_file['file'] );
            wp_update_attachment_metadata( $attach_id, $attach_data );

            // Finally, set the theme modification ('custom_logo') to the newly obtained attachment ID.
            set_theme_mod( 'custom_logo', $attach_id );

            // Also, set the 'display_site_title_tagline' to false by default,
            // so the logo is shown instead of text.
            set_theme_mod( 'display_site_title_tagline', false );

            // Set a flag in the options table to mark that the default logo has been set.
            // This prevents the function from running again unnecessarily.
            update_option( 'comixcore_default_logo_set', true );

        } else {
            // Log any errors if the file upload itself fails.
            error_log( 'ComixCore Theme: Error uploading default logo: ' . $upload_file['error'] );
        }
    } else {
        // Log an error if the default logo file is not found in the theme directory.
        error_log( 'ComixCore Theme: Default logo file not found at ' . $default_logo_path );
    }
}
add_action( 'after_switch_theme', 'comixcore_set_default_logo_on_activation' );