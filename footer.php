<?php
/**
 * Footer template.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
	exit;
}
?>
</div><!-- .site -->
<footer class="site-footer"> <?php if (is_active_sidebar('footer')): ?>
		<div class="site-footer__inner">
			<?php dynamic_sidebar('footer'); ?>
		</div>
	<?php endif; ?>

	<div class="site-footer__bottom">
		<div class="container">
			<div class="site-footer__copyright">
				&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.
			</div>

			<?php if (has_nav_menu('second-menu')): ?>
				<nav class="second-navigation" aria-label="<?php esc_attr_e('Second Menu', 'brainworks'); ?>">
					<?php wp_nav_menu(array(
						'theme_location' => 'second-menu',
						'menu_id' => 'second-menu',
						'menu_class' => 'menu',
						'container' => false,
						'depth' => 1,
					)); ?>
				</nav>
			<?php endif; ?>

			<div class="site-footer__developer">
				Разработка сайта: <a href="https://brainworks.in.ua/" target="_blank" rel="noopener">BrainWorks</a>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>

</html>
