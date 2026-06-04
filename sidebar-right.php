<?php
/**
 * Right sidebar template.
 *
 * @package Brainworks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_active_sidebar( 'sidebar-right' ) ) {
	return;
}
?>
<aside id="sidebar-right" class="sidebar sidebar-right" role="complementary" aria-label="<?php esc_attr_e( 'Right sidebar', 'brainworks' ); ?>">
	<?php dynamic_sidebar( 'sidebar-right' ); ?>
</aside>
