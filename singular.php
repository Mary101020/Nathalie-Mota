<?php
/**
 * The template for displaying single posts and pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header(); ?>

<main id="site-content">
	<div class="site-content-single">
		<section class="photo-info-container">
			<div class="photo-image-container">
				<div class="photo-image"
					style="background-image: url('<?php echo wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())); ?>');">
				</div>
				<div class="photo-image-overlay">
					<div class="fullscreen-btn"></div>
				</div>
			</div>
			<div class="photo-info">
				<h2>
					<?php the_title(); ?>
				</h2>
				<p>RÉf. PHOTO:
					<?php echo get_post_meta(get_the_ID(), 'reference', true); ?>
				</p>
				<?php
				// Récupération de l'ID de la catégorie
				$categories = get_the_terms(get_the_ID(), 'categorie');
				if ($categories && !is_wp_error($categories)) {
					$category_names = array();
					foreach ($categories as $category) {
						$category_names[] = $category->name;
					}
					echo '<p>CATÉGORIE: ' . implode(', ', $category_names) . '</p>';
				}

				// Display format
				$formats = get_the_terms(get_the_ID(), 'format');
				if ($formats && !is_wp_error($formats)) {
					$format_names = array();
					foreach ($formats as $format) {
						$format_names[] = $format->name;
					}
					echo '<p>FORMAT: ' . implode(', ', $format_names) . '</p>';
				}
				?>
				<p>TYPE:
					<?php echo get_post_meta(get_the_ID(), 'type', true); ?>
				</p>
				<p>ANNÉE:
					<?php echo get_post_meta(get_the_ID(), 'annee', true); ?>
				</p>
				<?php $current_post_id = get_the_ID();
				$prev_post = get_previous_post();
				$next_post = get_next_post(); ?>

			</div>
			<div class="photo-description">
				<?php echo '<img src="' . get_field("Photo", $prev_post->ID)["url"] . '">'; ?>
			</div>
		</section>
		<section class="contact-content">
			<p>Cette photo vous intéresse ?</p>
			<button id="myOtherBtn"
				data-photo-ref="<?php echo esc_attr(get_post_meta(get_the_ID(), 'reference', true)); ?>">Contact</button>
			<?php get_template_part('template_parts/contact', 'modal'); ?>
		</section>
	</div>
</main>
<!-- #site-content -->


<?php

if (is_single()) {

	get_template_part('template-parts/navigation');

}
?>

<!-- ------------------------La section vous aimerez aussi---------------- -->
<section class="section-like">
	<h3>VOUS AIMEREZ AUSSI</h3>
	<div class="thumbnail-container">
		<?php
		// Get the category IDs of the current post
		$category_ids = array();
		$categories = get_the_terms(get_the_ID(), 'categorie');
		if ($categories && !is_wp_error($categories)) {
			foreach ($categories as $category) {
				$category_ids[] = $category->term_id;
			}
		}

		// Query two posts from the same category as the current post
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 2,
			'orderby' => 'rand',
			'post__not_in' => array(get_the_ID()),
			'tax_query' => array(
				array(
					'taxonomy' => 'categorie',
					'field' => 'id',
					'terms' => $category_ids,
				),
			),
		);
		$query = new WP_Query($args);

		// Loop through the posts and display the thumbnails
		while ($query->have_posts()) {
			$query->the_post();

			$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'thumbnail')[0];
			if ($thumbnail_url) {
				echo '<div class="thumbnail" data-photo="' . get_permalink() . '">';
				echo '<img src="' . $thumbnail_url . '" alt="' . get_the_title() . '">';
				echo '</div>';
			}
		}



		// Restore original post data
		wp_reset_postdata();
		?>
	</div>
</section>

<?php get_template_part('template-parts/footer-menus-widgets'); ?>


<?php get_footer(); ?>