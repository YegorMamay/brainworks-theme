<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Подключение основных стилей (style.css скомпилирован из assets/scss/style.scss).
 */
function enqueue_scripts()
{
    $theme = wp_get_theme();
    $version = $theme->get('Version');
    $style_css = get_theme_file_path('style.css');

    wp_enqueue_style(
        'brainworks-style',
        get_stylesheet_uri(),
        array(),
        file_exists($style_css) ? filemtime($style_css) : $version
    );

    if (get_theme_mod('brainworks_scroll_to_top_enabled', 1)) {
        $script_path = get_theme_file_path('assets/js/scroll-to-top.js');
        wp_enqueue_script(
            'brainworks-scroll-to-top',
            get_theme_file_uri('assets/js/scroll-to-top.js'),
            array(),
            file_exists($script_path) ? filemtime($script_path) : $version,
            true
        );
    }
    // ...


    $brainworks_js = get_theme_file_path('assets/js/brainworks.js');
    wp_enqueue_script(
        'brainworks-main',
        get_theme_file_uri('assets/js/brainworks.js'),
        array(),
        file_exists($brainworks_js) ? filemtime($brainworks_js) : $version,
        true
    );

    if (class_exists('WooCommerce')) {
        $wc_quantity_js = get_theme_file_path('assets/js/woocommerce-quantity.js');
        wp_enqueue_script(
            'brainworks-wc-quantity',
            get_theme_file_uri('assets/js/woocommerce-quantity.js'),
            array('jquery'),
            file_exists($wc_quantity_js) ? filemtime($wc_quantity_js) : $version,
            true
        );

        if (is_product()) {
            $ajax_cart_js = get_theme_file_path('assets/js/ajax-add-to-cart.js');
            wp_enqueue_script(
                'brainworks-ajax-add-to-cart',
                get_theme_file_uri('assets/js/ajax-add-to-cart.js'),
                array('jquery', 'wc-add-to-cart'),
                file_exists($ajax_cart_js) ? filemtime($ajax_cart_js) : $version,
                true
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');

/**
 * Enqueue Google Fonts and apply them.
 */
function enqueue_google_fonts()
{
    $header_font = get_theme_mod('brainworks_header_font', 'Roboto');
    $body_font = get_theme_mod('brainworks_body_font', 'Roboto');

    if (empty($header_font) && empty($body_font)) {
        return;
    }

    // Prepare fonts array
    // We request 400, 700 for header
    // We request 400, 400i, 700, 700i for body
    $weights = ':ital,wght@0,400;0,700;1,400;1,700';

    $families = array();
    if ($header_font) {
        $families[] = 'family=' . str_replace(' ', '+', $header_font) . $weights;
    }
    if ($body_font && $body_font !== $header_font) {
        $families[] = 'family=' . str_replace(' ', '+', $body_font) . $weights;
    }

    if (empty($families)) {
        return;
    }

    // Construct URL manually
    $fonts_url = 'https://fonts.googleapis.com/css2?' . implode('&', $families) . '&display=swap';

    wp_enqueue_style('brainworks-google-fonts', $fonts_url, array(), null);

    // Add inline styles
    $custom_css = '';
    if ($header_font) {
        $custom_css .= "h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 { font-family: '{$header_font}', sans-serif; }\n";
    }
    if ($body_font) {
        $custom_css .= "body, p, li, a, span, div { font-family: '{$body_font}', sans-serif; }\n";
    }

    if ($custom_css) {
        wp_add_inline_style('brainworks-style', $custom_css);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_google_fonts', 20);
