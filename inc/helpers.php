<?php
/**
 * Helper functions: phones, social, messengers, logo, related posts, layout.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Преобразует отображаемый номер в значение для href (tel: только цифры с плюсом).
 *
 * @param string $display_number Номер в формате пользователя, например +38 (063) 20-37-130.
 * @return string Например +380632037130.
 */
function brainworks_phone_to_tel($display_number)
{
    $digits = preg_replace('/\D/', '', wp_strip_all_tags($display_number));
    if ($digits === '') {
        return '';
    }
    return '+' . $digits;
}

/**
 * Возвращает массив данных по телефонам из настроек темы.
 * Каждый элемент: number (как задано), tel (для href), class, icon_id.
 *
 * @return array<int, array{number: string, tel: string, class: string, icon_id: int}>
 */
function brainworks_get_phones_data()
{
    $items = array();
    for ($i = 1; $i <= 6; $i++) {
        $number = get_theme_mod('brainworks_phone_' . $i, '');
        $number = is_string($number) ? trim($number) : '';
        if ($number === '') {
            continue;
        }
        $items[] = array(
            'number' => $number, // Can contain HTML
            'desc' => (string) get_theme_mod('brainworks_phone_' . $i . '_desc', ''),
            'tel' => brainworks_phone_to_tel($number),
            'class' => (string) get_theme_mod('brainworks_phone_' . $i . '_class', ''),
            'icon_id' => (int) get_theme_mod('brainworks_phone_' . $i . '_icon', 0),
        );
    }
    return $items;
}

/**
 * Возвращает массив данных по соцсетям из настроек темы.
 * Каждый элемент: url, icon_id. Только слоты с непустым URL.
 *
 * @return array<int, array{url: string, icon_id: int}>
 */
function brainworks_get_social_data()
{
    $items = array();
    for ($i = 1; $i <= 10; $i++) {
        $url = get_theme_mod('brainworks_social_' . $i, '');
        $url = is_string($url) ? trim($url) : '';
        if ($url === '') {
            continue;
        }
        $url = esc_url_raw($url);
        if ($url === '') {
            continue;
        }
        $items[] = array(
            'url' => $url,
            'icon_id' => (int) get_theme_mod('brainworks_social_' . $i . '_icon', 0),
        );
    }
    return $items;
}

/**
 * Возвращает массив данных по мессенджерам из настроек темы.
 *
 * @return array<int, array{url: string, icon_id: int, type: string}>
 */
function brainworks_get_messengers_data()
{
    $items = array();
    foreach (array('whatsapp', 'telegram', 'viber', 'skype', 'facebook-messenger') as $messenger) {
        $url = get_theme_mod('brainworks_messenger_' . $messenger, '');
        $url = is_string($url) ? trim($url) : '';
        if ($url === '') {
            continue;
        }
        $items[] = array(
            'url' => $url,
            'icon_id' => (int) get_theme_mod('brainworks_messenger_' . $messenger . '_icon', 0),
            'type' => $messenger,
        );
    }
    return $items;
}

/**
 * Возвращает HTML логотипа по типу (main|second).
 *
 * @param string $which  'main' или 'second'.
 * @param array  $args   link (bool), size (string), class (string).
 * @return string
 */
function brainworks_get_logo_html($which = 'main', $args = array())
{
    $key = ($which === 'second') ? 'brainworks_second_logo' : 'brainworks_main_logo';
    $id = get_theme_mod($key, 0);
    $args = wp_parse_args(
        $args,
        array(
            'link' => true,
            'size' => 'medium',
            'class' => '',
        )
    );
    if (!$id) {
        return '';
    }
    $alt = get_bloginfo('name', 'display');
    $img = wp_get_attachment_image($id, $args['size'], false, array('alt' => $alt, 'class' => 'site-logo__img'));
    if (!$img) {
        return '';
    }
    $css_class = 'site-logo site-logo--' . $which;
    if (!empty($args['class'])) {
        $css_class .= ' ' . esc_attr($args['class']);
    }
    if ($args['link']) {
        return '<a href="' . esc_url(home_url('/')) . '" class="' . esc_attr($css_class) . '" rel="home">' . $img . '</a>';
    }
    return '<span class="' . esc_attr($css_class) . '">' . $img . '</span>';
}

