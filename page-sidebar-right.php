<?php
/**
 * Template Name: Right Sidebar
 * Шаблон страницы с правой боковой колонкой.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>

<div class="site-content <?php echo esc_attr(brainworks_get_layout_class()); ?>">


	<main class="site-main">
		<?php
		while (have_posts()):
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
				</header>
				<div class="entry-content">
					<?php
					the_content();

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__('Pages:', 'brainworks'),
							'after' => '</div>',
						)
					);
					?>
				</div>
			</article>
			<?php
		endwhile;
		?>
	</main>
	<?php if (brainworks_has_right_sidebar()): ?>
		<?php get_sidebar('right'); ?>
	<?php endif; ?>
</div>

<?php
get_footer();
