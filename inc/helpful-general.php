<?php


function kentaurus_helpful_post_content($content)
{
    $post_types = get_field('select_post_type_helpful','options');

    $cookie = stripslashes($_COOKIE["helpful"]);

    $new_cookie = preg_replace('/[^a-zA-Z0-9 \,]/m', '', $cookie);

    $cookie_array = explode(',', $new_cookie);

    if (is_singular($post_types) && !get_field('hide_box_helpful')) {

        $post_id = get_the_ID();

        $positive_ratings = get_post_meta($post_id, '_kentaurus_helpful_yes');

        $translated_text = _n('person found this content useful', 'people found this content useful', $positive_ratings[0], 'kentaurus');

        // Dont show if value exists in cookie
        if (!in_array($post_id, $cookie_array)) {

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


    }
    return $content;
}

add_filter('the_content', 'kentaurus_helpful_post_content', 10000);

//Ajax callback
function kentaurus_helpful_ajax_callback()
{

    // Check Nonce
    if (!wp_verify_nonce($_POST['nonce'], "kentaurus_helpful_nonce")) {
        exit("Leave!");
    }

    // Get posts
    $post_id = intval($_POST['id']);
    $value = intval($_POST['val']);

    $value_name = "_kentaurus_helpful_no";
    if ($value == "1") {
        $value_name = "_kentaurus_helpful_yes";
    }

    // Cookie check
    if (isset($_COOKIE["kentaurus_helpful_id_" . $post_id])) {
        exit("Leave!");
    }

    // Get
    $current_post_value = get_post_meta($post_id, $value_name, true);

    // Make it zero if empty
    if (empty($current_post_value)) {
        $current_post_value = 0;
    }

    // Update value
    $new_value = $current_post_value + 1;

    // Update post meta
    update_post_meta($post_id, $value_name, $new_value);

    // Die WP
    wp_die();

}

add_action("wp_ajax_wthf_ajax", "kentaurus_helpful_ajax_callback");
add_action("wp_ajax_nopriv_wthf_ajax", "kentaurus_helpful_ajax_callback");