/**
 * Вывод похожих записей для single.php.
 * Поиск по тегам, если их нет — по категориям.
 */
function brainworks_get_related_posts_html()
{
    if (!is_singular('post')) {
        return '';
    }

    $post_id = get_the_ID();
    $tags = wp_get_post_tags($post_id);
    $args = array(
        'posts_per_page' => 3,
        'post__not_in' => array($post_id),
        'orderby' => 'rand',
    );

    if ($tags) {
        $tag_ids = array();
        foreach ($tags as $tag) {
            $tag_ids[] = $tag->term_id;
        }
        $args['tag__in'] = $tag_ids;
    } else {
        $categories = get_the_category($post_id);
        if ($categories) {
            $category_ids = array();
            foreach ($categories as $category) {
                $category_ids[] = $category->term_id;
            }
            $args['category__in'] = $category_ids;
        }
    }

    $query = new WP_Query($args);
    if (!$query->have_posts()) {
        wp_reset_postdata();
        return '';
    }

    $out = '<section class="related-posts">';
    $out .= '<h3 class="related-posts__title">' . esc_html__('Related Posts', 'brainworks') . '</h3>';
    $out .= '<div class="related-posts__grid">';

    while ($query->have_posts()) {
        $query->the_post();
        $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'medium'); // Get URL only
        $thumb_html = '';

        if ($thumb_url) {
            $thumb_html = '<div class="related-posts__img" style="background-image: url(' . esc_url($thumb_url) . ');"></div>';
        } else {
            // Optional: Placeholder if no image
            $thumb_html = '<div class="related-posts__img related-posts__img--placeholder"></div>';
        }

        $out .= '<article class="related-posts__item">';
        $out .= '<a href="' . esc_url(get_permalink()) . '" class="related-posts__link-wrap">';
        $out .= $thumb_html;
        $out .= '<div class="related-posts__content">';
        $out .= '<h4 class="related-posts__item-title">' . get_the_title() . '</h4>';
        // Add custom excerpt length or use default
        $excerpt = get_the_excerpt();
        // Limit excerpt length manually if WP default is too long for cards
        $excerpt = wp_trim_words($excerpt, 15, '...');
        $out .= '<div class="related-posts__excerpt">' . $excerpt . '</div>';
        $out .= '</div>'; // .related-posts__content
        $out .= '</a>';
        $out .= '</article>';
    }

    $out .= '</div>';
    $out .= '</section>';

    wp_reset_postdata();
    return $out;
}

/**
 * Determine the layout class based on active sidebars and page template.
 *
 * @return string CSS class for the site-content container.
 */
/**
 * Check if the left sidebar should be displayed.
 *
 * @return bool
 */
function brainworks_has_left_sidebar()
{
    if (is_page_template('page-sidebar-left.php') || is_page_template('page-sidebar-both.php')) {
        return is_active_sidebar('sidebar-left');
    }

    if (is_singular('post')) {
        return get_theme_mod('brainworks_single_sidebar_left', false) && is_active_sidebar('sidebar-left');
    }

    if (is_archive() || is_home() || is_search()) {
        return get_theme_mod('brainworks_archive_sidebar_left', false) && is_active_sidebar('sidebar-left');
    }

    return false;
}

/**
 * Check if the right sidebar should be displayed.
 *
 * @return bool
 */
function brainworks_has_right_sidebar()
{
    if (is_page_template('page-sidebar-right.php') || is_page_template('page-sidebar-both.php')) {
        return is_active_sidebar('sidebar-right');
    }

    if (is_singular('post')) {
        return get_theme_mod('brainworks_single_sidebar_right', false) && is_active_sidebar('sidebar-right');
    }

    if (is_archive() || is_home() || is_search()) {
        return get_theme_mod('brainworks_archive_sidebar_right', false) && is_active_sidebar('sidebar-right');
    }

    return false;
}

/**
 * Determine the layout class based on active sidebars and page template.
 *
 * @return string CSS class for the site-content container.
 */
function brainworks_get_layout_class()
{
    $left = brainworks_has_left_sidebar();
    $right = brainworks_has_right_sidebar();

    if ($left && $right) {
        return 'site-content--sidebar-both';
    }

    if ($left) {
        return 'site-content--sidebar-left';
    }

    if ($right) {
        return 'site-content--sidebar-right';
    }

    return 'site-content--full-width';
}
