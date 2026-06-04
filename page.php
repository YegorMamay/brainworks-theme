<?php
/**
 * Default page template.
 * Шаблон статической страницы.
 *
 * @package Brainworks
 */

if (!defined('ABSPATH')) {
	exit;
}

get_header();
?>



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

<?php
get_footer();
