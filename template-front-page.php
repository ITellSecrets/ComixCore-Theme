<?php
/**
 * Template Name: Custom Front Page Layout
 * Description: A custom template for the homepage, designed to display
 * content directly created using WordPress blocks (e.g., Columns Block)
 * with an embedded logo image.
 *
 * @package ComixCore
 */

get_header(); // Loads the theme's header.php ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <?php
                            // Display the page title (e.g., "Howdy, traveler.")
                            the_title( '<h1 class="entry-title">', '</h1>' );
                            ?>
                        </header><div class="entry-content">
                            <?php
                            // Display the full content of the page, including all your blocks.
                            // The column layout, intro text, and image are now handled by your page content.
                            the_content();
                            ?>
                        </div></article><?php
                endwhile;
            else :
                // Fallback: If no page content is found, include content-none.php
                get_template_part( 'template-parts/content', 'none' );
            endif;
            ?>

        </main></div><?php
get_footer(); // Loads the theme's footer.php