<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Wyrd_Northwest
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

        <?php
        // --- DEBUG START ---
        global $wp_query; // Make the global $wp_query object available
        echo '';
        if ( is_tax( 'comic_series' ) ) {
            echo '';
        }
        if ( is_tax( 'comic_issues' ) ) {
            echo '';
        }
        echo '';
        echo '';
        // --- DEBUG END ---


        if ( have_posts() ) : ?>

            <header class="page-header">
                <?php
                    the_archive_title( '<h1 class="page-title">', '</h1>' );
                    the_archive_description( '<div class="archive-description">', '</div>' );
                ?>
            </header><?php
            /* Start the Loop */
            while ( have_posts() ) : the_post();

                // --- DEBUG START ---
                echo '';
                // --- DEBUG END ---

                /*
                 * Include the Post-Type-specific template for the content.
                 * If you want to customize how 'comic' posts look on archives,
                 * you might create a 'content-comic.php' file.
                 * For now, this will use content.php or content-none.php
                 */
                get_template_part( 'template-parts/content', get_post_type() );

            endwhile;

            the_posts_navigation();

        else :
            // --- DEBUG START ---
            echo '';
            // --- DEBUG END ---
            get_template_part( 'template-parts/content', 'none' );

        endif; ?>

        </main></div><?php
get_sidebar();
get_footer();