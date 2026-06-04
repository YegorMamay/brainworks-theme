<?php
/**
 * 404 Not Found template.
 * Шаблон страницы «ничего не найдено».
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>

<main class="site-main">
	<section class="error-404 not-found">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e('Page not found', 'brainworks'); ?></h1>
		</header>
		<div class="page-content">
			<p><?php esc_html_e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'brainworks'); ?>
			</p>
			<?php get_search_form(); ?>
			<div class="error-404__actions">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="shiny-cta">
					<span><?php esc_html_e('Перейти на Главную', 'brainworks'); ?></span>
				</a>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
