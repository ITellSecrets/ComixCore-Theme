/**
 * This file is for live previewing changes made in the WordPress Customizer.
 * It should be saved as `js/customizer-preview.js` in your theme directory.
 */

(function( $ ) {
    wp.customize( 'comixcore_primary_color', function( value ) {
        value.bind( function( newval ) {
            // Update the CSS variable in the live preview
            document.documentElement.style.setProperty('--comixcore-primary-color', newval);
        } );
    } );

    wp.customize( 'comixcore_primary_hover_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty('--comixcore-primary-hover-color', newval);
        } );
    } );

    wp.customize( 'comixcore_body_text_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty('--comixcore-body-text-color', newval);
        } );
    } );

    wp.customize( 'comixcore_heading_text_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty('--comixcore-heading-text-color', newval);
        } );
    } );

    // Live preview for Site Background Color
    wp.customize( 'comixcore_site_background_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty('--comixcore-site-background-color', newval);
        } );
    } );

    wp.customize( 'comixcore_content_background_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty('--comixcore-content-background-color', newval);
        } );
    } );

    wp.customize( 'comixcore_header_background_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty('--comixcore-header-background-color', newval);
        } );
    } );

    wp.customize( 'comixcore_header_text_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty('--comixcore-header-text-color', newval);
        } );
    } );

    wp.customize( 'comixcore_nav_background_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty('--comixcore-nav-background-color', newval);
        } );
    } );

    wp.customize( 'comixcore_nav_link_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty('--comixcore-nav-link-color', newval);
        } );
    } );

    wp.customize( 'comixcore_nav_link_hover_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty('--comixcore-nav-link-hover-color', newval);
        } );
    } );

    wp.customize( 'comixcore_nav_link_hover_bg_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty('--comixcore-nav-link-hover-bg-color', newval);
        } );
    } );

    wp.customize( 'comixcore_footer_background_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty('--comixcore-footer-background-color', newval);
        } );
    } );

    wp.customize( 'comixcore_footer_text_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty('--comixcore-footer-text-color', newval);
        } );
    } );

})( jQuery );