<?php
/**
 * Breadcrumbs with Schema.org Microdata.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Display breadcrumbs with Schema.org markup.
 */
function breadcrumbs()
{
    // Settings
    $separator = '';
    $breadcrums_id = 'breadcrumbs';
    $breadcrums_class = 'breadcrumbs';
    $home_title = esc_html__('Home', 'brainworks');

    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy = 'product_cat';

    // Get the query & post information
    global $post, $wp_query;

    // Do not display on the front page
    if (is_front_page()) {
        return;
    }

    // Build the breadcrumbs
    echo '<nav id="' . esc_attr($breadcrums_id) . '" class="' . esc_attr($breadcrums_class) . '" aria-label="' . esc_attr__('Breadcrumb', 'brainworks') . '">';
    echo '<ol itemscope itemtype="https://schema.org/BreadcrumbList">';

    // Home Item
    echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
    echo '<a href="' . esc_url(home_url()) . '" itemprop="item"><span itemprop="name">' . $home_title . '</span></a>';
    echo '<meta itemprop="position" content="1" />';
    echo '</li>';

    $position = 2;

    if (is_home() && !is_front_page()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . single_post_title('', false) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } else if (is_category()) {
        $term = get_queried_object();
        // Get parent categories
        if ($term->parent != 0) {
            $parents = array();
            $parent = $term->parent;
            while ($parent) {
                $p_term = get_term($parent, 'category');
                $parents[] = $p_term;
                $parent = $p_term->parent;
            }
            $parents = array_reverse($parents);
            foreach ($parents as $p_term) {
                echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                echo '<a href="' . esc_url(get_term_link($p_term)) . '" itemprop="item"><span itemprop="name">' . esc_html($p_term->name) . '</span></a>';
                echo '<meta itemprop="position" content="' . $position . '" />';
                echo '</li>';
                $position++;
            }
        }
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . single_cat_title('', false) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } else if (is_tag()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . single_tag_title('', false) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } else if (is_author()) {
        global $author;
        $userdata = get_userdata($author);
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . esc_html__('Author: ', 'brainworks') . esc_html($userdata->display_name) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } else if (is_day()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . get_the_date() . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } else if (is_month()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . get_the_date('F Y') . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } else if (is_year()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . get_the_date('Y') . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } else if (is_tax()) {
        $term = get_queried_object();
        $tax = get_taxonomy($term->taxonomy);
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . single_term_title('', false) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } else if (is_post_type_archive()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . post_type_archive_title('', false) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } else if (is_archive()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . strip_tags(get_the_archive_title()) . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } else if (is_404()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . esc_html__('Error 404', 'brainworks') . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } else if (is_search()) {
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . esc_html__('Search results', 'brainworks') . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } else if (is_page()) {
        if ($post->post_parent) {
            $anc = get_post_ancestors($post->ID);
            $anc = array_reverse($anc);
            foreach ($anc as $ancestor) {
                echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                echo '<a href="' . esc_url(get_permalink($ancestor)) . '" itemprop="item"><span itemprop="name">' . get_the_title($ancestor) . '</span></a>';
                echo '<meta itemprop="position" content="' . $position . '" />';
                echo '</li>';
                $position++;
            }
        }
        echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        echo '<span itemprop="name">' . get_the_title() . '</span>';
        echo '<meta itemprop="position" content="' . $position . '" />';
        echo '</li>';
    } else if (is_single()) {
        // Custom Post Type
        if (get_post_type() != 'post') {
            $post_type = get_post_type_object(get_post_type());
            $slug = $post_type->rewrite;
            echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<a href="' . esc_url(home_url('/' . $slug['slug'] . '/')) . '" itemprop="item"><span itemprop="name">' . esc_html($post_type->labels->singular_name) . '</span></a>';
            echo '<meta itemprop="position" content="' . $position . '" />';
            echo '</li>';
            $position++;
            echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<span itemprop="name">' . get_the_title() . '</span>';
            echo '<meta itemprop="position" content="' . $position . '" />';
            echo '</li>';
        } else {
            // Standard Post
            $category = get_the_category();
            if ($category) {
                // Re-do category with manual loop for clean markup
                $cat = $category[0];
                $parents = array();
                $parent = $cat->parent;
                while ($parent) {
                    $p_term = get_term($parent, 'category');
                    $parents[] = $p_term;
                    $parent = $p_term->parent;
                }
                $parents = array_reverse($parents);
                // Add parents
                foreach ($parents as $p_term) {
                    echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                    echo '<a href="' . esc_url(get_term_link($p_term)) . '" itemprop="item"><span itemprop="name">' . esc_html($p_term->name) . '</span></a>';
                    echo '<meta itemprop="position" content="' . $position . '" />';
                    echo '</li>';
                    $position++;
                }
                // Add current category
                echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                echo '<a href="' . esc_url(get_term_link($cat)) . '" itemprop="item"><span itemprop="name">' . esc_html($cat->name) . '</span></a>';
                echo '<meta itemprop="position" content="' . $position . '" />';
                echo '</li>';
                $position++;
            }
            echo '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<span itemprop="name">' . get_the_title() . '</span>';
            echo '<meta itemprop="position" content="' . $position . '" />';
            echo '</li>';
        }
    }

    echo '</ol>';
    echo '</nav>';
}
