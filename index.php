<?php
/**
 * The main template file for the ComixCore theme.
 * This file also acts as the template for Comic Series archives if no specific taxonomy template exists.
 *
 * @package ComixCore
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

        <?php
        // Get the current queried object (could be a post, page, taxonomy term, etc.)
        $queried_object = get_queried_object();
        $is_comic_series_archive = false;
        $current_series = null;

        // Check if this is a comic_series archive
        if ( is_a( $queried_object, 'WP_Term' ) && $queried_object->taxonomy === 'comic_series' ) {
            $is_comic_series_archive = true;
            $current_series = $queried_object;
        }

        if ( $is_comic_series_archive && $current_series ) :
            // This is a Comic Series Archive page
        ?>

            <header class="page-header">
                <h1 class="page-title"><?php echo esc_html( $current_series->name ); ?></h1>
                <?php if ( ! empty( $current_series->description ) ) : ?>
                    <div class="taxonomy-description"><?php echo wp_kses_post( wpautop( $current_series->description ) ); ?></div>
                <?php endif; ?>

                <?php
                    // Get the series logo ID
                    $series_logo_id = get_term_meta( $current_series->term_id, 'series_logo_id', true );
                    if ( $series_logo_id ) :
                ?>
                    <div class="series-logo-container">
                        <?php echo wp_get_attachment_image( $series_logo_id, 'series-logo', false, array( 'alt' => $current_series->name . ' Logo', 'class' => 'series-logo' ) ); ?>
                    </div>
                <?php endif; ?>
            </header>

            <div class="comic-issues-grid">
                <?php
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

                $issue_terms_unsorted = array();

                if ( ! empty( $comic_post_ids_in_series ) ) {
                    // 2. Get all 'comic_issues' terms associated with these specific posts.
                    $issue_terms_unsorted = wp_get_object_terms( $comic_post_ids_in_series, 'comic_issues', array(
                        'orderby'    => 'none',
                        'hide_empty' => true,
                    ) );

                    // Filter out issues that don't have an 'issue_cover_id' meta
                    $issue_terms_unsorted = array_filter($issue_terms_unsorted, function($term) {
                        return get_term_meta( $term->term_id, 'issue_cover_id', true );
                    });
                }

                $issue_terms = array();
                if ( ! empty( $issue_terms_unsorted ) ) {
                    // 3. Get 'issue_number' meta for each issue and store for sorting
                    $issues_with_meta_for_sort = array();
                    foreach ( $issue_terms_unsorted as $term ) {
                        $issue_number = get_term_meta( $term->term_id, 'issue_number', true );
                        $issues_with_meta_for_sort[] = (object) array(
                            'term_object'  => $term,
                            'issue_number' => intval( $issue_number )
                        );
                    }

                    // 4. Sort the issues by their 'issue_number'
                    usort( $issues_with_meta_for_sort, function( $a, $b ) {
                        return $a->issue_number <=> $b->issue_number;
                    });

                    // 5. Extract the sorted term objects
                    foreach ( $issues_with_meta_for_sort as $item ) {
                        $issue_terms[] = $item->term_object;
                    }
                }

                if ( ! empty( $issue_terms ) && ! is_wp_error( $issue_terms ) ) :
                    foreach ( $issue_terms as $issue ) :
                        $issue_cover_id = get_term_meta( $issue->term_id, 'issue_cover_id', true );
                        $issue_link = get_term_link( $issue );
                        if ( ! is_wp_error( $issue_link ) ) :
                            ?>
                            <div class="comic-issue-item">
                                <a href="<?php echo esc_url( $issue_link ); ?>">
                                    <?php if ( $issue_cover_id ) : ?>
                                        <?php echo wp_get_attachment_image( $issue_cover_id, 'issue-cover', false, array( 'alt' => $issue->name . ' Cover', 'class' => 'issue-cover' ) ); ?>
                                    <?php endif; ?>
                                    <h3><?php echo esc_html( $issue->name ); ?></h3>
                                    <?php $issue_number = get_term_meta( $issue->term_id, 'issue_number', true ); ?>
                                    <?php if ( $issue_number ) : ?>
                                        <span class="issue-number">Issue #<?php echo esc_html( $issue_number ); ?></span>
                                    <?php endif; ?>
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
        else : // This block handles all other archive types (posts, categories, etc.)
               // or if get_queried_object fails for a comic_series.
            if ( have_posts() ) :
                if ( is_home() && ! is_front_page() ) : ?>
                    <header>
                        <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                    </header>
                <?php endif;

                /* Start the Loop */
                while ( have_posts() ) : the_post();

                    /*
                     * Include the Post-Type-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                     */
                    get_template_part( 'template-parts/content', get_post_type() );

                endwhile;

                the_posts_navigation();

            else :
                get_template_part( 'template-parts/content', 'none' );

            endif;
        endif; // End check for comic_series archive
        ?>

        </main>
    </div>
<?php
get_sidebar(); // Assuming your theme uses a sidebar
get_footer();
?>