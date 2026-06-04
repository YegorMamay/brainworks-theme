<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (Removed)
 * @hooked woocommerce_breadcrumb - 20 (Removed)
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

// Calculate columns
$has_sidebar = is_active_sidebar('sidebar-left');
$content_class = $has_sidebar ? 'col-12 col-md-8 col-lg-9' : 'col-12';
$sidebar_class_col = 'col-12 col-md-4 col-lg-3';
?>

<div class="container py-5">

    <?php do_action('woocommerce_before_main_content'); ?>

    <div class="row">
        <?php if ($has_sidebar): ?>
            <div class="<?php echo esc_attr($sidebar_class_col); ?>">
                <?php get_sidebar('left'); ?>
            </div>
        <?php endif; ?>

        <div class="<?php echo esc_attr($content_class); ?>">
            <main class="site-main">

               <!-- Header Section (Full Width) -->
    <header class="woocommerce-products-header mb-4">
        <?php if (apply_filters('woocommerce_show_page_title', true)): ?>
            <h1 class="woocommerce-products-header__title page-title">
                <?php woocommerce_page_title(); ?>
            </h1>
        <?php endif; ?>
    </header>

    <div class="archive-description-wrapper">
        <div class="archive-description-inner">
            <?php
            /**
             * Hook: woocommerce_archive_description.
             *
             * @hooked woocommerce_taxonomy_archive_description - 10
             * @hooked woocommerce_product_archive_description - 10
             */
            do_action('woocommerce_archive_description');
            ?>
        </div>
        <button class="archive-description-toggle" style="display: none;"
            data-show-text="<?php esc_attr_e('Show', 'brainworks'); ?>"
            data-hide-text="<?php esc_attr_e('Hide', 'brainworks'); ?>">
            <?php esc_html_e('Show', 'brainworks'); ?>
        </button>
    </div>

                <?php
                if (woocommerce_product_loop()) {

                    /**
                     * Hook: woocommerce_before_shop_loop.
                     *
                     * @hooked woocommerce_output_all_notices - 10
                     * @hooked woocommerce_result_count - 20
                     * @hooked woocommerce_catalog_ordering - 30
                     */
                    do_action('woocommerce_before_shop_loop');

                    woocommerce_product_loop_start();

                    if (wc_get_loop_prop('total')) {
                        while (have_posts()) {
                            the_post();

                            /**
                             * Hook: woocommerce_shop_loop.
                             */
                            do_action('woocommerce_shop_loop');

                            wc_get_template_part('content', 'product');
                        }
                    }

                    woocommerce_product_loop_end();

                    /**
                     * Hook: woocommerce_after_shop_loop.
                     *
                     * @hooked woocommerce_pagination - 10
                     */
                    do_action('woocommerce_after_shop_loop');

                } else {
                    /**
                     * Hook: woocommerce_no_products_found.
                     *
                     * @hooked wc_no_products_found - 10
                     */
                    do_action('woocommerce_no_products_found');
                }
                ?>
            </main>
        </div>
    </div>


</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (Removed)
 */
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
do_action('woocommerce_after_main_content');

get_footer();
