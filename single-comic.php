<?php
/**
 * The template for displaying all single comic posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package ComixHelper Theme
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

        <?php
        while ( have_posts() ) :
            the_post();

            // Get Series terms
            $series_terms = get_the_terms( get_the_ID(), 'comic_series' );
            $series_name = '';
            $current_series_id = 0; // Initialize
            if ( ! is_wp_error( $series_terms ) && ! empty( $series_terms ) ) {
                $series_name = $series_terms[0]->name; // Assuming one series per comic
                $current_series_id = $series_terms[0]->term_id; // Get the ID of the current series
            }

            // Get Issue terms
            $issue_terms = get_the_terms( get_the_ID(), 'comic_issues' );
            $issue_name = '';
            $current_issue_term = null;
            if ( ! is_wp_error( $issue_terms ) && ! empty( $issue_terms ) ) {
                $current_issue_term = $issue_terms[0]; // Assuming one issue per comic page
                $issue_name = $current_issue_term->name;
            }

            // Get custom field values using native WordPress get_post_meta()
            $comic_page_image_id = get_post_meta( get_the_ID(), '_comic_page_image_id', true );
            $comic_page_number = get_post_meta( get_the_ID(), '_comic_page_number', true );
            $comic_display_style = get_post_meta( get_the_ID(), '_comic_display_style', true );

            // Determine if this comic is part of a vertical scroll issue
            $is_vertical_issue = ($comic_display_style === 'vertical_scroll' && $current_issue_term);

            // If it's a vertical scroll issue, redirect to the issue archive page
            // This ensures individual pages within a vertical issue aren't directly accessed
            if ( $is_vertical_issue ) {
                $issue_archive_link = get_term_link( $current_issue_term->term_id, 'comic_issues' );
                if ( ! is_wp_error( $issue_archive_link ) ) {
                    wp_redirect( $issue_archive_link );
                    exit; // Stop further execution after redirection
                }
            }

            $comic_page_image_url = $comic_page_image_id ? wp_get_attachment_image_url( $comic_page_image_id, 'full' ) : '';
            $comic_page_image_alt = $comic_page_image_id ? get_post_meta( $comic_page_image_id, '_wp_attachment_image_alt', true ) : '';
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php if ( $series_name ) : ?>
                        <h3 class="comic-series-title"><?php echo esc_html( $series_name ); ?></h3>
                    <?php endif; ?>
                    <?php if ( $issue_name ) : ?>
                        <h4 class="comic-issue-title"><?php echo esc_html( $issue_name ); ?></h4>
                    <?php endif; ?>
                    <?php if ( $comic_page_number ) : ?>
                        <p class="comic-page-number">Page <?php echo esc_html( $comic_page_number ); ?></p>
                    <?php endif; ?>
                </header><div class="entry-content comic-content">
                    <?php if ( $comic_page_image_url ) : ?>
                        <div class="comic-image-wrapper">
                            <img src="<?php echo esc_url( $comic_page_image_url ); ?>" alt="<?php echo esc_attr( $comic_page_image_alt ? $comic_page_image_alt : get_the_title() ); ?>" class="comic-page-image" />
                        </div>
                    <?php else : ?>
                        <div class="comic-image-placeholder">
                            <p>Image missing for <?php the_title(); ?>!</p>
                        </div>
                    <?php endif; ?>
                </div><footer class="entry-footer">
                    <nav class="comic-navigation" role="navigation">
                        <?php
                        // Current Post ID
                        $current_post_id = get_the_ID();

                        // --- Logic for First, Previous, Next, Last Page Navigation ---
                        $first_page_link = '';
                        $prev_page_link = '';
                        $next_page_link = '';
                        $last_page_link = '';

                        if ( $current_series_id ) {
                            // Query all comic posts in the current series, ordered by _comic_page_number
                            $all_comics_in_series_args = array(
                                'post_type'      => 'comic',
                                'posts_per_page' => -1, // Get all posts
                                'meta_key'       => '_comic_page_number',
                                'orderby'        => 'meta_value_num',
                                'order'          => 'ASC',
                                'tax_query'      => array(
                                    array(
                                        'taxonomy' => 'comic_series',
                                        'field'    => 'term_id',
                                        'terms'    => $current_series_id,
                                    ),
                                ),
                                'post_status'    => 'publish',
                                'fields'         => 'ids', // Get only IDs for efficiency
                            );
                            $all_comics_in_series_query = new WP_Query( $all_comics_in_series_args );
                            $comic_ids_in_series = $all_comics_in_series_query->posts;

                            if ( ! empty( $comic_ids_in_series ) ) {
                                $current_comic_index = array_search( $current_post_id, $comic_ids_in_series );

                                // First Page Link
                                $first_comic_id = $comic_ids_in_series[0];
                                if ( $current_post_id != $first_comic_id ) {
                                    $first_page_link = get_permalink( $first_comic_id );
                                }

                                // Previous Page Link
                                if ( $current_comic_index !== false && isset( $comic_ids_in_series[ $current_comic_index - 1 ] ) ) {
                                    $prev_page_link = get_permalink( $comic_ids_in_series[ $current_comic_index - 1 ] );
                                }

                                // Next Page Link
                                if ( $current_comic_index !== false && isset( $comic_ids_in_series[ $current_comic_index + 1 ] ) ) {
                                    $next_page_link = get_permalink( $comic_ids_in_series[ $current_comic_index + 1 ] );
                                }

                                // Last Page Link
                                $last_comic_id = end( $comic_ids_in_series ); // Get the last ID
                                if ( $current_post_id != $last_comic_id ) {
                                    $last_page_link = get_permalink( $last_comic_id );
                                }
                            }
                            wp_reset_postdata(); // Reset query for safety (after our custom query)
                        }

                        // --- Display Navigation Links (with placeholders for consistent spacing) ---

                        // First Page
                        if ( $first_page_link ) {
                            echo '<span class="nav-first-page"><a href="' . esc_url($first_page_link) . '" rel="first">&larr; First Page</a></span>';
                        } else {
                            echo '<span class="nav-first-page disabled"></span>';
                        }

                        // Previous Page
                        if( $prev_page_link ) {
                            echo '<span class="nav-previous"><a href="' . esc_url($prev_page_link) . '" rel="prev">&larr; Previous Page</a></span>';
                        } else {
                            echo '<span class="nav-previous disabled"></span>';
                        }

                        // Next Page
                        if( $next_page_link ) {
                            echo '<span class="nav-next"><a href="' . esc_url($next_page_link) . '" rel="next">Next Page &rarr;</a></span>';
                        } else {
                            echo '<span class="nav-next disabled"></span>';
                        }

                        // Last Page
                        if ( $last_page_link ) {
                            echo '<span class="nav-last-page"><a href="' . esc_url($last_page_link) . '" rel="last">Last Page &rarr;</a></span>';
                        } else {
                            echo '<span class="nav-last-page disabled"></span>';
                        }
                        ?>
                    </nav>
                </footer>
            </article>
        <?php
        endwhile; // End of the loop.
        ?>

        </main>
    </div>
<?php
get_sidebar(); // If you want to include your sidebar on comic pages
get_footer();
?>