<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package ComixCore
 */

/**
 * Adds custom classes to the body tag to indicate WP's version and customizer settings.
 *
 * @param array $classes Classes for the body tag.
 * @return array
 */
function comixcore_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'comixcore_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function comixcore_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'comixcore_pingback_header' );