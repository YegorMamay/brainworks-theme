<?php
/**
 * Search results template.
 * Шаблон страницы результатов поиска.
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

		<header class="page-header">
			<h1 class="page-title">
				<?php
				/* translators: %s: search query */
				printf(esc_html__('Search results for: %s', 'brainworks'), '<span>' . get_search_query() . '</span>');
				?>
			</h1>
		</header>

		<?php if (have_posts()): ?>
			<?php while (have_posts()):
				the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
						<div class="entry-meta">
							<?php
							$post_type_obj = get_post_type_object(get_post_type());
							$post_type_name = $post_type_obj ? $post_type_obj->labels->singular_name : get_post_type();
							/* translators: 1: date, 2: post type */
							printf(
								esc_html__('%1$s &middot; %2$s', 'brainworks'),
								'<time datetime="' . esc_attr(get_the_date('c')) . '">' . esc_html(get_the_date()) . '</time>',
								esc_html($post_type_name)
							);
							?>
						</div>
					</header>
					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div>
				</article>
			<?php endwhile; ?>

			<nav class="pagination">
				<?php
				the_posts_pagination(
					array(
						'prev_text' => '&larr; ' . esc_html__('Previous', 'brainworks'),
						'next_text' => esc_html__('Next', 'brainworks') . ' &rarr;',
					)
				);
				?>
			</nav>
		<?php else: ?>
			<?php get_template_part('template-parts/content', 'none'); ?>
		<?php endif; ?>
	</main>

	<?php if (brainworks_has_right_sidebar()): ?>
		<?php get_sidebar('right'); ?>
	<?php endif; ?>

</div>

<?php
get_footer();
