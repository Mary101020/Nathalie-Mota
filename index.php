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
// echo "<pre>";
// var_dump($the_query);
// echo "</pre>";


//if ($the_query->have_posts()):
//var_dump($the_query);
while ($the_query->have_posts()):
	$the_query->the_post();
	//var_dump($the_query);
	//$current_post_id = get_the_ID();
	$photo_url = get_field("Photo", get_the_ID())["url"];
	//var_dump($photo_url);
	echo '<h1>PHOTOGRAPHE EVENT</h1>';
	echo'<img class="banner-img" src="' . $photo_url . '">';
endwhile;
wp_reset_postdata();
//endif;
?>
</div>







<?php get_template_part('template-parts/footer-menus-widgets'); ?>

<?php
get_footer();