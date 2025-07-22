<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;700&family=Rye&display=swap" rel="stylesheet">
</head>

<body <?php body_class(); ?>>
    <div class="container">
        <header class="site-header">
            <div class="site-header-inner">
                <div class="site-branding">
                    <?php
                    if ( has_custom_logo() ) {
                        the_custom_logo();
                    } else {
                        ?>
                        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                        <p class="site-description"><?php bloginfo( 'description' ); ?></p>
                        <?php
                    }
                    ?>
                </div><nav id="site-navigation" class="main-navigation">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                        )
                    );
                    ?>
                </nav></div></header><div class="site-content">