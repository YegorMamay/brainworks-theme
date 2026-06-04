<?php
/**
 * Theme functions and definitions.
 * Минимальная настройка темы, PHP 7.4+.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
	exit;
}

require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/nav-menus.php';
require get_template_directory() . '/inc/enqueues.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/widgets.php';
require get_template_directory() . '/inc/widget-custom-class.php';
require get_template_directory() . '/inc/admin-term-image.php';

require get_template_directory() . '/inc/breadcrumbs.php';
require get_template_directory() . '/inc/schema.php';
require get_template_directory() . '/inc/seo.php';
require get_template_directory() . '/inc/extras.php';

require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/shortcodes.php';

require get_template_directory() . '/inc/login.php';
require get_template_directory() . '/inc/woocommerce-hooks.php';
