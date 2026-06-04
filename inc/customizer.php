<?php
/**
 * Customizer settings: logos, phones, social, scroll-to-top, scripts, login, messengers, layout.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Returns an array of Customizer section priorities.
 *
 * @return array
 */
function brainworks_get_customizer_section_priorities()
{
    $priorities = array(
        'theme_colors_section' => 25,
        'brainworks_mobile_menu_section' => 30,
        'brainworks_phones' => 40,
        'brainworks_social' => 41,
        'brainworks_scroll_to_top' => 24,
        'brainworks_messengers' => 42,
        'brainworks_sidebar' => 23,
        'brainworks_fonts' => 26,
        'brainworks_sticky_header' => 22,
        'title_tagline' => 20, // Core section
        // Add other core sections here if needed: 'colors', 'header_image', 'background_image', 'nav', 'static_front_page', 'custom_css'
    );

    return apply_filters('brainworks_customizer_section_priorities', $priorities);
}

/**
 * Output CSS variables and styles based on Customizer settings.
 */
function brainworks_render_theme_css_vars()
{
    ?>
    <style type="text/css">
        :root {
            <?php
            // Palette Color Defaults (Following the 7-variable system where possible)
            $default_palette = array(
                1 => '#007bff', // Accent 1
                2 => '#333333', // Dark Gray
                3 => '#28a745', // Accent 2
                4 => '#dc3545', // Danger Red
                5 => '#ffc107', // Warning Yellow
                6 => '#f8f9fa', // Light Gray
                7 => '#343a40', // Dark
            );

            // Output Palette Colors (Only if changed from default/empty)
            for ($i = 1; $i <= 7; $i++) {
                $color = get_theme_mod('brainworks_theme_color_' . $i, '');
                if (!empty($color)) {
                    echo "--theme-color-{$i}: " . esc_attr($color) . ";\n";
                }
            }

            // Mobile Menu Colors Defaults (Matching the 7-variable system)
            $defaults_mobile = array(
                'bg' => '',
                'text' => '',
                'link' => '',
                'link_hover' => '',
                'close' => '',
                'separator' => '',
            );

            $mobile_menu_bg = get_theme_mod('brainworks_mobile_menu_bg', $defaults_mobile['bg']);
            $mobile_menu_text = get_theme_mod('brainworks_mobile_menu_text', $defaults_mobile['text']);
            $mobile_menu_link = get_theme_mod('brainworks_mobile_menu_link', $defaults_mobile['link']);
            $mobile_menu_link_hover = get_theme_mod('brainworks_mobile_menu_link_hover', $defaults_mobile['link_hover']);
            $mobile_menu_close = get_theme_mod('brainworks_mobile_menu_close_color', $defaults_mobile['close']);
            $mobile_menu_separator = get_theme_mod('brainworks_mobile_menu_separator_color', $defaults_mobile['separator']);

            if (!empty($mobile_menu_bg)) {
                echo "--mobile-menu-bg: " . esc_attr($mobile_menu_bg) . ";\n";
            }
            if (!empty($mobile_menu_text)) {
                echo "--mobile-menu-text: " . esc_attr($mobile_menu_text) . ";\n";
            }
            if (!empty($mobile_menu_link)) {
                echo "--mobile-menu-link: " . esc_attr($mobile_menu_link) . ";\n";
            }
            if (!empty($mobile_menu_link_hover)) {
                echo "--mobile-menu-link-hover: " . esc_attr($mobile_menu_link_hover) . ";\n";
            }
            if (!empty($mobile_menu_close)) {
                echo "--mobile-menu-close: " . esc_attr($mobile_menu_close) . ";\n";
            }
            if (!empty($mobile_menu_separator)) {
                echo "--mobile-menu-separator: " . esc_attr($mobile_menu_separator) . ";\n";
            }

            // Main Menu Colors Defaults
            $defaults_main_menu = array(
                'bg' => '',
                'text' => '',
                'accent' => '',
                'hover_bg' => '',
                'hover_text' => '',
            );

            $main_menu_bg_ref = get_theme_mod('brainworks_main_menu_bg_color', $defaults_main_menu['bg']);
            $main_menu_text_ref = get_theme_mod('brainworks_main_menu_text_color', $defaults_main_menu['text']); // Default dark
            $menu_accent_ref = get_theme_mod('brainworks_menu_accent_color', $defaults_main_menu['accent']);
            $main_menu_hover_bg_ref = get_theme_mod('brainworks_main_menu_hover_bg', $defaults_main_menu['hover_bg']);
            $main_menu_hover_text_ref = get_theme_mod('brainworks_main_menu_hover_text', $defaults_main_menu['hover_text']);

            // Map keys
            $map = array(
                'color_1' => '--theme-color-1',
                'color_2' => '--theme-color-2',
                'color_3' => '--theme-color-3',
                'color_4' => '--theme-color-4',
                'color_5' => '--theme-color-5',
                'color_6' => '--theme-color-6',
                'color_7' => '--theme-color-7',
            );

            if (!empty($main_menu_bg_ref) && isset($map[$main_menu_bg_ref])) {
                echo "--main-menu-bg: var({$map[$main_menu_bg_ref]});\n";
            }

            if (!empty($main_menu_text_ref) && isset($map[$main_menu_text_ref])) {
                echo "--main-menu-text: var({$map[$main_menu_text_ref]});\n";
            }

            if (!empty($menu_accent_ref) && isset($map[$menu_accent_ref])) {
                echo "--min-menu-accent: var({$map[$menu_accent_ref]});\n";
            }

            if (!empty($main_menu_hover_bg_ref) && isset($map[$main_menu_hover_bg_ref])) {
                echo "--main-menu-hover-bg: var({$map[$main_menu_hover_bg_ref]});\n";
            }

            if (!empty($main_menu_hover_text_ref) && isset($map[$main_menu_hover_text_ref])) {
                echo "--main-menu-hover-text: var({$map[$main_menu_hover_text_ref]});\n";
            }

            $defaults_elements = array(
                'btn1' => '',
                'btn2' => '',
                'btn3' => '',
                'woo' => '',
                'sub_menu_bg' => '',
            );

            // Map Elements to Colors
            $btn1_ref = get_theme_mod('brainworks_btn_primary_color_ref', $defaults_elements['btn1']);
            $btn2_ref = get_theme_mod('brainworks_btn_secondary_color_ref', $defaults_elements['btn2']);
            $btn3_ref = get_theme_mod('brainworks_btn_accent_color_ref', $defaults_elements['btn3']);
            $woo_ref = get_theme_mod('brainworks_woocommerce_color_ref', $defaults_elements['woo']);
            $sub_menu_bg_ref = get_theme_mod('brainworks_sub_menu_bg_color', $defaults_elements['sub_menu_bg']);

            if (!empty($btn1_ref) && isset($map[$btn1_ref])) {
                echo "--btn-primary-bg: var({$map[$btn1_ref]});\n";
            }
            if (!empty($btn2_ref) && isset($map[$btn2_ref])) {
                echo "--btn-secondary-bg: var({$map[$btn2_ref]});\n";
            }
            if (!empty($btn3_ref) && isset($map[$btn3_ref])) {
                echo "--btn-accent-bg: var({$map[$btn3_ref]});\n";
            }
            if (!empty($woo_ref) && isset($map[$woo_ref])) {
                echo "--woo-color: var({$map[$woo_ref]});\n";
            }
            if (!empty($sub_menu_bg_ref) && isset($map[$sub_menu_bg_ref])) {
                echo "--sub-menu-bg: var({$map[$sub_menu_bg_ref]});\n";
            }

            // Sidebar Variables
            $sidebar_sticky_enabled = get_theme_mod('brainworks_sidebar_sticky', false);
            $header_sticky_enabled = get_theme_mod('brainworks_header_sticky', false);

            $sidebar_sticky = $sidebar_sticky_enabled ? 'sticky' : 'static';

            $sidebar_offset_lg = get_theme_mod('brainworks_sidebar_offset_lg', 20);
            $sidebar_offset_md = get_theme_mod('brainworks_sidebar_offset_md', 20);
            $sidebar_offset_sm = get_theme_mod('brainworks_sidebar_offset_sm', 20);
            $sidebar_offset_xs = get_theme_mod('brainworks_sidebar_offset_xs', 20);

            // Scroll Trigger for Sticky Sidebar
            $scroll_trigger = 0;
            $sticky_top_delta = 0;
            if ($sidebar_sticky_enabled) {
                // We always output these if sticky is enabled, or just always for safety
                if ($header_sticky_enabled) {
                    $scroll_trigger = get_theme_mod('brainworks_sidebar_header_offset', 0);
                }
                $sticky_top_delta = get_theme_mod('brainworks_sidebar_sticky_top_offset', 0);
            }

            echo "--sidebar-sticky: {$sidebar_sticky};\n";
            echo "--sidebar-scroll-trigger: {$scroll_trigger};\n";
            echo "--sidebar-sticky-offset-delta: {$sticky_top_delta}px;\n";
            echo "--sidebar-offset-lg: {$sidebar_offset_lg}px;\n";
            echo "--sidebar-offset-md: {$sidebar_offset_md}px;\n";
            echo "--sidebar-offset-sm: {$sidebar_offset_sm}px;\n";
            echo "--sidebar-offset-xs: {$sidebar_offset_xs}px;\n";
            ?>
        }

        /* Access the variables in CSS */
        <?php if (!empty($btn1_ref)): ?>
            .btn-primary {
                background-color: var(--btn-primary-bg);
                border-color: var(--btn-primary-bg);
                color: #fff;
            }

            .btn-primary:hover,
            .btn-primary:focus,
            .btn-primary:active {
                filter: brightness(0.9);
                background-color: var(--btn-primary-bg) !important;
                border-color: var(--btn-primary-bg) !important;
            }

        <?php endif; ?>

        <?php if (!empty($btn2_ref)): ?>
            .btn-secondary {
                background-color: var(--btn-secondary-bg);
                border-color: var(--btn-secondary-bg);
                color: #fff;
            }

            .btn-secondary:hover,
            .btn-secondary:focus,
            .btn-secondary:active {
                filter: brightness(0.9);
                background-color: var(--btn-secondary-bg) !important;
                border-color: var(--btn-secondary-bg) !important;
            }

        <?php endif; ?>
        <?php if (!empty($btn1_ref)): ?>
            /* Outline variants */
            .btn-outline-primary {
                color: var(--btn-primary-bg);
                border-color: var(--btn-primary-bg);
                background-color: transparent;
            }

            .btn-outline-primary:hover {
                background-color: var(--btn-primary-bg) !important;
                border-color: var(--btn-primary-bg) !important;
                color: #fff;
            }

        <?php endif; ?>

        <?php if (!empty($btn2_ref)): ?>
            .btn-outline-secondary {
                color: var(--btn-secondary-bg);
                border-color: var(--btn-secondary-bg);
                background-color: transparent;
            }

            .btn-outline-secondary:hover {
                background-color: var(--btn-secondary-bg) !important;
                border-color: var(--btn-secondary-bg) !important;
                color: #fff;
            }

        <?php endif; ?>

        <?php if (!empty($btn3_ref)): ?>
            .btn-accent {
                background-color: var(--btn-accent-bg);
                border-color: var(--btn-accent-bg);
                color: #fff;
            }

            .btn-accent:hover,
            .btn-accent:focus,
            .btn-accent:active {
                filter: brightness(0.9);
                background-color: var(--btn-accent-bg) !important;
                border-color: var(--btn-accent-bg) !important;
            }

        <?php endif; ?>

        <?php if (!empty($btn3_ref)): ?>
            .btn-outline-accent {
                color: var(--btn-accent-bg);
                border-color: var(--btn-accent-bg);
                background-color: transparent;
            }

            .btn-outline-accent:hover {
                background-color: var(--btn-accent-bg) !important;
                border-color: var(--btn-accent-bg) !important;
                color: #fff;
            }

        <?php endif; ?>

        <?php
        // Page Background Colors
        $body_bg = get_theme_mod('brainworks_body_bg_color', '');
        $front_bg = get_theme_mod('brainworks_front_page_bg_color', '');

        if (!empty($body_bg)) {
            echo 'body { background-color: ' . esc_attr($body_bg) . "; }\n";
        }
        if (!empty($front_bg)) {
            echo 'body.home { background-color: ' . esc_attr($front_bg) . "; }\n";
        }
        ?>
    </style>
    <?php
}
add_action('wp_head', 'brainworks_render_theme_css_vars');

