<?php
/**
 * Template part for displaying a single comic post within a loop.
 * This file should NOT contain its own WordPress loop (e.g., while(have_posts())).
 * It is called by taxonomy-comic_series.php for each comic found.
 *
 * @package Wyrd_Northwest
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        // Display the post title, linked to the individual comic post
        the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        ?>
    </header><div class="entry-content">
        <?php
        // Display the featured image (which should be your main comic image)
        if ( has_post_thumbnail() ) {
            the_post_thumbnail( 'full' ); // 'full' displays the original image size. You might want a different size later.
        }

        // You can add the comic's excerpt or full content here if needed
        // the_excerpt(); // Uncomment if you want to show a short summary
        // the_content(); // Uncomment if you want to show the full post content
        ?>
    </div><footer class="entry-footer">
        <?php
        // Optionally display the date the comic was posted
        echo '<span class="posted-on">Posted on: ' . get_the_date() . '</span>';

        // Optionally display the series terms the comic belongs to
        $terms = get_the_terms( get_the_ID(), 'comic_series' );
        if ( $terms && ! is_wp_error( $terms ) ) :
            $series_names = array();
            foreach ( $terms as $term ) {
                $series_names[] = '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
            }
            echo '<span class="series-terms">Series: ' . implode( ', ', $series_names ) . '</span>';
        endif;
        ?>
    </footer></article>