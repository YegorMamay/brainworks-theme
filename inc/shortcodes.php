<?php
/**
 * Shortcodes: [phones], [social], [messengers], [main_logo], [second_logo].
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Шорткод [phones] — вывод телефонов из настроек темы.
 * Атрибут format: list | column | dropdown.
 * Атрибуты dropdown_bg и dropdown_color задают цвет фона и текста выпадающего списка.
 * Используется как inline CSS-переменные: --phones-dropdown-bg, --phones-dropdown-color.
 * Пример: [phones format="dropdown" dropdown_bg="#1a1a1a" dropdown_color="#ffffff"]
 */
function shortcode_phones($atts)
{
    $atts = shortcode_atts(
        array(
            'format' => 'list',
            'class' => '',
            'dropdown_bg' => '',
            'dropdown_color' => '',
        ),
        $atts,
        'phones'
    );
    $phones = brainworks_get_phones_data();
    if (empty($phones)) {
        return '';
    }
    $format = strtolower($atts['format']);
    if (!in_array($format, array('list', 'column', 'dropdown'), true)) {
        $format = 'list';
    }
    $wrapper_class = 'phones phones--' . $format;
    if (!empty($atts['class'])) {
        $wrapper_class .= ' ' . esc_attr($atts['class']);
    }

    // Inline CSS variables for dropdown colours
    $style_parts = array();
    if (!empty($atts['dropdown_bg'])) {
        $style_parts[] = '--phones-dropdown-bg:' . esc_attr($atts['dropdown_bg']);
    }
    if (!empty($atts['dropdown_color'])) {
        $style_parts[] = '--phones-dropdown-color:' . esc_attr($atts['dropdown_color']);
    }
    $wrapper_style = !empty($style_parts) ? ' style="' . implode(';', $style_parts) . '"' : '';

    $icon_size = 'thumbnail';
    $out = '';
    if ($format === 'list') {
        $out .= '<ul class="' . esc_attr($wrapper_class) . '"' . $wrapper_style . '>';
        foreach ($phones as $item) {
            $link_class = 'phones__link';
            if (!empty($item['class'])) {
                $link_class .= ' ' . esc_attr($item['class']);
            }
            $icon_html = '';
            if ($item['icon_id']) {
                $icon_html = wp_get_attachment_image($item['icon_id'], $icon_size, false, array('class' => 'phones__icon'));
                if ($icon_html) {
                    $icon_html = '<span class="phones__icon-wrap">' . $icon_html . '</span>';
                }
            }
            $desc_html = '';
            if (!empty($item['desc'])) {
                $desc_html = ' <span class="phones__desc">' . esc_html($item['desc']) . '</span>';
            }
            // number is validated with wp_kses_post on save
            $out .= '<li class="phones__item"><a href="tel:' . esc_attr($item['tel']) . '" class="' . esc_attr($link_class) . '">' . $icon_html . '<span class="phones__number">' . $item['number'] . '</span>' . $desc_html . '</a></li>';
        }
        $out .= '</ul>';
    } elseif ($format === 'column') {
        $out .= '<div class="' . esc_attr($wrapper_class) . '"' . $wrapper_style . '>';
        foreach ($phones as $item) {
            $link_class = 'phones__link';
            if (!empty($item['class'])) {
                $link_class .= ' ' . esc_attr($item['class']);
            }
            $icon_html = '';
            if ($item['icon_id']) {
                $icon_html = wp_get_attachment_image($item['icon_id'], $icon_size, false, array('class' => 'phones__icon'));
                if ($icon_html) {
                    $icon_html = '<span class="phones__icon-wrap">' . $icon_html . '</span>';
                }
            }
            $desc_html = '';
            if (!empty($item['desc'])) {
                $desc_html = ' <span class="phones__desc">' . esc_html($item['desc']) . '</span>';
            }
            $out .= '<a href="tel:' . esc_attr($item['tel']) . '" class="' . esc_attr($link_class) . '">' . $icon_html . '<span class="phones__number">' . $item['number'] . '</span>' . $desc_html . '</a>';
        }
        $out .= '</div>';
    } else {
        // dropdown: custom html
        $out .= '<div class="' . esc_attr($wrapper_class) . '"' . $wrapper_style . '>';

        // First phone (visible)
        $first = reset($phones);
        $others = array_slice($phones, 1);

        if ($first) {
            $icon_html = '';
            if ($first['icon_id']) {
                $icon_html = wp_get_attachment_image($first['icon_id'], $icon_size, false, array('class' => 'phones__icon'));
                if ($icon_html) {
                    $icon_html = '<span class="phones__icon-wrap">' . $icon_html . '</span>';
                }
            }
            $desc_html = '';
            if (!empty($first['desc'])) {
                $desc_html = ' <span class="phones__desc">' . esc_html($first['desc']) . '</span>';
            }

            $out .= '<div class="phones__current">';
            $out .= '<a href="tel:' . esc_attr($first['tel']) . '" class="phones__link">' . $icon_html . '<span class="phones__number">' . $first['number'] . '</span>' . $desc_html . '</a>';

            // Toggle button (only if there are other phones)
            if (!empty($others)) {
                $out .= '<button type="button" class="phones__toggle" aria-label="' . esc_attr__('Show other phones', 'brainworks') . '">';
                $out .= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>';
                $out .= '</button>';
            }
            $out .= '</div>'; // .phones__current
        }

        // Dropdown list (hidden by default)
        if (!empty($others)) {
            $out .= '<div class="phones__dropdown-list">';
            foreach ($others as $item) {
                $icon_html = '';
                if ($item['icon_id']) {
                    $icon_html = wp_get_attachment_image($item['icon_id'], $icon_size, false, array('class' => 'phones__icon'));
                    if ($icon_html) {
                        $icon_html = '<span class="phones__icon-wrap">' . $icon_html . '</span>';
                    }
                }
                $desc_html = '';
                if (!empty($item['desc'])) {
                    $desc_html = ' <span class="phones__desc">' . esc_html($item['desc']) . '</span>';
                }
                $out .= '<a href="tel:' . esc_attr($item['tel']) . '" class="phones__link phones__link--sub">' . $icon_html . '<span class="phones__number">' . $item['number'] . '</span>' . $desc_html . '</a>';
            }
            $out .= '</div>'; // .phones__dropdown-list
        }

        $out .= '</div>'; // .phones--dropdown

        // Simple JS to toggle dropdown
        $out .= "<script>
		(function() {
			var wrappers = document.querySelectorAll('.phones--dropdown');
			wrappers.forEach(function(wrapper) {
				var toggle = wrapper.querySelector('.phones__toggle');
				if (toggle) {
					toggle.addEventListener('click', function(e) {
						e.preventDefault();
						e.stopPropagation();
						wrapper.classList.toggle('is-open');
					});
				}
			});
			document.addEventListener('click', function(e) {
				wrappers.forEach(function(wrapper) {
					if (!wrapper.contains(e.target)) {
						wrapper.classList.remove('is-open');
					}
				});
			});
		})();
		</script>";
    }
    return $out;
}
add_shortcode('phones', 'shortcode_phones');

