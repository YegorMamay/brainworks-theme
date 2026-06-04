<?php
/**
 * Login page customization.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Custom styles for the login page.
 */
function login_customization()
{
    $logo_id = get_theme_mod('brainworks_login_logo');
    $bg_id = get_theme_mod('brainworks_login_bg');
    $bg_repeat = get_theme_mod('brainworks_login_bg_repeat', 'no-repeat');
    $bg_size = get_theme_mod('brainworks_login_bg_size', 'cover');
    $bg_pos = get_theme_mod('brainworks_login_bg_position', 'center center');
    $bg_attach = get_theme_mod('brainworks_login_bg_attachment', 'fixed');

    echo '<style type="text/css">';

    // Background
    if ($bg_id) {
        $bg_url = wp_get_attachment_image_url($bg_id, 'full');
        if ($bg_url) {
            echo "body.login {
                background-image: url(" . esc_url($bg_url) . ") !important;
                background-repeat: " . esc_attr($bg_repeat) . " !important;
                background-size: " . esc_attr($bg_size) . " !important;
                background-position: " . esc_attr($bg_pos) . " !important;
                background-attachment: " . esc_attr($bg_attach) . " !important;
            }";
        }
    }

    // Logo
    if ($logo_id) {
        $logo_url = wp_get_attachment_image_url($logo_id, 'full');
        if ($logo_url) {
            echo ".login h1 a {
                background-image: url(" . esc_url($logo_url) . ") !important;
                background-size: contain !important;
                width: 100% !important;
                height: 100px !important;
            }";
        }
    }

    // Label colors for better visibility on glass
    echo ".login label {  }";

    echo '</style>';
}
add_action('login_enqueue_scripts', 'login_customization');

/**
 * Change login logo URL to home page.
 */
function login_logo_url()
{
    return home_url();
}
add_filter('login_headerurl', 'login_logo_url');

/**
 * Change login logo title to site name.
 */
function login_logo_title()
{
    return get_bloginfo('name');
}
add_filter('login_headertext', 'login_logo_title');
