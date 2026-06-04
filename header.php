<?php
/**
 * Header template.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
	exit;
}
?>
<?php
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>">
	<?php wp_site_icon(); ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> id="top">
	<?php wp_body_open(); ?>


	<?php if (is_active_sidebar('pre-header')): ?>
		<div class="pre-header">
			<div class="pre-header__inner">
				<?php dynamic_sidebar('pre-header'); ?>
			</div>
		</div>
	<?php endif; ?>

	<header class="site-header" role="banner">
		<div class="mobile-header">
			<div class="site-branding">
				<?php
				$mobile_logo = brainworks_get_logo_html('main', array('link' => true, 'size' => 'medium'));
				if ($mobile_logo) {
					echo $mobile_logo; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				} else {
					?>
					<a href="<?php echo esc_url(home_url('/')); ?>" class="site-branding__text" rel="home">
						<?php bloginfo('name'); ?>
					</a>
					<?php
				}
				?>
			</div>
			<button class="hamburger hamburger--squeeze js-hamburger" type="button">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</button>
		</div>

		<div class="mobile-menu-container">
			<div class="mobile-menu-inner">
				<button class="mobile-menu-close js-mobile-menu-close" type="button"
					aria-label="<?php esc_attr_e('Close Menu', 'brainworks'); ?>"></button>
				<?php if (has_nav_menu('mobile-menu')): ?>
					<nav class="mobile-navigation" aria-label="<?php esc_attr_e('Mobile Menu', 'brainworks'); ?>">
						<?php wp_nav_menu(array(
							'theme_location' => 'mobile-menu',
							'menu_id' => 'mobile-menu',
							'menu_class' => 'mobile-menu',
							'container' => false,
							'depth' => 0,
						)); ?>
					</nav>
				<?php endif; ?>
				<div class="mobile-menu-widgets">
					<?php echo do_shortcode('[phones format="column" class="mobile-phones"]'); ?>
					<?php echo do_shortcode('[messengers class="mobile-messengers"]'); ?>
					<?php echo do_shortcode('[social class="mobile-social"]'); ?>
				</div>
			</div>
		</div>

		<div class="site-header__inner">
			<div class="site-branding">
				<?php
				$main_logo = brainworks_get_logo_html('main', array('link' => true, 'size' => 'medium'));
				if ($main_logo) {
					echo $main_logo; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — HTML from brainworks_get_logo_html
				} else {
					?>
					<a href="<?php echo esc_url(home_url('/')); ?>" class="site-branding__text"
						rel="home"><?php bloginfo('name'); ?></a>
					<?php
				}
				?>
			</div>
			<?php echo do_shortcode('[phones format="dropdown" class="header-phones"]'); ?>
			<?php echo do_shortcode('[social]'); ?>
			<?php echo do_shortcode('[woo_icons]'); ?>
		</div>

		<?php if (has_nav_menu('main-menu')): ?>
			<nav class="main-navigation" aria-label="<?php esc_attr_e('Main Menu', 'brainworks'); ?>">
				<div class="container">
					<?php wp_nav_menu(array(
						'theme_location' => 'main-menu',
						'menu_id' => 'main-menu',
						'menu_class' => 'menu',
						'container' => false,
						'depth' => 0,
					)); ?>
				</div>
			</nav>
		<?php endif; ?>
	</header>

	<?php if (function_exists('breadcrumbs')): ?>
		<div class="site-breadcrumbs">
			<div class="site-breadcrumbs__inner container">
				<?php breadcrumbs(); ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="site">
