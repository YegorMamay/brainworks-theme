<?php
/**
 * Main template file.
 * Fallback для всех типов контента, если нет более специфичного шаблона.
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
		if (have_posts()):
			while (have_posts()):
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if (has_post_thumbnail()): ?>
						<div class="entry-thumbnail text-center">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
						</div>
					<?php endif; ?>
					<div class="entry-content-wrap">
						<header class="entry-header">
							<?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
							<div class="entry-meta">
								<?php
								/* translators: 1: date, 2: author */
								printf(
									esc_html__('Published %1$s by %2$s', 'brainworks'),
									'<time datetime="' . esc_attr(get_the_date('c')) . '">' . esc_html(get_the_date()) . '</time>',
									'<span class="author vcard">' . esc_html(get_the_author()) . '</span>'
								);
								?>
							</div>
						</header>
						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div>
						<div class="entry-read-more pt-4">
							<a href="<?php the_permalink(); ?>" class="btn btn-secondary btn-sm"><?php esc_html_e('Read More', 'brainworks'); ?></a>
						</div>
					</div>
				</article>
				<?php
			endwhile;
		else:
			get_template_part('template-parts/content', 'none');
		endif;
		?>
	</main>

	<?php if (brainworks_has_right_sidebar()): ?>
		<?php get_sidebar('right'); ?>
	<?php endif; ?>

</div>

<?php
get_footer();
