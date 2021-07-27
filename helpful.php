<?php

require_once __DIR__ . '/inc/helpful-enqueue.php';
require_once __DIR__ . '/inc/helpful-general.php';
require_once __DIR__ . '/inc/helpful-admin-col.php';

function betspin_activate_cookies() {

    if ( is_plugin_active( 'wp-rocket/wp-rocket.php' ) ) {
        add_filter( 'rocket_htaccess_mod_rewrite', '__return_false', 64 );
        add_filter( 'rocket_cache_dynamic_cookies', 'betspin_add_dynamic_cookies' );
        add_filter( 'rocket_cache_mandatory_cookies', 'betspin_add_dynamic_cookies' );

        // Update the WP Rocket rules on the .htaccess file.
        flush_rocket_htaccess();

        // Regenerate the config file.
        rocket_generate_config_file();
    }

}
add_action( 'init', 'betspin_activate_cookies', 11 );

function betspin_add_dynamic_cookies( $cookies ) {

    $cookies[] = 'helpful';
    return $cookies;

}