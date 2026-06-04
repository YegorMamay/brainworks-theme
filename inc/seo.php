<?php
/**
 * SEO Meta Tags.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get Custom SEO Title.
 * Refined version of user's custom_seo_title().
 *
 * @return string
 */
function get_seo_title()
{
    $title = '';

    if (is_front_page()) {
        $title = get_bloginfo('name') . ' - ' . get_bloginfo('description');
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    } elseif (is_singular()) {
        $title = single_post_title('', false);
    } elseif (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_archive()) {
        $title = get_the_archive_title();
    } elseif (is_search()) {
        $title = sprintf(esc_html__('Search Results for: %s', 'brainworks'), get_search_query());
    } elseif (is_404()) {
        $title = esc_html__('Page Not Found', 'brainworks');
    }

    // Fallback
    if (empty($title)) {
        $title = get_bloginfo('name');
    }

    return $title;
}

/**
 * Output SEO Meta Tags in wp_head.
 * Only if Yoast SEO is NOT active.
 */
function seo_meta_tags()
{
    if (defined('WPSEO_VERSION')) {
        return;
    }

    $title = get_seo_title();
    $description = '';

    if (has_excerpt()) {
        $description = get_the_excerpt();
    } else {
        $description = get_bloginfo('description');
    }

    // Default Image
    $image_url = get_the_post_thumbnail_url(null, 'full');

    // Check for Category/Term Social Image
    if (is_category() || is_tag() || is_tax()) {
        $term_id = get_queried_object_id();
        $social_image_id = get_term_meta($term_id, 'brainworks_social_image_id', true);
        if ($social_image_id) {
            $image_url = wp_get_attachment_url($social_image_id);
        }
    }

    if (empty($image_url)) {
        $image_url = get_template_directory_uri() . '/assets/img/default-og-image.jpg';
    }

    ?>
    <meta name="description" content="<?php echo esc_attr($description); ?>">

    <!-- OpenGraph -->
    <meta property="og:locale" content="<?php echo esc_attr(get_locale()); ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo esc_attr($title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($description); ?>">
    <meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>">
    <meta property="og:site_name" content="<?php echo esc_attr(get_bloginfo('name')); ?>">
    <meta property="og:image" content="<?php echo esc_url($image_url); ?>">
    <meta property="og:image:secure_url" content="<?php echo esc_url($image_url); ?>">

    <!-- Twitter Meta -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr($title); ?>">
    <meta name="twitter:image" content="<?php echo esc_url($image_url); ?>">
    <?php
}
add_action('wp_head', 'seo_meta_tags', 5);

/**
 * Filter Document Title if Yoast is missing.
 * This ensures the <title> tag matches our custom logic without duplication.
 */
function filter_document_title($title_parts)
{
    if (defined('WPSEO_VERSION')) {
        return $title_parts;
    }

    // Use our custom logic to replace the title
    $custom_title = get_seo_title();

    // Reset parts and just set title to our custom string
    // Or we can let WP handle site name/tagline and just override the 'title' part.
    // User logic seemed to want specific control.
    // Let's override the 'title' part.
    $title_parts['title'] = $custom_title;

    // If we want FULL control (like the user effectively had with manual echo),
    // we might want to clear tagline/site depending on the page logic.
    // Using user's logic:
    if (is_front_page()) {
        $title_parts['title'] = get_bloginfo('name');
        $title_parts['tagline'] = get_bloginfo('description');
    }

    return $title_parts;
}
add_filter('document_title_parts', 'filter_document_title');
