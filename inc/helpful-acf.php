<?php

//Load post types in options

add_filter('acf/load_field/name=select_post_type_helpful', 'kentaurus_load_post_types');

function kentaurus_load_post_types($field)
{
    $cpts = get_post_types(array('public' => true));

    unset($cpts['attachment']);

    foreach ($cpts as $post_type) {

        $field['choices'][$post_type] = $post_type;

    }

    // return the field
    return $field;
}

//Add helpful options page
add_action('acf/init', 'kentaurus_helpful_options');
function kentaurus_helpful_options()
{

    // Check function exists.
    if (function_exists('acf_add_options_sub_page')) {

        acf_add_options_sub_page(array(
            'page_title' => __('WTH Settings'),
            'menu_title' => __('Was This Helpful'),
            'parent_slug' => 'theme-general-settings',
        ));
    }
}

//Add custom fields to was this helpful options page
if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_61015a0c44c26',
        'title' => 'Was This Helpful',
        'fields' => array(
            array(
                'key' => 'field_61015a1e57f66',
                'label' => 'Select Post Type',
                'name' => 'select_post_type_helpful',
                'type' => 'checkbox',
                'instructions' => 'Select post types where to display was this helpful box',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'post' => 'post',
                    'page' => 'page',
                    'casino' => 'casino',
                ),
                'allow_custom' => 0,
                'default_value' => array(),
                'layout' => 'horizontal',
                'toggle' => 1,
                'return_format' => 'value',
                'save_custom' => 0,
            ),
            array(
                'key' => 'field_61025201fa306',
                'label' => 'Shortcode',
                'name' => '',
                'type' => 'message',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => 'To use helpful box shortcode add [kentaurus_helpful] to the content',
                'new_lines' => 'wpautop',
                'esc_html' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-was-this-helpful',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

endif;

//Hide helpful box for the pages
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_61025bd3121cc',
        'title' => 'Hide Helpful',
        'fields' => array(
            array(
                'key' => 'field_61025be081a8a',
                'label' => 'Hide Helpful Box',
                'name' => 'hide_box_helpful',
                'type' => 'true_false',
                'instructions' => 'Check if you want to hide box on this page',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 0,
                'ui' => 0,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

endif;