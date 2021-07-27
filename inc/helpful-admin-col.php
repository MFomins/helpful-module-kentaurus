<?php
// Adds custom column to admin
function betspin_helpful_admin_columns($columns) {
    return array_merge($columns, array('helpful' => 'Helpful'));
}


// Custom column content
function betspin_helpful_stats_column($column, $post_id) {

    // Variables
    $positive_value = intval(get_post_meta($post_id, "_betspin_helpful_yes", true));
    $negative_value = intval(get_post_meta($post_id, "_betspin_helpful_no", true));

    // Total
    $total = $positive_value + $negative_value;

    // helpful ration
    if($column == 'helpful'){

        if($total > 0){
            echo "<em style='display:block;color:rgba(0,0,0,.55);'>".$positive_value . " helpful votes" . " / ".$negative_value." not helpful votes</em>";
        }else{
            echo "—";
        }

    }

}

// Adds post type support
function betspin_helpful_post_type_support(){

    $post_types = array("post", "page", "casino-review");

    // loop selected type
    if(!empty($post_types)){

        foreach ($post_types as $selected_type) {

            add_filter('manage_'.$selected_type.'_posts_columns', 'betspin_helpful_admin_columns');
            add_action('manage_'.$selected_type.'_posts_custom_column', 'betspin_helpful_stats_column', 10, 2);

        }

    }

}

add_action("init", "betspin_helpful_post_type_support");