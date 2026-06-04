<?php
/**
 * Navigation Menus registration.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register navigation menus.
 */
function setup_nav_menus()
{
    register_nav_menus(array(
        'main-menu' => esc_html__('Main Menu', 'brainworks'),
        'second-menu' => esc_html__('Second Menu', 'brainworks'),
        'mobile-menu' => esc_html__('Mobile Menu', 'brainworks'),
    ));
}
add_action('after_setup_theme', 'setup_nav_menus');
