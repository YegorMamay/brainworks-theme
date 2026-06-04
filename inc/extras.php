<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Отменяет удаление из корзины через определенный срок.
 */
function devise_remove_schedule_delete()
{
    remove_action('wp_scheduled_delete', 'wp_scheduled_delete');
}
add_action('init', 'devise_remove_schedule_delete');

/**
 * Плагин Yoast: отменяет создание автоматических редиректов.
 */
add_filter('wpseo_premium_post_redirect_slug_change', '__return_true');

/**
 * Скрывает топ-бар.
 */
function disable_admin_bar()
{
    if (!current_user_can('manage_options')) {
        add_filter('show_admin_bar', '__return_false');
    }
    // show admin bar only for admins and editors
    if (!current_user_can('edit_posts')) {
        add_filter('show_admin_bar', '__return_false');
    }
}
add_action('init', 'disable_admin_bar');

/**
 * Remove Gutenberg styles.
 */
function remove_wp_block_library_css()
{
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style'); // Remove WooCommerce block CSS
}
add_action('wp_enqueue_scripts', 'remove_wp_block_library_css', 100);

/**
 * Добавляем поддержку excerpt (цитат) для страниц.
 */
function bw_enable_page_excerpt()
{
    add_post_type_support('page', 'excerpt');
}
add_action('after_setup_theme', 'bw_enable_page_excerpt');

/**
 * Если юзер не админ логинится в админку, переадресовывается на Главную (/user/).
 */
function redirect_non_admin_users()
{
    // Проверяем, залогинен ли пользователь
    if (is_user_logged_in()) {
        $user = wp_get_current_user();

        // Если пользователь не администратор и это не AJAX-запрос
        if (!in_array('administrator', (array) $user->roles) && !defined('DOING_AJAX')) {
            wp_redirect(home_url('/user/')); // Перенаправляем на Profile/User page
            exit;
        }
    }
}
/**
 * Enable HTML in Category Descriptions
 */
remove_filter('pre_term_description', 'wp_filter_kses');
remove_filter('pre_link_description', 'wp_filter_kses');
remove_filter('pre_link_notes', 'wp_filter_kses');
remove_filter('term_description', 'wp_kses_data');

