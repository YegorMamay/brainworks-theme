<?php
/**
 * Widget areas registration.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Регистрация областей виджетов.
 */
function widgets_init()
{
    $widget_common = array(
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    );

    register_sidebar(
        array_merge(
            $widget_common,
            array(
                'name' => esc_html__('Pre-header', 'brainworks'),
                'id' => 'pre-header',
                'description' => esc_html__('Above the site header.', 'brainworks'),
            )
        )
    );

    register_sidebar(
        array_merge(
            $widget_common,
            array(
                'name' => esc_html__('Footer', 'brainworks'),
                'id' => 'footer',
                'description' => esc_html__('Footer widget area.', 'brainworks'),
            )
        )
    );

    register_sidebar(
        array_merge(
            $widget_common,
            array(
                'name' => esc_html__('Sidebar Left', 'brainworks'),
                'id' => 'sidebar-left',
                'description' => esc_html__('Left sidebar column.', 'brainworks'),
            )
        )
    );

    register_sidebar(
        array_merge(
            $widget_common,
            array(
                'name' => esc_html__('Sidebar Right', 'brainworks'),
                'id' => 'sidebar-right',
                'description' => esc_html__('Right sidebar column.', 'brainworks'),
            )
        )
    );
}
add_action('widgets_init', 'widgets_init');
