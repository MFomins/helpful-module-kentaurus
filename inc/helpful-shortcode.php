<?php

function kentaurus_helpful_shortcode()
{

    $cookie = stripslashes($_COOKIE["helpful"]);

    $new_cookie = preg_replace('/[^a-zA-Z0-9 \,]/m', '', $cookie);

    $cookie_array = explode(',', $new_cookie);

    $post_id = get_the_ID();

    $positive_ratings = get_post_meta($post_id, '_kentaurus_helpful_yes');

    $translated_text = _n('person found this content useful', 'people found this content useful', $positive_ratings[0], 'kentaurus');

    $content = "";

    // Dont show if value exists in cookie
    if (!in_array($post_id, $cookie_array)) {

        wp_enqueue_style('kentaurus-helpful', get_template_directory_uri() . "/inc/helpful/style.css", array(), KENTAURUS_VER);
        wp_enqueue_script('kentaurus-helpful-script', get_template_directory_uri() . "/inc/helpful/helpful.js", array('jquery'), KENTAURUS_VER, TRUE);

        wp_localize_script('kentaurus-helpful-script', 'helpfulData', array(
            'positive' => get_post_meta(get_the_ID(), '_kentaurus_helpful_yes'),
            'id' => get_the_id(),
            'nonce_wthf' => wp_create_nonce("kentaurus_helpful_nonce"),
            'ajaxurl' => admin_url('admin-ajax.php'),
        ));

        $content .= '<div class="kentaurus-helpful">';

        $content .= '<div class="helpful-title">' . __('Was this content helpful?', 'kentaurus') . '</div>';

        $content .= '<div class="helpful-yes-no">';

        $content .= '<span data-value="1">👍 ' . __('Yes', 'kentaurus') . '</span><span data-value="0">👎 ' . __('No', 'kentaurus') . '</span>';

        $content .= '</div>';

        if ($positive_ratings[0]) {
            $content .= '<div class="helpful-results"><div><span class="helpful-votes">' . $positive_ratings[0] . '</span> ' . $translated_text . '</div></div>';
        }

        $content .= '</div>';

        $content .= '<div class="helpful-thank-you">' . __('Thank you for your feedback! We will do our best to improve this content!', 'kentaurus') . '</div>';
    }


    return $content;

}

add_shortcode('kentaurus_helpful', 'kentaurus_helpful_shortcode');