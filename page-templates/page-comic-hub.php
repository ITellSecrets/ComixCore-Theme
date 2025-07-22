<?php
/**
 * Template Name: Comic Hub Page
 * Description: Displays a list of all comic series with their logos.
 *
 * @package ComixCore
 */

get_header(); // Loads the header.php template

?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <header class="page-header">
            <h1 class="page-title"><?php single_post_title(); ?></h1>
        </header>
        <div class="comic-series-grid">
            <?php
            // Get all terms from the 'comic_series' taxonomy
            $series_terms = get_terms( array(
                'taxonomy'   => 'comic_series',
                'hide_empty' => true, // Only show series that have comics assigned
                'orderby'    => 'name',
                'order'      => 'ASC',
            ) );

            if ( ! empty( $series_terms ) && ! is_wp_error( $series_terms ) ) :
                foreach ( $series_terms as $series ) :
                    // --- START MODIFIED SECTION ---
                    // Get the series logo ID using get_term_meta()
                    $series_logo_id = get_term_meta( $series->term_id, 'series_logo_id', true );
                    // Get the image URL from the attachment ID
                    $series_logo_url = $series_logo_id ? wp_get_attachment_image_url( $series_logo_id, 'full' ) : ''; // 'full' for original size
                    // Get the image alt text from the attachment ID
                    $series_logo_alt = $series_logo_id ? get_post_meta( $series_logo_id, '_wp_attachment_image_alt', true ) : '';

                    // Fallback for alt text if not set
                    if ( empty( $series_logo_alt ) ) {
                        $series_logo_alt = $series->name . ' Logo';
                    }
                    // --- END MODIFIED SECTION ---

                    // Get the permalink for the series archive page
                    $series_link = get_term_link( $series );

                    if ( ! is_wp_error( $series_link ) ) :
                        ?>
                        <div class="comic-series-item">
                                <a href="<?php echo esc_url( $series_link ); ?>">
                                    <?php if ( $series_logo_url ) : // Check if a logo URL exists ?>
                                        <img src="<?php echo esc_url( $series_logo_url ); ?>" alt="<?php echo esc_attr( $series_logo_alt ); ?>" class="series-logo">
                                        <h2 class="series-title-under-logo"><?php echo esc_html( $series->name ); ?></h2>
                                    <?php else : // Fallback if no logo is set ?>
                                        <h2><?php echo esc_html( $series->name ); ?></h2>
                                    <?php endif; ?>
                                </a>
                            </div><?php
                    endif;
                endforeach;
            else :
                // No series found
                echo '<p>No comic series found.</p>';
            endif;
            ?>
        </div>
    </main>
</div>
<?php get_footer(); // Loads the footer.php template ?>