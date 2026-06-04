<?php
/**
 * The Template for displaying all single products
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<div class="site-content site-content--full-width">
    <main class="site-main">
        <?php
        while (have_posts()):
            the_post();
            wc_get_template_part('content', 'single-product');
        endwhile; // end of the loop.
        ?>
    </main>
</div>

<?php
get_footer();
