<?php
/**
 * The template for displaying Comic Series archives.
 * This version is designed to display individual 'comic' posts belonging to the series,
 * without relying on Advanced Custom Fields (ACF) for content or relationships.
 *
 * @package Wyrd_Northwest
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

        <?php

        if ( have_posts() ) :
        ?>

            <header class="page-header">
                <?php
                    // Get the current comic_series term (e.g., "Outcasts of Pacifica")
                    $current_series = get_queried_object();
                    if ( $current_series && ! is_wp_error( $current_series ) ) {
                        echo '<h1 class="page-title">' . esc_html( $current_series->name ) . '</h1>';
                        if ( ! empty( $current_series->description ) ) {
                            echo '<div class="taxonomy-description">' . wp_kses_post( $current_series->description ) . '</div>';
                        }

                        // Get the series logo ID
                        $series_logo_id = get_term_meta( $current_series->term_id, 'series_logo_id', true );
                        // Get the image URL from the attachment ID
                        $series_logo_url = $series_logo_id ? wp_get_attachment_image_url( $series_logo_id, 'full' ) : ''; // 'full' for original size
                        // Get the image alt text from the attachment ID, or create a default
                        $series_logo_alt = $series_logo_id ? get_post_meta( $series_logo_id, '_wp_attachment_image_alt', true ) : '';
                        if ( empty( $series_logo_alt ) ) {
                            $series_logo_alt = $current_series->name . ' Logo';
                        }

                        if ( $series_logo_url ) {
                            echo '<div class="series-logo-container"><img src="' . esc_url( $series_logo_url ) . '" alt="' . esc_attr( $series_logo_alt ) . '" class="series-logo"></div>';
                        }

                    } else {
                        // Fallback if get_queried_object fails for some reason
                        the_archive_title( '<h1 class="page-title">', '</h1>' );
                        the_archive_description( '<div class="archive-description">', '</div>' );
                    }
                ?>
            </header>

            <div class="comic-issues-grid">
                <?php
                // --- START MODIFIED SECTION: Fetching only relevant comic issues ---
                // 1. Get IDs of 'comic' posts belonging to the current series
                $comic_post_ids_in_series = get_posts( array(
                    'post_type'      => 'comic',
                    'posts_per_page' => -1, // Get all posts
                    'fields'         => 'ids', // Only get post IDs for efficiency
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'comic_series',
                            'field'    => 'slug',
                            'terms'    => $current_series->slug,
                        ),
                    ),
                    'post_status'    => 'publish', // Only published comics
                ) );

                $issue_terms = array(); // Initialize an empty array for our issues

                if ( ! empty( $comic_post_ids_in_series ) ) {
                    // 2. Get all 'comic_issues' terms associated with these specific posts
                    $issue_terms = wp_get_object_terms( $comic_post_ids_in_series, 'comic_issues', array(
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                        'hide_empty' => true, // Only show issues that have comic posts assigned to them
                    ) );

                    // Filter out issues that don't have an 'issue_cover_id' meta, if that's a strict requirement
                    // (This assumes all valid issues should have a cover)
                    $issue_terms = array_filter($issue_terms, function($term) {
                        return get_term_meta( $term->term_id, 'issue_cover_id', true );
                    });
                }
                // --- END MODIFIED SECTION ---

                if ( ! empty( $issue_terms ) && ! is_wp_error( $issue_terms ) ) :
                    foreach ( $issue_terms as $issue ) :
                        // Get the issue cover ID
                        $issue_cover_id = get_term_meta( $issue->term_id, 'issue_cover_id', true );
                        // Get the issue cover URL (using 'medium' size for display in grid)
                        $issue_cover_url = $issue_cover_id ? wp_get_attachment_image_url( $issue_cover_id, 'medium' ) : '';
                        // Set alt text for accessibility
                        $issue_cover_alt = $issue_cover_id ? get_post_meta( $issue_cover_id, '_wp_attachment_image_alt', true ) : '';
                        if ( empty( $issue_cover_alt ) ) {
                            $issue_cover_alt = $issue->name . ' Cover';
                        }

                        $issue_link = get_term_link( $issue );
                        if ( ! is_wp_error( $issue_link ) ) :
                            ?>
                            <div class="comic-issue-item">
                                <a href="<?php echo esc_url( $issue_link ); ?>">
                                    <?php if ( $issue_cover_url ) : ?>
                                        <img src="<?php echo esc_url( $issue_cover_url ); ?>" alt="<?php echo esc_attr( $issue_cover_alt ); ?>" class="issue-cover">
                                    <?php endif; ?>
                                    <h3><?php echo esc_html( $issue->name ); ?></h3>
                                </a>
                            </div>
                            <?php
                        endif;
                    endforeach;
                else :
                    echo '<p>No issues found for this series yet.</p>';
                endif;
                ?>
            </div>

        <?php
        else : // This is the 'else' for the main 'if ( have_posts() )' on line 17
            get_template_part( 'template-parts/content', 'none' ); // Displays content-none.php if no posts are found
        endif; // This is the 'endif' for the main 'if ( have_posts() )' on line 17
        ?>

        </main>
    </div>
<?php
get_sidebar();
get_footer();
?>