/**
 * Шорткод [social] — вывод ссылок на соцсети списком в один ряд (иконки, клик открывает в новом окне).
 * Атрибуты: class=""
 */
function shortcode_social($atts)
{
    $atts = shortcode_atts(
        array(
            'class' => '',
        ),
        $atts,
        'social'
    );
    $items = brainworks_get_social_data();
    if (empty($items)) {
        return '';
    }
    $wrapper_class = 'social-links';
    if (!empty($atts['class'])) {
        $wrapper_class .= ' ' . esc_attr($atts['class']);
    }
    $icon_size = 'thumbnail';
    $out = '<ul class="' . esc_attr($wrapper_class) . '">';
    foreach ($items as $item) {
        $icon_html = '';
        if ($item['icon_id']) {
            $icon_html = wp_get_attachment_image($item['icon_id'], $icon_size, false, array('class' => 'social-links__icon', 'loading' => 'lazy'));
        }
        if ($icon_html === '') {
            $icon_html = '<span class="social-links__placeholder">' . esc_html__('Link', 'brainworks') . '</span>';
        }
        $out .= '<li class="social-links__item"><a href="' . esc_url($item['url']) . '" class="social-links__link" target="_blank" rel="noopener noreferrer">' . $icon_html . '</a></li>';
    }
    $out .= '</ul>';
    return $out;
}
add_shortcode('social', 'shortcode_social');

/**
 * Шорткод [messengers] — вывод ссылок на мессенджеры.
 * Атрибуты: class=""
 */
