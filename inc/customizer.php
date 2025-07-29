<?php
/**
 * Implement the WordPress Customizer functionality for theme colors.
 * This file should be saved as `inc/customizer.php` in your theme directory.
 */

// This function registers all customizer settings and controls.
function comixcore_customize_register( $wp_customize ) {

    // --- Section: Theme Colors ---
    $wp_customize->add_section( 'comixcore_colors_section', array(
        'title'    => __( 'Theme Colors', 'comixcore' ),
        'priority' => 30,
    ) );

    // Setting: Primary Color (e.g., for links, buttons)
    $wp_customize->add_setting( 'comixcore_primary_color', array(
        'default'           => '#0073aa', // WordPress default blue
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage', // Live preview
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'comixcore_primary_color', array(
        'label'    => __( 'Primary Accent Color', 'comixcore' ),
        'section'  => 'comixcore_colors_section',
    ) ) );

    // Setting: Primary Hover Color
    $wp_customize->add_setting( 'comixcore_primary_hover_color', array(
        'default'           => '#005a8d', // Darker blue for hover
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'comixcore_primary_hover_color', array(
        'label'    => __( 'Primary Accent Hover Color', 'comixcore' ),
        'section'  => 'comixcore_colors_section',
    ) ) );

    // Setting: Body Text Color
    $wp_customize->add_setting( 'comixcore_body_text_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'comixcore_body_text_color', array(
        'label'    => __( 'Body Text Color', 'comixcore' ),
        'section'  => 'comixcore_colors_section',
    ) ) );

    // Setting: Heading Text Color
    $wp_customize->add_setting( 'comixcore_heading_text_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'comixcore_heading_text_color', array(
        'label'    => __( 'Heading Text Color', 'comixcore' ),
        'section'  => 'comixcore_colors_section',
    ) ) );

    // Site Background Color setting, now managed by our custom section.
    $wp_customize->add_setting( 'comixcore_site_background_color', array(
        'default'           => '#f0f2f5',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'comixcore_site_background_color', array(
        'label'    => __( 'Site Background Color', 'comixcore' ),
        'section'  => 'comixcore_colors_section',
    ) ) );

    // Setting: Content Area Background Color
    $wp_customize->add_setting( 'comixcore_content_background_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'comixcore_content_background_color', array(
        'label'    => __( 'Content Area Background Color', 'comixcore' ),
        'section'  => 'comixcore_colors_section',
    ) ) );

    // Setting: Header Background Color
    $wp_customize->add_setting( 'comixcore_header_background_color', array(
        'default'           => '#222222',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'comixcore_header_background_color', array(
        'label'    => __( 'Header Background Color', 'comixcore' ),
        'section'  => 'comixcore_colors_section',
    ) ) );

    // Setting: Header Text Color
    $wp_customize->add_setting( 'comixcore_header_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'comixcore_header_text_color', array(
        'label'    => __( 'Header Text Color', 'comixcore' ),
        'section'  => 'comixcore_colors_section',
    ) ) );

    // Setting: Navigation Background Color
    $wp_customize->add_setting( 'comixcore_nav_background_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'comixcore_nav_background_color', array(
        'label'    => __( 'Navigation Background Color', 'comixcore' ),
        'section'  => 'comixcore_colors_section',
    ) ) );

    // Setting: Navigation Link Color
    $wp_customize->add_setting( 'comixcore_nav_link_color', array(
        'default'           => '#eeeeee',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'comixcore_nav_link_color', array(
        'label'    => __( 'Navigation Link Color', 'comixcore' ),
        'section'  => 'comixcore_colors_section',
    ) ) );

    // Setting: Navigation Link Hover Color
    $wp_customize->add_setting( 'comixcore_nav_link_hover_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'comixcore_nav_link_hover_color', array(
        'label'    => __( 'Navigation Link Hover Color', 'comixcore' ),
        'section'  => 'comixcore_colors_section',
    ) ) );

    // Setting: Navigation Link Hover Background Color
    $wp_customize->add_setting( 'comixcore_nav_link_hover_bg_color', array(
        'default'           => '#555555',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'comixcore_nav_link_hover_bg_color', array(
        'label'    => __( 'Navigation Link Hover Background Color', 'comixcore' ),
        'section'  => 'comixcore_colors_section',
    ) ) );

    // Setting: Footer Background Color
    $wp_customize->add_setting( 'comixcore_footer_background_color', array(
        'default'           => '#222222',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'comixcore_footer_background_color', array(
        'label'    => __( 'Footer Background Color', 'comixcore' ),
        'section'  => 'comixcore_colors_section',
    ) ) );

    // Setting: Footer Text Color
    $wp_customize->add_setting( 'comixcore_footer_text_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'comixcore_footer_text_color', array(
        'label'    => __( 'Footer Text Color', 'comixcore' ),
        'section'  => 'comixcore_colors_section',
    ) ) );
}
add_action( 'customize_register', 'comixcore_customize_register' );


// --- Output Customizer CSS as CSS Variables ---
// This function is now correctly placed outside the customize_register function
// to ensure it runs on every page load and outputs the dynamic CSS variables.
function comixcore_customize_css() {
    ?>
    <style type="text/css">
        :root {
            --comixcore-primary-color: <?php echo get_theme_mod( 'comixcore_primary_color', '#0073aa' ); ?>;
            --comixcore-primary-hover-color: <?php echo get_theme_mod( 'comixcore_primary_hover_color', '#005a8d' ); ?>;
            --comixcore-body-text-color: <?php echo get_theme_mod( 'comixcore_body_text_color', '#333333' ); ?>;
            --comixcore-heading-text-color: <?php echo get_theme_mod( 'comixcore_heading_text_color', '#333333' ); ?>;
            --comixcore-site-background-color: <?php echo get_theme_mod( 'comixcore_site_background_color', '#f0f2f5' ); ?>;
            --comixcore-content-background-color: <?php echo get_theme_mod( 'comixcore_content_background_color', '#ffffff' ); ?>;
            --comixcore-header-background-color: <?php echo get_theme_mod( 'comixcore_header_background_color', '#222222' ); ?>;
            --comixcore-header-text-color: <?php echo get_theme_mod( 'comixcore_header_text_color', '#ffffff' ); ?>;
            --comixcore-nav-background-color: <?php echo get_theme_mod( 'comixcore_nav_background_color', '#333333' ); ?>;
            --comixcore-nav-link-color: <?php echo get_theme_mod( 'comixcore_nav_link_color', '#eeeeee' ); ?>;
            --comixcore-nav-link-hover-color: <?php echo get_theme_mod( 'comixcore_nav_link_hover_color', '#ffffff' ); ?>;
            --comixcore-nav-link-hover-bg-color: <?php echo get_theme_mod( 'comixcore_nav_link_hover_bg_color', '#555555' ); ?>;
            --comixcore-footer-background-color: <?php echo get_theme_mod( 'comixcore_footer_background_color', '#222222' ); ?>;
            --comixcore-footer-text-color: <?php echo get_theme_mod( 'comixcore_footer_text_color', '#ffffff' ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'comixcore_customize_css' );

// --- Live Preview (JavaScript) ---
// This function is also correctly placed outside the customize_register function
// to ensure it's always available for the Customizer preview.
function comixcore_customize_preview_js() {
    wp_enqueue_script( 'comixcore-customizer-preview', get_template_directory_uri() . '/js/customizer-preview.js', array( 'jquery', 'customize-preview' ), '20210412', true );
}
add_action( 'customize_preview_init', 'comixcore_customize_preview_js' );