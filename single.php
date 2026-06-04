<?php
/**
 * Single post template.
 * Шаблон страницы одной записи.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>

<div class="site-content <?php echo esc_attr(brainworks_get_layout_class()); ?>">

	<?php if (brainworks_has_left_sidebar()): ?>
		<?php get_sidebar('left'); ?>
	<?php endif; ?>

	<main class="site-main">

		<?php
		while (have_posts()):
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
					<div class="entry-meta">
						<?php
						/* translators: 1: date, 2: author */
						printf(
							esc_html__('Published %1$s by %2$s', 'brainworks'),
							'<time datetime="' . esc_attr(get_the_date('c')) . '">' . esc_html(get_the_date()) . '</time>',
							'<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
						);
						?>
					</div>
				</header>
				<?php if (has_post_thumbnail()): ?>
					<div class="entry-thumbnail">
						<?php the_post_thumbnail(); ?>
					</div>
				<?php endif; ?>
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
				<footer class="entry-footer">
					<?php
					the_tags('<span class="tags-links">' . esc_html__('Tags:', 'brainworks') . ' ', ', ', '</span>');
					?>
				</footer>
			</article>
			<?php
			the_post_navigation(
				array(
					'prev_text' => '&larr; ' . esc_html__('Previous post', 'brainworks'),
					'next_text' => esc_html__('Next post', 'brainworks') . ' &rarr;',
				)
			);

			echo brainworks_get_related_posts_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

			if (comments_open() || get_comments_number()) {
				comments_template();
			}
		endwhile;
		?>
	</main>
	<?php if (brainworks_has_right_sidebar()): ?>
		<?php get_sidebar('right'); ?>
	<?php endif; ?>

</div>

<?php
get_footer();
