<?php

// Add script and styles
function betspin_helpful_style_scripts()
{

    $post_types = array("post", "page", "casino-review");

    // show on only selected post types
    if (is_singular($post_types)) {

        wp_enqueue_style('betspin-helpful', get_template_directory_uri() . "/inc/helpful/style.css", array(), BETSPIN_VER);
        wp_enqueue_script('betspin-helpful-script', get_template_directory_uri() . "/inc/helpful/helpful.js", array('jquery'), BETSPIN_VER, TRUE);

        wp_localize_script('betspin-helpful-script', 'helpfulData', array(
            'positive' => get_post_meta(get_the_ID(), '_betspin_helpful_yes'),
            'id' => get_the_id(),
            'nonce_wthf' => wp_create_nonce("betspin_helpful_nonce"),
            'ajaxurl' => admin_url('admin-ajax.php'),
        ));
    }

}

add_action('wp_enqueue_scripts', 'betspin_helpful_style_scripts');