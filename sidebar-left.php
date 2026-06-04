<?php
/**
 * Left sidebar template.
 *
 * @package Brainworks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_active_sidebar( 'sidebar-left' ) ) {
	return;
}
?>
<aside id="sidebar-left" class="sidebar sidebar-left" role="complementary" aria-label="<?php esc_attr_e( 'Left sidebar', 'brainworks' ); ?>">
	<?php dynamic_sidebar( 'sidebar-left' ); ?>
</aside>