function shortcode_messengers($atts)
{
    $atts = shortcode_atts(
        array(
            'class' => '',
        ),
        $atts,
        'messengers'
    );
    $items = brainworks_get_messengers_data();
    if (empty($items)) {
        return '';
    }
    $wrapper_class = 'messenger-links';
    if (!empty($atts['class'])) {
        $wrapper_class .= ' ' . esc_attr($atts['class']);
    }
    $icon_size = 'thumbnail';
    $out = '<ul class="' . esc_attr($wrapper_class) . '">';
    foreach ($items as $item) {
        $icon_html = '';
        if ($item['icon_id']) {
            $icon_html = wp_get_attachment_image($item['icon_id'], $icon_size, false, array('class' => 'messenger-links__icon', 'loading' => 'lazy'));
        }
        if ($icon_html === '') {
            $icon_html = '<span class="messenger-links__placeholder">' . esc_html(ucfirst($item['type'])) . '</span>';
        }

        $url = $item['url'];
        // Basic URL formatting for common messengers if only number is provided
        if ($item['type'] === 'whatsapp' && preg_match('/^\+?[0-9]{10,15}$/', $url)) {
            $url = 'https://wa.me/' . ltrim($url, '+');
        } elseif ($item['type'] === 'telegram' && !preg_match('/^https?:\/\//', $url)) {
            $url = 'https://t.me/' . ltrim($url, '@');
        } elseif ($item['type'] === 'viber' && preg_match('/^\+?[0-9]{10,15}$/', $url)) {
            $url = 'viber://chat?number=' . ltrim($url, '+');
        } elseif ($item['type'] === 'skype' && !preg_match('/^(https?:\/\/|skype:)/', $url)) {
            $url = 'skype:' . $url . '?chat';
        } elseif ($item['type'] === 'facebook-messenger' && !preg_match('/^https?:\/\//', $url)) {
            $url = 'https://m.me/' . ltrim($url, '@');
        }

        $out .= '<li class="messenger-links__item"><a href="' . esc_url($url) . '" class="messenger-links__link" target="_blank" rel="noopener noreferrer">' . $icon_html . '</a></li>';
    }
    $out .= '</ul>';
    return $out;
}
add_shortcode('messengers', 'shortcode_messengers');

/**
 * Шорткод [main_logo] — основной логотип.
 * Атрибуты: link="yes|no", size="full|medium|thumbnail", class=""
 */
function shortcode_logo($atts)
{
    $atts = shortcode_atts(
        array(
            'link' => 'yes',
            'size' => 'medium',
            'class' => '',
        ),
        $atts,
        'main_logo'
    );
    return brainworks_get_logo_html('main', array(
        'link' => ($atts['link'] === 'yes' || $atts['link'] === '1'),
        'size' => $atts['size'],
        'class' => $atts['class'],
    ));
}
add_shortcode('main_logo', 'shortcode_logo');

/**
 * Шорткод [second_logo] — второй логотип.
 * Атрибуты: link="yes|no", size="full|medium|thumbnail", class=""
 */
function shortcode_second_logo($atts)
{
    $atts = shortcode_atts(
        array(
            'link' => 'yes',
            'size' => 'medium',
            'class' => '',
        ),
        $atts,
        'second_logo'
    );
    return brainworks_get_logo_html('second', array(
        'link' => ($atts['link'] === 'yes' || $atts['link'] === '1'),
        'size' => $atts['size'],
        'class' => $atts['class'],
    ));
}
add_shortcode('second_logo', 'shortcode_second_logo');

/**
 * Шорткод [woo_icons] — иконки кабинета и корзины WooCommerce.
 *
 * Атрибуты:
 *   class=""           — дополнительный CSS-класс обёртки.
 *   show_label="yes"   — показывать текстовую метку рядом с корзиной (yes|no).
 *   cart_label=""      — текст метки корзины (по умолчанию «Кошик»).
 *
 * Пример: [woo_icons show_label="yes" cart_label="Корзина"]
 */
