<?php
/**
 * The template for displaying product content within loops.
 *
 * Overrides WooCommerce's default content-product.php to add list-view support.
 * In GRID mode: .bw-list-* elements are hidden via CSS, layout is normal.
 * In LIST mode: .woo-list-view on <body> reveals list layout.
 *
 * @package Brainworks
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}
?>
<li <?php wc_product_class('', $product); ?>>

    <?php do_action('woocommerce_before_shop_loop_item'); // opens <a> wrapper p10 ?>

    <!-- ── LEFT COLUMN (image area) ── shown in list view, ignored in grid ── -->
    <div class="bw-list-image-col">

        <?php if ($product->is_featured()): ?>
            <span class="bw-featured-badge"><?php esc_html_e('Популярне', 'brainworks'); ?></span>
        <?php endif; ?>

        <?php
        /**
         * @hooked woocommerce_show_product_loop_sale_flash  - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action('woocommerce_before_shop_loop_item_title');
        ?>



    </div><!-- .bw-list-image-col -->

    <!-- ── RIGHT COLUMN (product info) ── shown in list view, ignored in grid ── -->
    <div class="bw-list-info-col">

        <?php
        /**
         * @hooked woocommerce_template_loop_product_title - 10
         */
        do_action('woocommerce_shop_loop_item_title');
        ?>

        <?php
        // Price — shown directly below the title
        woocommerce_template_loop_price();
        ?>

        <?php
        // Short description (list view only — hidden via CSS in grid mode)
        $short_desc = $product->get_short_description();
        if ($short_desc): ?>
            <div class="bw-list-short-desc"><?php echo wp_kses_post($short_desc); ?></div>
        <?php endif; ?>

        <?php
        // Meta (SKU, categories, tags) — list view only
        $meta_parts = [];

        $sku = $product->get_sku();
        if ($sku) {
            $meta_parts[] = '<span>' . esc_html__('Артикул:', 'brainworks') . ' <strong>' . esc_html($sku) . '</strong></span>';
        }

        $categories = get_the_term_list($product->get_id(), 'product_cat', '', ', ');
        if ($categories && !is_wp_error($categories)) {
            $meta_parts[] = '<span>' . esc_html__('Категорія:', 'brainworks') . ' ' . wp_kses_post($categories) . '</span>';
        }

        $tags = get_the_term_list($product->get_id(), 'product_tag', '', ', ');
        if ($tags && !is_wp_error($tags)) {
            $meta_parts[] = '<span>' . esc_html__('Позначка:', 'brainworks') . ' ' . wp_kses_post($tags) . '</span>';
        }

        if ($meta_parts): ?>
            <div class="bw-list-meta">
                <?php echo implode('', $meta_parts); // phpcs:ignore ?>
            </div>
        <?php endif; ?>

        <?php
        // Star rating only (price already output above)
        remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
        do_action('woocommerce_after_shop_loop_item_title');
        add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
        ?>

        <!-- Add to cart button — shown below price in list view -->
        <div class="bw-list-action">
            <?php woocommerce_template_loop_add_to_cart(); ?>
        </div>

    </div><!-- .bw-list-info-col -->

    <?php
    /**
     * Hook: woocommerce_after_shop_loop_item.
     * @hooked woocommerce_template_loop_product_link_close - 5  (closes </a>)
     * @hooked woocommerce_template_loop_add_to_cart        - 10 (renders grid-mode button)
     */
    do_action('woocommerce_after_shop_loop_item');
    ?>

</li>
