<?php
/**
 * Theme setup and SVG upload support.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Настройка темы при загрузке.
 * Тема готова к переводу через Loco Translate (text domain: brainworks).
 */
function theme_setup()
{
    load_theme_textdomain('brainworks', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
    add_theme_support('automatic-feed-links');

    if (class_exists('WooCommerce')) {
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');

        // Enable AJAX add to cart on archives
        if ('yes' !== get_option('woocommerce_enable_ajax_add_to_cart')) {
            update_option('woocommerce_enable_ajax_add_to_cart', 'yes');
        }
    }

    // Gutenberg Support
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_editor_style('style.css');
    add_theme_support('custom-line-height');
    add_theme_support('custom-units');
}
add_action('after_setup_theme', 'theme_setup');

/**
 * Разрешить загрузку SVG в медиабиблиотеку (Только для администратора).
 */
function allow_svg_upload($mimes)
{
    if (current_user_can('administrator')) {
        $mimes['svg'] = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';
    }
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');

/**
 * Корректное определение типа файла для .svg и .svgz (расширение и MIME).
 */
function check_filetype_svg($data, $file, $filename, $mimes)
{
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if ($ext === 'svg' || $ext === 'svgz') {
        $data['ext'] = $ext;
        $data['type'] = 'image/svg+xml';
        $data['proper_filename'] = $filename;
    }
    return $data;
}
add_filter('wp_check_filetype_and_ext', 'check_filetype_svg', 10, 4);

/**
 * Санитизация загружаемого SVG: удаление скриптов и опасных атрибутов.
 *
 * @param array $file Данные загруженного файла.
 * @return array
 */
function sanitize_svg_upload($file)
{
    if ($file['type'] !== 'image/svg+xml') {
        return $file;
    }
    $content = file_get_contents($file['file']);
    if ($content === false) {
        return $file;
    }
    // Удалить теги <script>, обработчики событий, javascript: в href/style.
    $content = preg_replace('/<script\b[^>]*>[\s\S]*?<\/script>/i', '', $content);
    $content = preg_replace('/\s+on\w+\s*=\s*["\'][^"\']*["\']/i', '', $content);
    $content = preg_replace('/\s+on\w+\s*=\s*[^\s>]+/i', '', $content);
    $content = preg_replace('/javascript\s*:/i', '', $content);
    $content = preg_replace('/data\s*:\s*[^,]*script/i', '', $content);
    file_put_contents($file['file'], $content);
    return $file;
}
add_filter('wp_handle_upload', 'sanitize_svg_upload', 10, 1);
