<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

get_header();


?>
<div class="banner-content">
	<?php
	$args = array(
		'orderby' => 'rand',
		'posts_per_page' => '1',
		'post_type' => 'Photo'
	);

	$the_query = new WP_Query($args);




	while ($the_query->have_posts()):
		$the_query->the_post();

		$photo_url = get_field("Photo", get_the_ID())["url"];
		echo '<img class="event-banner" src="' . get_stylesheet_directory_uri() . '/img/event-banner.png" alt="Photographer Event">';
		echo '<img class="banner-img" src="' . $photo_url . '">';
	endwhile;
	wp_reset_postdata();

	?>
</div>
<section class="sort-section">
	<div class="cat_form-div">
		<?php
		$terms = get_terms(
			array(
				'taxonomy' => 'categorie',
				'hide_empty' => true,
			)
		);

		if (!empty($terms) && !is_wp_error($terms)):
			?>
			<div class="categorie">
				<label>CATÉGORIES</label>
				<select name="categorie" id="categorie-select">
					<option value=""></option>

					<?php foreach ($terms as $term): ?>
						<option value="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		<?php endif; ?>

		<?php
		$terms = get_terms(
			array(
				'taxonomy' => 'format',
				'hide_empty' => true,
			)
		);

		if (!empty($terms) && !is_wp_error($terms)):
			?>
			<div class="format">
				<label>FORMATS</label>
				<select name="format" id="format-select">
					<option value=""></option>
					<?php foreach ($terms as $term): ?>
						<option value="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		<?php endif; ?>
	</div>
	<div class="sort-div">
		<label for="sort">TRIER PAR</label>
		<select id="sort-posts">
			<option value=""></option>
			<option value="DESC">Nouveautés</option>
			<option value="ASC">Les plus anciens</option>
		</select>
	</div>
</section>



<section id= "post-section" class="post-section">
	<div class="image-grid">

		<?php
		$args = array(
			'post_type' => 'Photo',

		);
		$query = new WP_Query($args);

		if ($query->have_posts()) {
			while ($query->have_posts()) {
				$query->the_post();
				$image = get_field('Photo');
				?>
				<div class="image-grid-item">
					<img class="img-post" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">					<div class="overlay">
						<a class= "fullscreen-trigger" href="#"><img class="fullscreen-img"
								src="<?php echo get_stylesheet_directory_uri() . '/img/fullscreen.png'; ?>"
								alt="fullscreen_img"></a>
						<a href="<?php the_permalink(); ?>"><img class="eye-img"
								src="<?php echo get_stylesheet_directory_uri() . '/img/eye.png'; ?>" alt="eye_img"></a>
						<h2 class="post-title">
							<?php the_title(); ?>
						</h2>
						<span class="post-category">
							<?php $categories = get_the_terms(get_the_ID(), 'categorie');
							if ($categories && !is_wp_error($categories)) {
								$category_names = array();
								foreach ($categories as $category) {
									$category_names[] = $category->name;
								}
								echo '<p> ' . implode(', ', $category_names) . '</p>';
							} ?>
						</span>
					</div>
				</div>
				<?php
			}
			wp_reset_postdata();
		}

		?>
	</div>



</section>


<div id="post-container">

</div>
<div class="btn-load-div">
	<button id="load-more-btn" data-page="1">Charger plus</button>
</div>




<?php get_template_part('template-parts/footer-menus-widgets'); ?>

<?php
get_footer();