function shortcode_woo_icons($atts)
{
    if (!class_exists('WooCommerce')) {
        return '';
    }

    $atts = shortcode_atts(
        array(
            'class' => '',
            'show_label' => 'yes',
            'cart_label' => __('Кошик', 'brainworks'),
        ),
        $atts,
        'woo_icons'
    );

    $show_label = ($atts['show_label'] === 'yes' || $atts['show_label'] === '1');
    $wrapper_class = 'woo-icons';
    if (!$show_label) {
        $wrapper_class .= ' woo-icons--icons-only';
    }
    if (!empty($atts['class'])) {
        $wrapper_class .= ' ' . esc_attr($atts['class']);
    }

    $account_url = get_permalink(get_option('woocommerce_myaccount_page_id'));
    $cart_url = wc_get_cart_url();
    $cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
    $cart_total = WC()->cart ? WC()->cart->get_cart_total() : '';

    // --- Customizer icons ---
    $custom_account_id = (int) get_theme_mod('brainworks_woo_icon_account', 0);
    $custom_cart_id = (int) get_theme_mod('brainworks_woo_icon_cart', 0);
    $icon_size = (int) get_theme_mod('brainworks_woo_icon_size', 22);
    $img_attrs = array(
        'class' => 'woo-icons__custom-img',
        'alt' => '',
        'style' => 'width:' . $icon_size . 'px;height:' . $icon_size . 'px;object-fit:contain;',
        'loading' => 'eager',
    );

    // Account icon: custom image or fallback SVG
    if ($custom_account_id) {
        $icon_account = wp_get_attachment_image($custom_account_id, 'thumbnail', false, $img_attrs);
    } else {
        $icon_account = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">'
            . '<circle cx="12" cy="8" r="4"/>'
            . '<path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>'
            . '</svg>';
    }

    // Cart icon: custom image or fallback SVG
    if ($custom_cart_id) {
        $icon_cart = wp_get_attachment_image($custom_cart_id, 'thumbnail', false, $img_attrs);
    } else {
        $icon_cart = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">'
            . '<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>'
            . '<line x1="3" y1="6" x2="21" y2="6"/>'
            . '<path d="M16 10a4 4 0 0 1-8 0"/>'
            . '</svg>';
    }

    $badge_display = $cart_count > 0 ? '' : ' style="display:none"';

    $out = '<div class="' . esc_attr($wrapper_class) . '">';

    // --- Account icon ---
    $out .= '<a href="' . esc_url($account_url) . '" class="woo-icons__item woo-icons__item--account"'
        . ' aria-label="' . esc_attr__('Кабінет покупця', 'brainworks') . '">';
    $out .= '<span class="woo-icons__icon-wrap">' . $icon_account . '</span>';
    $out .= '</a>';

    // --- Cart icon + popup wrapper ---
    $out .= '<div class="woo-icons__cart-wrapper">';

    $out .= '<a href="' . esc_url($cart_url) . '" class="woo-icons__item woo-icons__item--cart"'
        . ' aria-label="' . esc_attr__('Кошик', 'brainworks') . '">';
    $out .= '<span class="woo-icons__icon-wrap">';
    $out .= $icon_cart;
    $out .= '<span class="woo-icons__badge" data-woo-cart-count'
        . $badge_display . '>' . absint($cart_count) . '</span>';
    $out .= '</span>'; // .woo-icons__icon-wrap

    if ($show_label) {
        $out .= '<span class="woo-icons__label">'
            . esc_html($atts['cart_label'])
            . '<strong data-woo-cart-total>' . $cart_total . '</strong>'
            . '</span>';
    }

    $out .= '</a>'; // .woo-icons__item--cart

    // --- Mini cart popup ---
    // widget_shopping_cart_content — стандартный класс, который WooCommerce
    // использует для live-обновлений через фрагменты (add-to-cart AJAX).
    ob_start();
    woocommerce_mini_cart();
    $mini_cart_html = ob_get_clean();

    $out .= '<div class="woo-icons__cart-popup" role="dialog" aria-label="'
        . esc_attr__('Кошик', 'brainworks') . '">';
    $out .= '<div class="widget_shopping_cart_content">';
    $out .= $mini_cart_html;
    $out .= '</div>';
    $out .= '</div>'; // .woo-icons__cart-popup

    $out .= '</div>'; // .woo-icons__cart-wrapper

    $out .= '</div>'; // .woo-icons


    // Передаём данные в JS только один раз
    static $woo_icons_script_added = false;
    if (!$woo_icons_script_added) {
        $woo_icons_script_added = true;
        $out .= '<script>window.wooIconsAjax=' . wp_json_encode(array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('woo_icons_cart'),
        )) . ';</script>';
    }

    return $out;
}
add_shortcode('woo_icons', 'shortcode_woo_icons');

/**
 * Shortcode [showhide] — wraps content with a toggle button.
 * Attributes:
 *   more_text="Show"
 *   less_text="Hide"
 *   height="120"
 */
function shortcode_showhide($atts, $content = null)
{
    $atts = shortcode_atts(
        array(
            'more_text' => __('Показати', 'brainworks'),
            'less_text' => __('Приховати', 'brainworks'),
            'height'    => '120',
        ),
        $atts,
        'showhide'
    );

    if (empty($content)) {
        return '';
    }

    $out = '<div class="show-hide-block" style="--show-hide-height: ' . esc_attr($atts['height']) . 'px;">';
    $out .= '<div class="show-hide-content">' . do_shortcode($content) . '</div>';
    $out .= '<div class="show-hide-button-wrap">';
    $out .= '<button type="button" class="show-hide-button" data-more-text="' . esc_attr($atts['more_text']) . '" data-less-text="' . esc_attr($atts['less_text']) . '">' . esc_html($atts['more_text']) . '</button>';
    $out .= '</div>';
    $out .= '</div>';

    return $out;
}
add_shortcode('showhide', 'shortcode_showhide');
