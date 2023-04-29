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
		echo '<h1>PHOTOGRAPHE EVENT</h1>';
		echo '<img class="banner-img" src="' . $photo_url . '">';
	endwhile;
	wp_reset_postdata();

	?>
</div>

<section>
	


		<div class="image-grid">
			<?php

			// function load_posts()
			// {
			// 	$page = $_POST['page'];
			// 	$postsPerPage = $_POST['posts_per_page'];
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
							<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
						</div>
						<?php
					}
					wp_reset_postdata();
				}
			// 	wp_die();
			// }
			// add_action('wp_ajax_load_posts', 'load_posts');
			// add_action('wp_ajax_nopriv_load_posts', 'load_posts');
			?>
		</div>
		

	
</section>







<?php get_template_part('template-parts/footer-menus-widgets'); ?>

<?php
get_footer();