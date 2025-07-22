</div><footer class="site-footer">
            <div class="container">
                <div class="footer-widgets">
                    <?php dynamic_sidebar( 'sidebar-footer' ); ?>
                </div><div class="site-info">
                    <?php
                    /**
                     * This theme supports custom copyright text.
                     */
                    $default_copyright = sprintf(
                        '&copy; %1$s %2$s. All Rights Reserved.',
                        date( 'Y' ),
                        get_bloginfo( 'name' )
                    );
                    $copyright_text = get_theme_mod( 'comixcore_copyright', $default_copyright );
                    echo wp_kses_post( $copyright_text );
                    ?>
                    <span class="sep"> | </span>
                    <?php
                    printf(
                        esc_html__( 'Proudly powered by %s', 'comixcore' ),
                        '<a href="' . esc_url( __( 'https://wordpress.org/', 'comixcore' ) ) . '">WordPress</a>'
                    );
                    ?>
                </div></div></footer></div><?php wp_footer(); ?>

</body>
</html>