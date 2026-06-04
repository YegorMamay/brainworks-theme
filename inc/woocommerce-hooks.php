<?php
/**
 * WooCommerce Custom Hooks.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

// Wrap result-count (20), catalog-ordering (30) and view-switcher (35) inside a flex toolbar.
// Opening wrapper fires at priority 15 — before all three elements.
// Closing wrapper fires at priority 40 — after all three elements.
// Visual order (sorting left, count right) is controlled via CSS `order` on each child.
add_action('woocommerce_before_shop_loop', function () {
    if (!is_shop() && !is_product_category() && !is_product_tag()) {
        return;
    }
    echo '<div class="bw-shop-toolbar">';
}, 15);

add_action('woocommerce_before_shop_loop', function () {
    if (!is_shop() && !is_product_category() && !is_product_tag()) {
        return;
    }
    echo '</div><!-- .bw-shop-toolbar -->';
}, 40);


/**
 * Force full size image for GIFs to preserve animation
 *
 * @param array|bool $downsize Array of image data, or boolean false if no image is available.
 * @param int        $id        Attachment ID for image.
 * @param string|int $size      Size of the image.
 * @return array|bool
 */
function force_gif_full_size($downsize, $id, $size)
{
    if (!$id) {
        return $downsize;
    }

    $mime = get_post_mime_type($id);

    if ($mime === 'image/gif') {
        $image_url = wp_get_attachment_url($id);
        $image_meta = wp_get_attachment_metadata($id);

        if ($image_url && $image_meta) {
            // Return full size image data
            // array( url, width, height, is_intermediate )
            return array(
                $image_url,
                $image_meta['width'],
                $image_meta['height'],
                false // is_intermediate = false means it's the original full size
            );
        }
    }

    return $downsize;
}
add_filter('image_downsize', 'force_gif_full_size', 10, 3);

/**
 * AJAX: вернуть актуальные данные корзины для шорткода [woo_icons].
 * Доступен как для авторизованных пользователей, так и для гостей.
 */
function brainworks_ajax_woo_icons_cart()
{
    check_ajax_referer('woo_icons_cart', 'nonce');

    if (!class_exists('WooCommerce') || !WC()->cart) {
        wp_send_json_error(array('message' => 'WooCommerce not available'));
    }

    wp_send_json_success(array(
        'count' => WC()->cart->get_cart_contents_count(),
        'total' => WC()->cart->get_cart_total(), // возвращает уже отформатированную строку с валютой
    ));
}
add_action('wp_ajax_woo_icons_cart', 'brainworks_ajax_woo_icons_cart');
add_action('wp_ajax_nopriv_woo_icons_cart', 'brainworks_ajax_woo_icons_cart');

/**
 * View-mode switcher (grid / list) for WooCommerce shop & category pages.
 * Rendered after the catalog ordering dropdown (priority 30) → priority 35.
 */
function brainworks_view_switcher()
{
    if (!is_shop() && !is_product_category() && !is_product_tag()) {
        return;
    }
    ?>
    <div class="bw-view-switcher" role="group" aria-label="<?php esc_attr_e('View mode', 'brainworks'); ?>">
        <button class="bw-view-switcher__btn bw-view-switcher__btn--grid is-active" data-view="grid"
            title="<?php esc_attr_e('Grid view', 'brainworks'); ?>" aria-pressed="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"
                aria-hidden="true">
                <rect x="3" y="3" width="8" height="8" rx="1" />
                <rect x="13" y="3" width="8" height="8" rx="1" />
                <rect x="3" y="13" width="8" height="8" rx="1" />
                <rect x="13" y="13" width="8" height="8" rx="1" />
            </svg>
        </button>
        <button class="bw-view-switcher__btn bw-view-switcher__btn--list" data-view="list"
            title="<?php esc_attr_e('List view', 'brainworks'); ?>" aria-pressed="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"
                aria-hidden="true">
                <rect x="3" y="4" width="18" height="3" rx="1" />
                <rect x="3" y="10.5" width="18" height="3" rx="1" />
                <rect x="3" y="17" width="18" height="3" rx="1" />
            </svg>
        </button>
    </div>
    <?php
}
add_action('woocommerce_before_shop_loop', 'brainworks_view_switcher', 35);
