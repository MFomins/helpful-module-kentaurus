<?php

// Add script and styles
function kentaurus_helpful_style_scripts()
{

    $post_types = get_field('select_post_type_helpful','options');

    // show on only selected post types
    if (is_singular($post_types)) {

        wp_enqueue_style('kentaurus-helpful', get_template_directory_uri() . "/inc/helpful/style.css", array(), KENTAURUS_VER);
        wp_enqueue_script('kentaurus-helpful-script', get_template_directory_uri() . "/inc/helpful/helpful.js", array('jquery'), KENTAURUS_VER, TRUE);

        wp_localize_script('kentaurus-helpful-script', 'helpfulData', array(
            'positive' => get_post_meta(get_the_ID(), '_kentaurus_helpful_yes'),
            'id' => get_the_id(),
            'nonce_wthf' => wp_create_nonce("kentaurus_helpful_nonce"),
            'ajaxurl' => admin_url('admin-ajax.php'),
        ));
    }

}

add_action('wp_enqueue_scripts', 'kentaurus_helpful_style_scripts');