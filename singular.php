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

			</div>
			<div class="photo-description">
				<?php the_content(); ?>
			</div>
		</section>
		<section class="contact-content">
			<p>Cette photo vous intéresse ?</p>
			<button id="myOtherBtn"
				data-photo-ref="<?php echo esc_attr(get_post_meta(get_the_ID(), 'reference', true)); ?>">Contact</button>
			<?php get_template_part('template_parts/contact', 'modal'); ?>
		</section>


	</div>
	<!-- #site-content -->
	<?php
	// ------------------------------The pagination---------------------------------------
	
	if (is_single()) {

		$args = array(
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'posts_per_page' => -1,
			'post_status' => 'inherit',
			'orderby' => 'date',
			'order' => 'DESC'
		);

		$query = new WP_Query($args);

		$photo_data = array();

		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				$thumb_url = wp_get_attachment_image_src(get_the_ID(), 'thumbnail')[0];

				$photo_url = wp_get_attachment_url(get_the_ID());
				$photo_data[] = array(
					'thumb_url' => $thumb_url,
					'photo_url' => $photo_url
				);
			}
			wp_reset_postdata();
		}

		$current_post_id = get_the_ID();
		$prev_post = get_previous_post();
		$next_post = get_next_post();

		if ($next_post || $prev_post) {

			$pagination_classes = '';

			if (!$next_post) {
				$pagination_classes = ' only-one only-prev';
			} elseif (!$prev_post) {
				$pagination_classes = ' only-one only-next';
			}

			?>
			<div class="pagination-thumbnails">
				<nav class="pagination-single section-inner<?php echo esc_attr($pagination_classes); ?>"
					aria-label="<?php esc_attr_e('Post', 'twentytwenty'); ?>">

					<hr class="styled-separator is-style-wide" aria-hidden="true" />

					<div class="pagination-single-inner">

						<?php if ($prev_post): ?>
							<?php $prev_post_id = $prev_post->ID; ?>
							<a class="previous-post" href="<?php echo esc_url(get_permalink($prev_post_id)); ?>">
								<span class="arrow" aria-hidden="true">&larr;</span>

								</span></span>
								<?php if ($photo_data): ?>
									<?php foreach ($photo_data as $index => $photo): ?>
										<?php if (has_post_thumbnail($prev_post_id) && $photo['photo_url'] === get_the_post_thumbnail_url($prev_post_id, 'full')): ?>
											<div class="thumbnail-container">
												<img src="<?php echo esc_url($photo['thumb_url']); ?>" class="thumbnail"
													data-photo="<?php echo esc_url($photo['photo_url']); ?>">
											</div>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</a>
						<?php endif; ?>

						<?php if ($next_post):
							;
							?>
							<?php $next_post_id = $next_post->ID; ?>
							<a class="next-post" href="<?php echo esc_url(get_permalink($next_post_id)); ?>">
								<span class="arrow" aria-hidden="true">&rarr;</span>

								</span></span>
								<?php if ($photo_data): ?>
									<?php foreach ($photo_data as $index => $photo): ?>
										<?php if (has_post_thumbnail($next_post_id) && $photo['photo_url'] === get_the_post_thumbnail_url($next_post_id, 'full')): ?>
											<div class="thumbnail-container">
												<img src="<?php echo esc_url($photo_data[$index - 1]['thumb_url']); ?>" class="thumbnail"
													data-photo="<?php echo esc_url($photo_data[$index - 1]['photo_url']); ?>">
											</div>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
							</a>
						<?php endif; ?>



					</div><!-- .pagination-single-inner -->

					<hr class="styled-separator is-style-wide" aria-hidden="true" />

				</nav><!-- .pagination-single -->
			</div><!-- .pagination-thumbnails -->

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



		</main>
		<?php
		}

	}


	?>
<?php get_template_part('template-parts/footer-menus-widgets'); ?>


<?php get_footer(); ?>