/**
 * Returns an array of popular Google Fonts.
 *
 * @return array
 */
function brainworks_get_google_fonts()
{
    return array(
        'Roboto' => 'Roboto',
        'Open Sans' => 'Open Sans',
        'Montserrat' => 'Montserrat',
        'Lato' => 'Lato',
        'Poppins' => 'Poppins',
        'Oswald' => 'Oswald',
        'Source Sans Pro' => 'Source Sans Pro',
        'Slabo 27px' => 'Slabo 27px',
        'Raleway' => 'Raleway',
        'PT Sans' => 'PT Sans',
        'Merriweather' => 'Merriweather',
        'Noto Sans' => 'Noto Sans',
        'Nunito' => 'Nunito',
        'Concert One' => 'Concert One',
        'Prompt' => 'Prompt',
        'Work Sans' => 'Work Sans',
        'Rubik' => 'Rubik',
        'Fira Sans' => 'Fira Sans',
        'Arimo' => 'Arimo',
        'Mulish' => 'Mulish',
        'Inter' => 'Inter',
        'Balsamiq Sans' => 'Balsamiq Sans',
        'Comfortaa' => 'Comfortaa',
        'Dosis' => 'Dosis',
        'Anton' => 'Anton',
        'Josefin Sans' => 'Josefin Sans',
        'Libre Baskerville' => 'Libre Baskerville',
        'Lora' => 'Lora',
        'Ubuntu' => 'Ubuntu',
        'Playfair Display' => 'Playfair Display',
    );
}

/**
 * AJAX Handler for Resetting Customizer
 */
function brainworks_reset_customizer_handler()
{
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Unauthorized');
    }

    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'brainworks_reset_nonce')) {
        wp_send_json_error('Invalid Nonce');
    }

    if (isset($_POST['settings']) && is_array($_POST['settings'])) {
        foreach ($_POST['settings'] as $setting) {
            remove_theme_mod(sanitize_key($setting));
        }
    } else {
        // Fallback or handle error if needed, but let's be safe
        wp_send_json_error('No settings provided');
    }

    wp_send_json_success();
}
add_action('wp_ajax_brainworks_reset_customizer', 'brainworks_reset_customizer_handler');

/**
 * Customizer: логотипы (Main Logo, Second Logo) в разделе «Свойства сайта».
 */
