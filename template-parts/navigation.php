<?php
/**
 * Displays the next and previous post navigation in single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

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
		//var_dump($thumb_url);

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



			<div class="pagination-single-inner">

				<?php if ($prev_post): ?>
					<?php $prev_post_id = $prev_post->ID; ?>
					<a class="previous-post" href="<?php echo esc_url(get_permalink($prev_post_id)); ?>">
						<?php echo '<img class="img1" src="' . get_field("Photo", $prev_post_id)["url"] . '">'; ?>
						<span class="arrow" aria-hidden="true">&larr;</span>
					</a>
				<?php endif; ?>

				<?php if ($next_post): ?>
					<?php $next_post_id = $next_post->ID; ?>
					<a class="next-post" href="<?php echo esc_url(get_permalink($next_post_id)); ?>">
						<?php echo '<img class="img2" src="' . get_field("Photo", $next_post_id)["url"] . '">'; ?>
						<span class="arrow" aria-hidden="true">&rarr;</span>
					</a>
				<?php endif; ?>



			</div><!-- .pagination-single-inner -->



		</nav><!-- .pagination-single -->
	</div><!-- .pagination-thumbnails -->

	<?php
}