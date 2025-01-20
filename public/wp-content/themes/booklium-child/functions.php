<?php


/**
 * Enqueue the parent and child theme stylesheets
 * @return void
 */
function initBookliumChild(): void
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

add_action('wp_enqueue_scripts', 'initBookliumChild');

/**
 * Remove room type attributes from the content if 'mphb-single-room-type-attributes' appears twice
 * @param string $content
 * @return string
 */
function removeDoubleRoomAttributesBlock(string $content): string
{
    if (is_singular('mphb_room_type')) {
        $count = preg_match_all('/mphb-single-room-type-attributes/', $content);
        if ($count && is_numeric($count) && $count > 1) {
            $content = preg_replace('/<div class="single-room-attributes-wrapper">.*?<\/div>/s', '', $content);
        }
    }

    return $content;
}

add_filter('the_content', 'removeDoubleRoomAttributesBlock', 100, 1);

/**
 * Modify the wp_block post type to be public
 * @return void
 */
function makeWpBlockTypePublicInAdmin(): void
{
    global $wp_post_types;
    if (is_admin() && isset($wp_post_types['wp_block'])) {
        $wp_post_types['wp_block']->public = true;
    }
}

add_action('init', 'makeWpBlockTypePublicInAdmin', 99);

//add settings for accommodations
if (function_exists('acf_add_options_page')) {
    add_action('acf/init', function () {
        acf_add_options_sub_page([
            'page_title' => __("Custom settings", 'booklium'),
            'menu_title' => __("Custom settings", 'booklium'),
            'menu_slug' => 'custom-accommodation-settings',
            'post_id' => 'custom-accommodation-settings',
            'parent_slug' => sprintf('edit.php?post_type=%1$s', 'mphb_room_type'),
        ]);
    });
}

//add some HTML above the footer when on single mphb_room_type post
add_action('acf/init', function () {

    //show alternative single term title if set on location pages
    add_filter('single_term_title', function (string $termName): string {
        $term = get_queried_object();

        if (is_a($term, 'WP_Term') && $term->taxonomy === 'mphb_ra_locations') {
            $altH1Text = get_field('location_alternative_h1_text', $term) ?: '';
            if ($altH1Text) $termName = $altH1Text;
        }

        return $termName;
    });

    add_action('get_footer', function () {
        $blockPatternPostContent = '';

        //handle single accommodation
        if (is_singular('mphb_room_type')) {
            $accommodationBottomContentGlobalId = get_field('accommodation_bottom_content_global', 'custom-accommodation-settings') ?: false;
            if ($accommodationBottomContentGlobalId) {
                $blockPatternPost = get_post($accommodationBottomContentGlobalId);
                if (is_a($blockPatternPost, 'WP_Post')) {
                    $blockPatternPostContent = apply_filters('the_content', $blockPatternPost->post_content);
                }
            }
        }

        //handle mphb_ra_locations term pages
        if (is_tax('mphb_ra_locations')) {
            $term = get_queried_object();
            $locationBottomContentId = get_field('location_bottom_content', $term) ?: false;
            if ($locationBottomContentId) {
                $blockPatternPost = get_post($locationBottomContentId);
                if (is_a($blockPatternPost, 'WP_Post')) {
                    $blockPatternPostContent = apply_filters('the_content', $blockPatternPost->post_content);
                }
            }
        }

        if ($blockPatternPostContent): ?>
            <section class='content-area content-area--bottom' style="padding-bottom: 0 !important">
                <div class="entry-content">
                    <?php echo $blockPatternPostContent; ?>
                </div>
            </section>
        <?php endif;
    });

    // Add a filter to modify the loaded value for the ACF field "location_bottom_content"
    add_filter('acf/load_value/name=location_bottom_content', 'fixTranslatedPostObjectBlockPatternFieldValue', 10, 3);
    add_filter('acf/load_value/name=accommodation_bottom_content_global', 'fixTranslatedPostObjectBlockPatternFieldValue', 10, 3);

    /**
     * Fix (or modify) the loaded value for the ACF field "location_bottom_content"
     * @param mixed $value
     * @param string $post_id
     * @param array $field
     * @return mixed
     */
    function fixTranslatedPostObjectBlockPatternFieldValue(mixed $value, string $post_id, array $field): mixed
    {
        if (empty($value)) return $value;

        if (function_exists('pll_get_post')) {
            $currentLanguage = pll_current_language();
            $translatedBlockId = pll_get_post($value, $currentLanguage);
            if (!empty($translatedBlockId)) $value = $translatedBlockId;
        }

        return $value;
    }
});