function brainworks_customize_register(WP_Customize_Manager $wp_customize)
{
    if (!class_exists('Brainworks_Reset_Control')) {
        /**
         * Custom Control for Reset Button
         */
        class Brainworks_Reset_Control extends WP_Customize_Control
        {
            public $type = 'brainworks_reset';
            public $reset_settings = array();

            public function __construct($manager, $id, $args = array())
            {
                parent::__construct($manager, $id, $args);
                if (isset($args['reset_settings'])) {
                    $this->reset_settings = $args['reset_settings'];
                }
            }

            public function render_content()
            {
                $control_id = 'brainworks-reset-' . str_replace('_', '-', $this->id);
                ?>
                <div style="margin: 10px 0;">
                    <button type="button" class="button button-secondary brainworks-reset-button"
                        id="<?php echo esc_attr($control_id); ?>"
                        style="width: 100%; text-align: center; border-color: #dc3232; color: #dc3232;">
                        <?php echo esc_html($this->label); ?>
                    </button>
                    <?php if (!empty($this->description)): ?>
                        <p class="description" style="margin-top: 5px;">
                            <?php echo esc_html($this->description); ?>
                        </p>
                    <?php endif; ?>
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        $('#<?php echo esc_js($control_id); ?>').on('click', function (e) {
                            e.preventDefault();
                            if (!confirm('<?php echo esc_js(__('Are you sure? This will reset ONLY settings in this section.', 'brainworks')); ?>')) {
                                return;
                            }

                            var data = {
                                action: 'brainworks_reset_customizer',
                                nonce: '<?php echo wp_create_nonce('brainworks_reset_nonce'); ?>',
                                settings: <?php echo json_encode($this->reset_settings); ?>
                            };

                            $(this).attr('disabled', 'disabled').text('<?php echo esc_js(__('Resetting...', 'brainworks')); ?>');

                            $.post(ajaxurl, data, function (response) {
                                if (response.success) {
                                    wp.customize.state('saved').set(true);
                                    location.reload();
                                } else {
                                    alert('Error: ' + response.data);
                                    $('#<?php echo esc_js($control_id); ?>').removeAttr('disabled').text('<?php echo esc_js(__('Reset All Theme Settings', 'brainworks')); ?>');
                                }
                            });
                        });
                    });
                </script>
                <?php
            }
        }
    }

    $priorities = brainworks_get_customizer_section_priorities();

    $wp_customize->add_setting(
        'brainworks_main_logo',
        array(
            'type' => 'theme_mod',
            'sanitize_callback' => 'absint',
        )
    );

    $wp_customize->add_setting(
        'brainworks_reset_all',
        array(
            'type' => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    // --- Colors Section ---
    $wp_customize->add_section(
        'theme_colors_section',
        array(
            'title' => esc_html__('Colors', 'brainworks'),
            'priority' => isset($priorities['theme_colors_section']) ? $priorities['theme_colors_section'] : 25,
        )
    );

    // --- Mobile Menu Section ---
    $wp_customize->add_section(
        'brainworks_mobile_menu_section',
        array(
            'title' => esc_html__('Mobile Menu', 'brainworks'),
            'priority' => isset($priorities['brainworks_mobile_menu_section']) ? $priorities['brainworks_mobile_menu_section'] : 30,
        )
    );

    // Position
    $wp_customize->add_setting(
        'brainworks_mobile_menu_position',
        array(
            'default' => 'right',
            'sanitize_callback' => 'sanitize_key', // 'left' or 'right'
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        'brainworks_mobile_menu_position',
        array(
            'label' => esc_html__('Menu Position', 'brainworks'),
            'section' => 'brainworks_mobile_menu_section',
            'type' => 'select',
            'choices' => array(
                'left' => esc_html__('Left', 'brainworks'),
                'right' => esc_html__('Right', 'brainworks'),
            ),
        )
    );

    // Background
    $wp_customize->add_setting(
        'brainworks_mobile_menu_bg',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'brainworks_mobile_menu_bg',
            array(
                'label' => esc_html__('Background Color', 'brainworks'),
                'section' => 'brainworks_mobile_menu_section',
            )
        )
    );

    // Text Color
    $wp_customize->add_setting(
        'brainworks_mobile_menu_text',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'brainworks_mobile_menu_text',
            array(
                'label' => esc_html__('Text Color', 'brainworks'),
                'section' => 'brainworks_mobile_menu_section',
            )
        )
    );

    // Link Color
    $wp_customize->add_setting(
        'brainworks_mobile_menu_link',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'brainworks_mobile_menu_link',
            array(
                'label' => esc_html__('Link Color', 'brainworks'),
                'section' => 'brainworks_mobile_menu_section',
            )
        )
    );

    // Link Hover Color
    $wp_customize->add_setting(
        'brainworks_mobile_menu_link_hover',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'brainworks_mobile_menu_link_hover',
            array(
                'label' => esc_html__('Link Hover Color', 'brainworks'),
                'section' => 'brainworks_mobile_menu_section',
            )
        )
    );

    // Close Button Color
    $wp_customize->add_setting(
        'brainworks_mobile_menu_close_color',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'brainworks_mobile_menu_close_color',
            array(
                'label' => esc_html__('Close Button Color', 'brainworks'),
                'section' => 'brainworks_mobile_menu_section',
            )
        )
    );

    // Separator Color
    $wp_customize->add_setting(
        'brainworks_mobile_menu_separator_color',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field', // Allow rgba
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'brainworks_mobile_menu_separator_color',
            array(
                'label' => esc_html__('Separator Color', 'brainworks'),
                'section' => 'brainworks_mobile_menu_section',
            )
        )
    );

    $wp_customize->add_control(
        new Brainworks_Reset_Control(
            $wp_customize,
            'brainworks_reset_mobile',
            array(
                'label' => esc_html__('Reset Mobile Menu Settings', 'brainworks'),
                'description' => esc_html__('Caution: This will reset only mobile menu colors and position to theme defaults.', 'brainworks'),
                'section' => 'brainworks_mobile_menu_section',
                'settings' => 'brainworks_reset_all',
                'reset_settings' => array(
                    'brainworks_mobile_menu_position',
                    'brainworks_mobile_menu_bg',
                    'brainworks_mobile_menu_text',
                    'brainworks_mobile_menu_link',
                    'brainworks_mobile_menu_link_hover',
                    'brainworks_mobile_menu_close_color',
                    'brainworks_mobile_menu_separator_color',
                ),
            )
        )
    );

    $default_colors = array(
        1 => '',
        2 => '',
        3 => '',
        4 => '',
        5 => '',
        6 => '',
        7 => '',
    );

    $palette_choices = array(
        '' => esc_html__('Default (Theme Variable)', 'brainworks'),
        'color_1' => esc_html__('Color 1', 'brainworks'),
        'color_2' => esc_html__('Color 2', 'brainworks'),
        'color_3' => esc_html__('Color 3', 'brainworks'),
        'color_4' => esc_html__('Color 4', 'brainworks'),
        'color_5' => esc_html__('Color 5', 'brainworks'),
        'color_6' => esc_html__('Color 6', 'brainworks'),
        'color_7' => esc_html__('Color 7', 'brainworks'),
    );

    for ($i = 1; $i <= 7; $i++) {
        $wp_customize->add_setting(
            'brainworks_theme_color_' . $i,
            array(
                'default' => $default_colors[$i],
                'sanitize_callback' => 'sanitize_hex_color',
                'type' => 'theme_mod',
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'brainworks_theme_color_' . $i,
                array(
                    'label' => sprintf(esc_html__('Color %d', 'brainworks'), $i),
                    'section' => 'theme_colors_section',
                )
            )
        );
    }

    // Main Menu Background
    $wp_customize->add_setting(
        'brainworks_main_menu_bg_color',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_key',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        'brainworks_main_menu_bg_color',
        array(
            'label' => esc_html__('Main Menu Background', 'brainworks'),
            'section' => 'theme_colors_section',
            'type' => 'select',
            'choices' => $palette_choices,
        )
    );

    // Main Menu Text Color
    $wp_customize->add_setting(
        'brainworks_main_menu_text_color',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_key',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        'brainworks_main_menu_text_color',
        array(
            'label' => esc_html__('Main Menu Text Color', 'brainworks'),
            'section' => 'theme_colors_section',
            'type' => 'select',
            'choices' => $palette_choices,
        )
    );

    // Menu Accent Color
    $wp_customize->add_setting(
        'brainworks_menu_accent_color',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_key',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        'brainworks_menu_accent_color',
        array(
            'label' => esc_html__('Menu Accent Color', 'brainworks'),
            'section' => 'theme_colors_section',
            'type' => 'select',
            'choices' => $palette_choices,
        )
    );

    // Main Menu Item Hover Background
    $wp_customize->add_setting(
        'brainworks_main_menu_hover_bg',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_key',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        'brainworks_main_menu_hover_bg',
        array(
            'label' => esc_html__('Main Menu Item Hover Background', 'brainworks'),
            'section' => 'theme_colors_section',
            'type' => 'select',
            'choices' => $palette_choices,
        )
    );

    // Main Menu Item Hover Text Color
    $wp_customize->add_setting(
        'brainworks_main_menu_hover_text',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_key',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        'brainworks_main_menu_hover_text',
        array(
            'label' => esc_html__('Main Menu Item Hover Text Color', 'brainworks'),
            'section' => 'theme_colors_section',
            'type' => 'select',
            'choices' => $palette_choices,
        )
    );

    // -----------------------------------------------------------------------
    // Page Background Colors
    // -----------------------------------------------------------------------

    // General body background
    $wp_customize->add_setting(
        'brainworks_body_bg_color',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'brainworks_body_bg_color',
            array(
                'label' => esc_html__('Page Background Color', 'brainworks'),
                'description' => esc_html__('Background color for all pages. Leave empty to use theme default.', 'brainworks'),
                'section' => 'theme_colors_section',
            )
        )
    );

    // Homepage-specific background
    $wp_customize->add_setting(
        'brainworks_front_page_bg_color',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_hex_color',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'brainworks_front_page_bg_color',
            array(
                'label' => esc_html__('Homepage Background Color', 'brainworks'),
                'description' => esc_html__('Overrides the page background only on the front (home) page.', 'brainworks'),
                'section' => 'theme_colors_section',
            )
        )
    );

    // Element Mapping: Button 1 (Primary)
    $wp_customize->add_setting(
        'brainworks_btn_primary_color_ref',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_key',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        'brainworks_btn_primary_color_ref',
        array(
            'label' => esc_html__('Button 1 Color (Primary)', 'brainworks'),
            'section' => 'theme_colors_section',
            'type' => 'select',
            'choices' => $palette_choices,
        )
    );

    // Element Mapping: Button 2 (Secondary)
    $wp_customize->add_setting(
        'brainworks_btn_secondary_color_ref',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_key',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        'brainworks_btn_secondary_color_ref',
        array(
            'label' => esc_html__('Button 2 Color (Secondary)', 'brainworks'),
            'section' => 'theme_colors_section',
            'type' => 'select',
            'choices' => $palette_choices,
        )
    );

    // Element Mapping: Button 3 (Accent)
    $wp_customize->add_setting(
        'brainworks_btn_accent_color_ref',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_key',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        'brainworks_btn_accent_color_ref',
        array(
            'label' => esc_html__('Button 3 Color (Accent)', 'brainworks'),
            'section' => 'theme_colors_section',
            'type' => 'select',
            'choices' => $palette_choices,
        )
    );

    // Element Mapping: WooCommerce Main Color
    $wp_customize->add_setting(
        'brainworks_woocommerce_color_ref',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_key',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        'brainworks_woocommerce_color_ref',
        array(
            'label' => esc_html__('WooCommerce Main Color', 'brainworks'),
            'section' => 'theme_colors_section',
            'type' => 'select',
            'choices' => $palette_choices,
        )
    );

    // Sub-menu Background Color
    $wp_customize->add_setting(
        'brainworks_sub_menu_bg_color',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_key',
            'type' => 'theme_mod',
        )
    );
    $wp_customize->add_control(
        'brainworks_sub_menu_bg_color',
        array(
            'label' => esc_html__('Sub-menu Background Color', 'brainworks'),
            'section' => 'theme_colors_section',
            'type' => 'select',
            'choices' => $palette_choices,
        )
    );

    $wp_customize->add_control(
        new Brainworks_Reset_Control(
            $wp_customize,
            'brainworks_reset_colors',
            array(
                'label' => esc_html__('Reset Theme Colors', 'brainworks'),
                'description' => esc_html__('Caution: This will reset only the theme palette, menu, buttons, and background colors to defaults.', 'brainworks'),
                'section' => 'theme_colors_section',
                'settings' => 'brainworks_reset_all',
                'reset_settings' => array(
                    'brainworks_theme_color_1',
                    'brainworks_theme_color_2',
                    'brainworks_theme_color_3',
                    'brainworks_theme_color_4',
                    'brainworks_theme_color_5',
                    'brainworks_theme_color_6',
                    'brainworks_theme_color_7',
                    'brainworks_main_menu_bg_color',
                    'brainworks_main_menu_text_color',
                    'brainworks_menu_accent_color',
                    'brainworks_main_menu_hover_bg',
                    'brainworks_main_menu_hover_text',
                    'brainworks_body_bg_color',
                    'brainworks_front_page_bg_color',
                    'brainworks_btn_primary_color_ref',
                    'brainworks_btn_secondary_color_ref',
                    'brainworks_btn_accent_color_ref',
                    'brainworks_woocommerce_color_ref',
                    'brainworks_sub_menu_bg_color',
                ),
                'priority' => 1000, // Ensure it's at the very bottom
            )
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'brainworks_main_logo',
            array(
                'label' => esc_html__('Main Logo', 'brainworks'),
                'description' => esc_html__('Recommended: use an image with transparent background for best results.', 'brainworks'),
                'section' => 'title_tagline',
                'mime_type' => 'image',
            )
        )
    );

    $wp_customize->add_setting(
        'brainworks_second_logo',
        array(
            'type' => 'theme_mod',
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'brainworks_second_logo',
            array(
                'label' => esc_html__('Second Logo', 'brainworks'),
                'description' => esc_html__('Optional second logo (e.g. for footer or dark variant).', 'brainworks'),
                'section' => 'title_tagline',
                'mime_type' => 'image',
            )
        )
    );

    // Секция Phones: 6 номеров, для каждого — поле класса и иконка.
    $wp_customize->add_section(
        'brainworks_phones',
        array(
            'title' => esc_html__('Phones', 'brainworks'),
            'priority' => isset($priorities['brainworks_phones']) ? $priorities['brainworks_phones'] : 40,
        )
    );
    for ($i = 1; $i <= 6; $i++) {
        $wp_customize->add_setting(
            'brainworks_phone_' . $i,
            array(
                'type' => 'theme_mod',
                'sanitize_callback' => 'wp_kses_post', // Allow HTML (e.g. <b>)
            )
        );
        $wp_customize->add_control(
            'brainworks_phone_' . $i,
            array(
                'label' => sprintf( /* translators: 1: number 1-6 */ esc_html__('Phone %d', 'brainworks'), $i),
                'section' => 'brainworks_phones',
                'type' => 'text',
                'input_attrs' => array(
                    'placeholder' => '+38 (063) 20-37-130',
                ),
            )
        );
        $wp_customize->add_setting(
            'brainworks_phone_' . $i . '_desc',
            array(
                'type' => 'theme_mod',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        $wp_customize->add_control(
            'brainworks_phone_' . $i . '_desc',
            array(
                'label' => sprintf( /* translators: 1: number 1-6 */ esc_html__('Phone %d — Description', 'brainworks'), $i),
                'description' => esc_html__('Text displayed next to the number (e.g. Manager Name).', 'brainworks'),
                'section' => 'brainworks_phones',
                'type' => 'text',
            )
        );
        $wp_customize->add_setting(
            'brainworks_phone_' . $i . '_class',
            array(
                'type' => 'theme_mod',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        $wp_customize->add_control(
            'brainworks_phone_' . $i . '_class',
            array(
                'label' => sprintf( /* translators: 1: number 1-6 */ esc_html__('Phone %d — CSS class for link', 'brainworks'), $i),
                'section' => 'brainworks_phones',
                'type' => 'text',
                'input_attrs' => array(
                    'placeholder' => 'my-phone-link',
                ),
            )
        );
        $wp_customize->add_setting(
            'brainworks_phone_' . $i . '_icon',
            array(
                'type' => 'theme_mod',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Media_Control(
                $wp_customize,
                'brainworks_phone_' . $i . '_icon',
                array(
                    'label' => sprintf( /* translators: 1: number 1-6 */ esc_html__('Phone %d — icon (image before number)', 'brainworks'), $i),
                    'description' => esc_html__('e.g. mobile operator icon.', 'brainworks'),
                    'section' => 'brainworks_phones',
                    'mime_type' => 'image',
                )
            )
        );
    }

    // Секция Social: 10 ссылок на соцсети, для каждой — иконка (изображение).
    $wp_customize->add_section(
        'brainworks_social',
        array(
            'title' => esc_html__('Social', 'brainworks'),
            'priority' => isset($priorities['brainworks_social']) ? $priorities['brainworks_social'] : 41,
        )
    );
    for ($i = 1; $i <= 10; $i++) {
        $wp_customize->add_setting(
            'brainworks_social_' . $i,
            array(
                'type' => 'theme_mod',
                'sanitize_callback' => 'esc_url_raw',
            )
        );
        $wp_customize->add_control(
            'brainworks_social_' . $i,
            array(
                'label' => sprintf( /* translators: 1: number 1-10 */ esc_html__('Social link %d (URL)', 'brainworks'), $i),
                'section' => 'brainworks_social',
                'type' => 'url',
                'input_attrs' => array(
                    'placeholder' => 'https://facebook.com/...',
                ),
            )
        );
        $wp_customize->add_setting(
            'brainworks_social_' . $i . '_icon',
            array(
                'type' => 'theme_mod',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Media_Control(
                $wp_customize,
                'brainworks_social_' . $i . '_icon',
                array(
                    'label' => sprintf( /* translators: 1: number 1-10 */ esc_html__('Social link %d — icon (image)', 'brainworks'), $i),
                    'description' => esc_html__('Icon displayed for this link. Recommended: square image, same size for all.', 'brainworks'),
                    'section' => 'brainworks_social',
                    'mime_type' => 'image',
                )
            )
        );
    }

    // Секция «Кнопка „Наверх"» (Scroll to Top).
    $wp_customize->add_section(
        'brainworks_scroll_to_top',
        array(
            'title' => esc_html__('Back to Top Button', 'brainworks'),
            'priority' => isset($priorities['brainworks_scroll_to_top']) ? $priorities['brainworks_scroll_to_top'] : 24,
        )
    );
    $wp_customize->add_setting(
        'brainworks_scroll_to_top_enabled',
        array(
            'type' => 'theme_mod',
            'default' => '1',
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'brainworks_scroll_to_top_enabled',
        array(
            'label' => esc_html__('Show button', 'brainworks'),
            'section' => 'brainworks_scroll_to_top',
            'type' => 'checkbox',
        )
    );
    $wp_customize->add_setting(
        'brainworks_scroll_to_top_position',
        array(
            'type' => 'theme_mod',
            'default' => 'bottom-right',
            'sanitize_callback' => function ($v) {
                return in_array($v, array('bottom-right', 'bottom-left'), true) ? $v : 'bottom-right';
            },
        )
    );
    $wp_customize->add_control(
        'brainworks_scroll_to_top_position',
        array(
            'label' => esc_html__('Position', 'brainworks'),
            'section' => 'brainworks_scroll_to_top',
            'type' => 'select',
            'choices' => array(
                'bottom-right' => esc_html__('Bottom right', 'brainworks'),
                'bottom-left' => esc_html__('Bottom left', 'brainworks'),
            ),
        )
    );
    $wp_customize->add_setting(
        'brainworks_scroll_to_top_style',
        array(
            'type' => 'theme_mod',
            'default' => 'circle',
            'sanitize_callback' => function ($v) {
                return in_array($v, array('circle', 'square', 'rounded'), true) ? $v : 'circle';
            },
        )
    );
    $wp_customize->add_control(
        'brainworks_scroll_to_top_style',
        array(
            'label' => esc_html__('Button style', 'brainworks'),
            'section' => 'brainworks_scroll_to_top',
            'type' => 'select',
            'choices' => array(
                'circle' => esc_html__('Circle', 'brainworks'),
                'square' => esc_html__('Square', 'brainworks'),
                'rounded' => esc_html__('Rounded', 'brainworks'),
            ),
        )
    );
    $wp_customize->add_setting(
        'brainworks_scroll_to_top_size',
        array(
            'type' => 'theme_mod',
            'default' => 'medium',
            'sanitize_callback' => function ($v) {
                return in_array($v, array('small', 'medium', 'large'), true) ? $v : 'medium';
            },
        )
    );
    $wp_customize->add_control(
        'brainworks_scroll_to_top_size',
        array(
            'label' => esc_html__('Size', 'brainworks'),
            'section' => 'brainworks_scroll_to_top',
            'type' => 'select',
            'choices' => array(
                'small' => esc_html__('Small', 'brainworks'),
                'medium' => esc_html__('Medium', 'brainworks'),
                'large' => esc_html__('Large', 'brainworks'),
            ),
        )
    );
    $wp_customize->add_setting(
        'brainworks_scroll_to_top_arrow',
        array(
            'type' => 'theme_mod',
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'brainworks_scroll_to_top_arrow',
            array(
                'label' => esc_html__('Custom arrow (image)', 'brainworks'),
                'description' => esc_html__('Optional. If not set, default arrow is used.', 'brainworks'),
                'section' => 'brainworks_scroll_to_top',
                'mime_type' => 'image',
            )
        )
    );

    // Button Background Color
    $wp_customize->add_setting(
        'brainworks_scroll_to_top_bg_color',
        array(
            'type' => 'theme_mod',
            'default' => '#333333',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'brainworks_scroll_to_top_bg_color',
            array(
                'label' => esc_html__('Button Background Color', 'brainworks'),
                'section' => 'brainworks_scroll_to_top',
            )
        )
    );

    // Button Icon Color
    $wp_customize->add_setting(
        'brainworks_scroll_to_top_icon_color',
        array(
            'type' => 'theme_mod',
            'default' => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'brainworks_scroll_to_top_icon_color',
            array(
                'label' => esc_html__('Button Icon Color', 'brainworks'),
                'section' => 'brainworks_scroll_to_top',
            )
        )
    );

    // Секция для сторонних кодов (аналитика и т.д.).
    $wp_customize->add_section(
        'brainworks_scripts',
        array(
            'title' => esc_html__('Third-party Codes', 'brainworks'),
            'priority' => apply_filters('brainworks_customizer_section_priority', 200, 'brainworks_scripts'),
        )
    );

    for ($i = 1; $i <= 6; $i++) {
        // Выбор места вставки
        $wp_customize->add_setting(
            'brainworks_script_placement_' . $i,
            array(
                'type' => 'theme_mod',
                'default' => 'head',
                'sanitize_callback' => function ($v) {
                    return in_array($v, array('head', 'body', 'footer'), true) ? $v : 'head';
                },
            )
        );
        $wp_customize->add_control(
            'brainworks_script_placement_' . $i,
            array(
                'label' => sprintf(esc_html__('Placement #%d', 'brainworks'), $i),
                'section' => 'brainworks_scripts',
                'type' => 'select',
                'choices' => array(
                    'head' => 'head',
                    'body' => 'body',
                    'footer' => 'footer',
                ),
            )
        );

        // Поле для самого кода
        $wp_customize->add_setting(
            'brainworks_script_code_' . $i,
            array(
                'type' => 'theme_mod',
                'sanitize_callback' => 'kses_post_raw', // renamed to avoid conflict
            )
        );
        $wp_customize->add_control(
            'brainworks_script_code_' . $i,
            array(
                'label' => sprintf(esc_html__('Code #%d', 'brainworks'), $i),
                'section' => 'brainworks_scripts',
                'type' => 'textarea',
            )
        );
    }

    // Секция для кастомизации страницы входа.
    $wp_customize->add_section(
        'brainworks_login',
        array(
            'title' => esc_html__('Login Page', 'brainworks'),
            'priority' => apply_filters('brainworks_customizer_section_priority', 210, 'brainworks_login'),
        )
    );

    // Логотип для входа
    $wp_customize->add_setting(
        'brainworks_login_logo',
        array(
            'type' => 'theme_mod',
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'brainworks_login_logo',
            array(
                'label' => esc_html__('Login Logo', 'brainworks'),
                'section' => 'brainworks_login',
                'mime_type' => 'image',
            )
        )
    );

    // Фоновое изображение
    $wp_customize->add_setting(
        'brainworks_login_bg',
        array(
            'type' => 'theme_mod',
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        new WP_Customize_Media_Control(
            $wp_customize,
            'brainworks_login_bg',
            array(
                'label' => esc_html__('Background Image', 'brainworks'),
                'section' => 'brainworks_login',
                'mime_type' => 'image',
            )
        )
    );

    // Background Repeat
    $wp_customize->add_setting(
        'brainworks_login_bg_repeat',
        array(
            'type' => 'theme_mod',
            'default' => 'no-repeat',
            'sanitize_callback' => function ($v) {
                return in_array($v, array('no-repeat', 'repeat'), true) ? $v : 'no-repeat';
            },
        )
    );
    $wp_customize->add_control(
        'brainworks_login_bg_repeat',
        array(
            'label' => esc_html__('Background Repeat', 'brainworks'),
            'section' => 'brainworks_login',
            'type' => 'select',
            'choices' => array(
                'no-repeat' => 'No Repeat',
                'repeat' => 'Repeat',
            ),
        )
    );

    // Background Size
    $wp_customize->add_setting(
        'brainworks_login_bg_size',
        array(
            'type' => 'theme_mod',
            'default' => 'cover',
            'sanitize_callback' => function ($v) {
                return in_array($v, array('cover', 'contain', 'auto'), true) ? $v : 'cover';
            },
        )
    );
    $wp_customize->add_control(
        'brainworks_login_bg_size',
        array(
            'label' => esc_html__('Background Size', 'brainworks'),
            'section' => 'brainworks_login',
            'type' => 'select',
            'choices' => array(
                'cover' => 'Cover',
                'contain' => 'Contain',
                'auto' => 'Auto',
            ),
        )
    );

    // Background Position
    $wp_customize->add_setting(
        'brainworks_login_bg_position',
        array(
            'type' => 'theme_mod',
            'default' => 'center center',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'brainworks_login_bg_position',
        array(
            'label' => esc_html__('Background Position', 'brainworks'),
            'section' => 'brainworks_login',
            'type' => 'select',
            'choices' => array(
                'center center' => 'Center Center',
                'top center' => 'Top Center',
                'bottom center' => 'Bottom Center',
                'left center' => 'Left Center',
                'right center' => 'Right Center',
            ),
        )
    );

    // Background Attachment
    $wp_customize->add_setting(
        'brainworks_login_bg_attachment',
        array(
            'type' => 'theme_mod',
            'default' => 'fixed',
            'sanitize_callback' => function ($v) {
                return in_array($v, array('fixed', 'scroll'), true) ? $v : 'fixed';
            },
        )
    );
    $wp_customize->add_control(
        'brainworks_login_bg_attachment',
        array(
            'label' => esc_html__('Background Attachment', 'brainworks'),
            'section' => 'brainworks_login',
            'type' => 'select',
            'choices' => array(
                'fixed' => 'Fixed',
                'scroll' => 'Scroll',
            ),
        )
    );

    // Секция для мессенджеров.
    $wp_customize->add_section(
        'brainworks_messengers',
        array(
            'title' => esc_html__('Messengers', 'brainworks'),
            'priority' => isset($priorities['brainworks_messengers']) ? $priorities['brainworks_messengers'] : 42,
        )
    );

    foreach (array('whatsapp', 'telegram', 'viber', 'skype', 'facebook-messenger') as $messenger) {
        // Link/Number
        $wp_customize->add_setting(
            'brainworks_messenger_' . $messenger,
            array(
                'type' => 'theme_mod',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );
        $wp_customize->add_control(
            'brainworks_messenger_' . $messenger,
            array(
                'label' => sprintf(esc_html__('%s Link/Number', 'brainworks'), ucfirst($messenger)),
                'section' => 'brainworks_messengers',
                'type' => 'text',
            )
        );

        // Icon
        $wp_customize->add_setting(
            'brainworks_messenger_' . $messenger . '_icon',
            array(
                'type' => 'theme_mod',
                'sanitize_callback' => 'absint',
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Media_Control(
                $wp_customize,
                'brainworks_messenger_' . $messenger . '_icon',
                array(
                    'label' => sprintf(esc_html__('%s Icon', 'brainworks'), ucfirst($messenger)),
                    'section' => 'brainworks_messengers',
                    'mime_type' => 'image',
                )
            )
        );
    }



    // Sidebar Section
    $wp_customize->add_section(
        'brainworks_sidebar',
        array(
            'title' => esc_html__('Sidebar', 'brainworks'),
            'priority' => isset($priorities['brainworks_sidebar']) ? $priorities['brainworks_sidebar'] : 23,
        )
    );

    // Sticky Sidebar Checkbox
    $wp_customize->add_setting(
        'brainworks_sidebar_sticky',
        array(
            'default' => false,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'brainworks_sidebar_sticky',
        array(
            'label' => esc_html__('Sticky Sidebar', 'brainworks'),
            'section' => 'brainworks_sidebar',
            'type' => 'checkbox',
        )
    );

    // Sidebar visibility on Single Post
    $wp_customize->add_setting(
        'brainworks_single_sidebar_left',
        array(
            'default' => false,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'brainworks_single_sidebar_left',
        array(
            'label' => esc_html__('Show Left Sidebar on Single Post', 'brainworks'),
            'section' => 'brainworks_sidebar',
            'type' => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'brainworks_single_sidebar_right',
        array(
            'default' => false,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'brainworks_single_sidebar_right',
        array(
            'label' => esc_html__('Show Right Sidebar on Single Post', 'brainworks'),
            'section' => 'brainworks_sidebar',
            'type' => 'checkbox',
        )
    );

    // Sidebar visibility on Archives
    $wp_customize->add_setting(
        'brainworks_archive_sidebar_left',
        array(
            'default' => false,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'brainworks_archive_sidebar_left',
        array(
            'label' => esc_html__('Show Left Sidebar on Archive/Blog', 'brainworks'),
            'section' => 'brainworks_sidebar',
            'type' => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'brainworks_archive_sidebar_right',
        array(
            'default' => false,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'brainworks_archive_sidebar_right',
        array(
            'label' => esc_html__('Show Right Sidebar on Archive/Blog', 'brainworks'),
            'section' => 'brainworks_sidebar',
            'type' => 'checkbox',
        )
    );

    // Offset - Large Screens (>1200px)
    $wp_customize->add_setting(
        'brainworks_sidebar_offset_lg',
        array(
            'default' => 20,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'brainworks_sidebar_offset_lg',
        array(
            'label' => esc_html__('Top Offset (Desktop > 1200px)', 'brainworks'),
            'section' => 'brainworks_sidebar',
            'type' => 'number',
        )
    );

    // Offset - Laptop Screens (>992px)
    $wp_customize->add_setting(
        'brainworks_sidebar_offset_md',
        array(
            'default' => 20,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'brainworks_sidebar_offset_md',
        array(
            'label' => esc_html__('Top Offset (Laptop > 992px)', 'brainworks'),
            'section' => 'brainworks_sidebar',
            'type' => 'number',
        )
    );

    // Offset - Tablet Screens (>768px)
    $wp_customize->add_setting(
        'brainworks_sidebar_offset_sm',
        array(
            'default' => 20,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'brainworks_sidebar_offset_sm',
        array(
            'label' => esc_html__('Top Offset (Tablet > 768px)', 'brainworks'),
            'section' => 'brainworks_sidebar',
            'type' => 'number',
        )
    );

    // Offset - Mobile Screens (<768px)
    $wp_customize->add_setting(
        'brainworks_sidebar_offset_xs',
        array(
            'default' => 20,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'brainworks_sidebar_offset_xs',
        array(
            'label' => esc_html__('Top Offset (Phone < 768px)', 'brainworks'),
            'section' => 'brainworks_sidebar',
            'type' => 'number',
        )
    );

    // Extra Offset when Sticky Header is Enabled (Scroll Trigger)
    $wp_customize->add_setting(
        'brainworks_sidebar_header_offset',
        array(
            'default' => 0,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'brainworks_sidebar_header_offset',
        array(
            'label' => esc_html__('Additional Offset for Sticky Header (Scroll Trigger)', 'brainworks'),
            'description' => esc_html__('Scroll depth (px) before sidebar becomes sticky.', 'brainworks'),
            'section' => 'brainworks_sidebar',
            'type' => 'number',
        )
    );

    // Sticky Top Offset Delta (How much lower when sticky)
    $wp_customize->add_setting(
        'brainworks_sidebar_sticky_top_offset',
        array(
            'default' => 0,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'brainworks_sidebar_sticky_top_offset',
        array(
            'label' => esc_html__('Sticky Top Offset (px)', 'brainworks'),
            'description' => esc_html__('How much lower the sidebar should be when sticky.', 'brainworks'),
            'section' => 'brainworks_sidebar',
            'type' => 'number',
        )
    );

    // Sidebar Menu Widget Colors (.bw-theme-menu)
    // Background
    $wp_customize->add_setting(
        'brainworks_sidebar_menu_bg_color',
        array(
            'type' => 'theme_mod',
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'brainworks_sidebar_menu_bg_color',
        array(
            'label' => esc_html__('Sidebar Menu Background (.bw-theme-menu)', 'brainworks'),
            'section' => 'theme_colors_section',
            'type' => 'select',
            'choices' => $palette_choices,
        )
    );

    // Text
    $wp_customize->add_setting(
        'brainworks_sidebar_menu_text_color',
        array(
            'type' => 'theme_mod',
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'brainworks_sidebar_menu_text_color',
        array(
            'label' => esc_html__('Sidebar Menu Text (.bw-theme-menu)', 'brainworks'),
            'section' => 'theme_colors_section',
            'type' => 'select',
            'choices' => $palette_choices,
        )
    );

    // Border/Accent
    $wp_customize->add_setting(
        'brainworks_sidebar_menu_border_color',
        array(
            'type' => 'theme_mod',
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'brainworks_sidebar_menu_border_color',
        array(
            'label' => esc_html__('Sidebar Menu Border & Accent (.bw-theme-menu)', 'brainworks'),
            'section' => 'theme_colors_section',
            'type' => 'select',
            'choices' => $palette_choices,
        )
    );





    // Fonts Section
    $wp_customize->add_section(
        'brainworks_fonts',
        array(
            'title' => esc_html__('Fonts', 'brainworks'),
            'priority' => isset($priorities['brainworks_fonts']) ? $priorities['brainworks_fonts'] : 26,
        )
    );

    $google_fonts = brainworks_get_google_fonts();

    // Header Font
    $wp_customize->add_setting(
        'brainworks_header_font',
        array(
            'type' => 'theme_mod',
            'default' => 'Roboto',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'brainworks_header_font',
        array(
            'label' => esc_html__('Header Font', 'brainworks'),
            'description' => esc_html__('Applied to h1-h6 tags.', 'brainworks'),
            'section' => 'brainworks_fonts',
            'type' => 'select',
            'choices' => $google_fonts,
        )
    );

    // Body Font
    $wp_customize->add_setting(
        'brainworks_body_font',
        array(
            'type' => 'theme_mod',
            'default' => 'Roboto',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control(
        'brainworks_body_font',
        array(
            'label' => esc_html__('Body Font', 'brainworks'),
            'description' => esc_html__('Applied to body and other text elements.', 'brainworks'),
            'section' => 'brainworks_fonts',
            'type' => 'select',
            'choices' => $google_fonts,
        )
    );





    // Sticky Header Section
    $wp_customize->add_section(
        'brainworks_sticky_header',
        array(
            'title' => esc_html__('Sticky Header', 'brainworks'),
            'priority' => isset($priorities['brainworks_sticky_header']) ? $priorities['brainworks_sticky_header'] : 22,
        )
    );

    $wp_customize->add_setting(
        'brainworks_header_sticky',
        array(
            'default' => false,
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(
        'brainworks_header_sticky',
        array(
            'label' => esc_html__('Enable Sticky Header', 'brainworks'),
            'section' => 'brainworks_sticky_header',
            'type' => 'checkbox',
        )
    );

    // -----------------------------------------------------------------------
    // WooCommerce Icons Section ([woo_icons] shortcode)
    // -----------------------------------------------------------------------
    if (class_exists('WooCommerce')) {
        $wp_customize->add_section(
            'brainworks_woo_icons',
            array(
                'title' => esc_html__('WooCommerce Icons', 'brainworks'),
                'priority' => 43,
                'description' => esc_html__('Custom icons for the [woo_icons] shortcode. If not set, built-in SVG icons are used.', 'brainworks'),
            )
        );

        // Account icon
        $wp_customize->add_setting(
            'brainworks_woo_icon_account',
            array(
                'type' => 'theme_mod',
                'sanitize_callback' => 'absint',
                'default' => 0,
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Media_Control(
                $wp_customize,
                'brainworks_woo_icon_account',
                array(
                    'label' => esc_html__('Account Icon', 'brainworks'),
                    'description' => esc_html__('Icon for the "My Account" link. Recommended: SVG or PNG with transparent background.', 'brainworks'),
                    'section' => 'brainworks_woo_icons',
                    'mime_type' => 'image',
                )
            )
        );

        // Cart icon
        $wp_customize->add_setting(
            'brainworks_woo_icon_cart',
            array(
                'type' => 'theme_mod',
                'sanitize_callback' => 'absint',
                'default' => 0,
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Media_Control(
                $wp_customize,
                'brainworks_woo_icon_cart',
                array(
                    'label' => esc_html__('Cart Icon', 'brainworks'),
                    'description' => esc_html__('Icon for the Cart link. Recommended: SVG or PNG with transparent background.', 'brainworks'),
                    'section' => 'brainworks_woo_icons',
                    'mime_type' => 'image',
                )
            )
        );

        // Icon size (px)
        $wp_customize->add_setting(
            'brainworks_woo_icon_size',
            array(
                'type' => 'theme_mod',
                'sanitize_callback' => 'absint',
                'default' => 22,
            )
        );
        $wp_customize->add_control(
            'brainworks_woo_icon_size',
            array(
                'label' => esc_html__('Icon Size (px)', 'brainworks'),
                'description' => esc_html__('Size of the custom icon inside the circle (applies only when custom icons are set).', 'brainworks'),
                'section' => 'brainworks_woo_icons',
                'type' => 'number',
                'input_attrs' => array(
                    'min' => 12,
                    'max' => 60,
                    'step' => 1,
                ),
            )
        );

        // Border width (px)
        $wp_customize->add_setting(
            'brainworks_woo_icon_border_width',
            array(
                'type' => 'theme_mod',
                'sanitize_callback' => 'absint',
                'default' => 2,
            )
        );
        $wp_customize->add_control(
            'brainworks_woo_icon_border_width',
            array(
                'label' => esc_html__('Border Width (px)', 'brainworks'),
                'description' => esc_html__('Thickness of the circle border around icons. Set 0 to hide.', 'brainworks'),
                'section' => 'brainworks_woo_icons',
                'type' => 'number',
                'input_attrs' => array(
                    'min' => 0,
                    'max' => 6,
                    'step' => 1,
                ),
            )
        );

        // Border color
        $wp_customize->add_setting(
            'brainworks_woo_icon_border_color',
            array(
                'type' => 'theme_mod',
                'sanitize_callback' => 'sanitize_hex_color',
                'default' => '',
            )
        );
        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                'brainworks_woo_icon_border_color',
                array(
                    'label' => esc_html__('Border Color', 'brainworks'),
                    'section' => 'brainworks_woo_icons',
                )
            )
        );
    }

    $wp_customize->add_setting(
        'brainworks_reset_all',
        array(
            'type' => 'theme_mod',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
}

function kses_post_raw($data)
{
    return $data; // For raw code pieces (scripts/styles), we often want to bypass basic sanitization to avoid breaking tags like <script> or <style>.
}
add_action('customize_register', 'brainworks_customize_register');

/**
 * Вывод кнопки «Наверх» (вызывается из wp_footer).
 */
function brainworks_render_scroll_to_top_button()
{
    if (!get_theme_mod('brainworks_scroll_to_top_enabled', 1)) {
        return;
    }
    $position = get_theme_mod('brainworks_scroll_to_top_position', 'bottom-right');
    $style = get_theme_mod('brainworks_scroll_to_top_style', 'circle');
    $size = get_theme_mod('brainworks_scroll_to_top_size', 'medium');
    $arrow_id = (int) get_theme_mod('brainworks_scroll_to_top_arrow', 0);

    $classes = array(
        'scroll-to-top',
        'scroll-to-top--' . $position,
        'scroll-to-top--' . $style,
        'scroll-to-top--' . $size,
    );
    $class = implode(' ', $classes);

    $arrow_html = '';
    if ($arrow_id) {
        $arrow_html = wp_get_attachment_image($arrow_id, 'thumbnail', false, array('class' => 'scroll-to-top__arrow', 'alt' => ''));
    }
    if ($arrow_html === '') {
        $arrow_html = '<span class="scroll-to-top__arrow scroll-to-top__arrow--default" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"/></svg></span>';
    }

    echo '<a href="#" id="scroll-to-top" class="' . esc_attr($class) . '" aria-label="' . esc_attr__('Back to top', 'brainworks') . '">' . $arrow_html . '</a>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    // Custom colors
    $bg_color = get_theme_mod('brainworks_scroll_to_top_bg_color', '#333333');
    $icon_color = get_theme_mod('brainworks_scroll_to_top_icon_color', '#ffffff');
    if ($bg_color !== '#333333' || $icon_color !== '#ffffff') {
        echo '<style type="text/css">';
        echo '#scroll-to-top { background-color: ' . esc_attr($bg_color) . ' !important; color: ' . esc_attr($icon_color) . ' !important; }';
        echo '#scroll-to-top:hover { filter: brightness(0.85); }';
        echo '</style>';
    }
}
add_action('wp_footer', 'brainworks_render_scroll_to_top_button', 10); // earlier to ensure HTML is present for scripts

/**
 * Output third-party codes based on their selected placement.
 */
function brainworks_render_custom_codes()
{
    $current_hook = current_action();
    $placement_map = array(
        'wp_head' => 'head',
        'wp_body_open' => 'body',
        'wp_footer' => 'footer'
    );

    $placement = isset($placement_map[$current_hook]) ? $placement_map[$current_hook] : '';

    if (!$placement) {
        return;
    }

    for ($i = 1; $i <= 6; $i++) {
        $code = get_theme_mod('brainworks_script_code_' . $i, '');
        $code_placement = get_theme_mod('brainworks_script_placement_' . $i, 'head');

        if (!empty($code) && $code_placement === $placement) {
            echo $code . "\n";
        }
    }
}
add_action('wp_head', 'brainworks_render_custom_codes', 100);
add_action('wp_body_open', 'brainworks_render_custom_codes', 100);
add_action('wp_footer', 'brainworks_render_custom_codes', 100);

/**
 * Output custom CSS for the Customizer settings.
 */
function brainworks_customizer_css()
{
    // Since we now use CSS variables mapped to theme colors, we might not need this inline style block for menu colors
    // if the CSS uses var(--main-menu-bg) etc.
    // However, for consistency and fallback, we can perform the mapping here too.

    $menu_bg_ref = get_theme_mod('brainworks_main_menu_bg_color', '');
    $menu_color_ref = get_theme_mod('brainworks_main_menu_text_color', '');
    $menu_accent_ref = get_theme_mod('brainworks_menu_accent_color', '');
    $sub_menu_bg_ref = get_theme_mod('brainworks_sub_menu_bg_color', '');

    // Helper to map color_X to var number
    $get_var_name = function ($ref) {
        if (empty($ref)) {
            return false;
        }
        $map = array(
            'color_1' => '--theme-color-1',
            'color_2' => '--theme-color-2',
            'color_3' => '--theme-color-3',
            'color_4' => '--theme-color-4',
            'color_5' => '--theme-color-5',
            'color_6' => '--theme-color-6',
            'color_7' => '--theme-color-7',
        );
        return isset($map[$ref]) ? "var(" . $map[$ref] . ")" : false;
    };

    $menu_bg = $get_var_name($menu_bg_ref);
    $menu_color = $get_var_name($menu_color_ref);
    $menu_accent = $get_var_name($menu_accent_ref);
    $sub_menu_bg = $get_var_name($sub_menu_bg_ref);

    $css = '';

    // Layout and utility styles (Previously combined with broken color overrides)


    $css .= "
    .main-navigation { position: relative; }
    .main-navigation .menu {
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }
    /* Menu Arrows */
    .menu-item-has-children > a {
        display: flex;
        align-items: center;
    }
    .menu-item-has-children > a::after {
        content: '';
        display: inline-block;
        margin-left: 0.5em;
        width: 0;
        height: 0;
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-top: 4px solid currentColor;
        opacity: 0.7;
        transform: translateY(1px);
    }

    /* layout and arrows remain here */
    ";
    // Sidebar Menu Colors (.bw-theme-menu only)
    $sidebar_menu_bg_ref = get_theme_mod('brainworks_sidebar_menu_bg_color', '');
    $sidebar_menu_text_ref = get_theme_mod('brainworks_sidebar_menu_text_color', '');
    $sidebar_menu_border_ref = get_theme_mod('brainworks_sidebar_menu_border_color', '');

    $sidebar_menu_bg = $get_var_name($sidebar_menu_bg_ref);
    $sidebar_menu_text = $get_var_name($sidebar_menu_text_ref);
    $sidebar_menu_border = $get_var_name($sidebar_menu_border_ref);

    if ($sidebar_menu_bg || $sidebar_menu_text) {
        $bg_rule = $sidebar_menu_bg ? "background-color: {$sidebar_menu_bg}; " : "";
        $text_rule = $sidebar_menu_text ? "color: {$sidebar_menu_text};" : "";
        $css .= ".bw-theme-menu { {$bg_rule}{$text_rule} }\n";
    }
    if ($sidebar_menu_text) {
        $css .= ".bw-theme-menu ul li a { color: {$sidebar_menu_text}; }\n";
    }
    if ($sidebar_menu_border) {
        $css .= ".bw-theme-menu ul li, .bw-theme-menu .sub-menu, .bw-theme-menu .sub-menu li { border-color: {$sidebar_menu_border}; }\n";
        $css .= ".bw-theme-menu .menu-toggle { color: {$sidebar_menu_border}; }\n";
        $css .= ".bw-theme-menu .menu-toggle::before { border-color: {$sidebar_menu_border}; }\n";
    }

    // Sticky Header CSS
    if (get_theme_mod('brainworks_header_sticky', false)) {
        $css .= "
        .site-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: #fff; /* Ensure background is solid when sticking */
            width: 100%;
        }
        .admin-bar .site-header {
            top: 32px;
        }
        @media screen and (max-width: 782px) {
            .admin-bar .site-header { top: 46px; }
        }
        ";
    }

    // WooCommerce Icons: border width & color
    $woo_border_width = absint(get_theme_mod('brainworks_woo_icon_border_width', 2));
    $woo_border_color = get_theme_mod('brainworks_woo_icon_border_color', '');
    $woo_border_color = !empty($woo_border_color) ? esc_attr($woo_border_color) : 'currentColor';

    $css .= ".woo-icons__icon-wrap { border-width: {$woo_border_width}px; border-color: {$woo_border_color}; }\n";
    if ($woo_border_width === 0) {
        $css .= ".woo-icons__icon-wrap { border-style: none; }\n";
    }

    if (!empty($css)) {
        echo '<style type="text/css" id="brainworks-custom-css">' . $css . '</style>';
    }
}
add_action('wp_head', 'brainworks_customizer_css');


