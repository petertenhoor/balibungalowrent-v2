<?php

// enqueue parent stylesheet
add_action('wp_enqueue_scripts', 'booklium_child_wp_enqueue_scripts');
function booklium_child_wp_enqueue_scripts()
{

    $parent_theme = wp_get_theme(get_template());
    $child_theme = wp_get_theme();

    // Enqueue the parent stylesheet
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css', array(), $parent_theme['Version']);
    wp_enqueue_style('booklium-style', get_stylesheet_uri(), array('parent-style'), $child_theme['Version']);

    // Enqueue the parent rtl stylesheet
    if (is_rtl()) {
        wp_enqueue_style('parent-style-rtl', get_template_directory_uri() . '/rtl.css', array(), $parent_theme['Version']);
    }
}

add_filter('the_content', 'booklium_child_the_content', 100, 1);

/**
 * Remove room type attributes from the content if 'mphb-single-room-type-attributes' appears twice
 * @param string $content
 * @return string
 */
function booklium_child_the_content(string $content): string
{
    if (is_singular('mphb_room_type')) {
        $count = preg_match_all('/mphb-single-room-type-attributes/', $content);
        if ($count && is_numeric($count) && $count > 1) {
            $content = preg_replace('/<div class="single-room-attributes-wrapper">.*?<\/div>/s', '', $content);
        }
    }

    return $content;
}