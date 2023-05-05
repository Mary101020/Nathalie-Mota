<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if (!function_exists('chld_thm_cfg_locale_css')):
    function chld_thm_cfg_locale_css($uri)
    {
        if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css'))
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');

if (!function_exists('chld_thm_cfg_parent_css')):
    function chld_thm_cfg_parent_css()
    {
        wp_enqueue_style('chld_thm_cfg_parent', trailingslashit(get_template_directory_uri()) . 'style.css', array());
    }
endif;
add_action('wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10);

// END ENQUEUE PARENT ACTION

function enqueue_my_script()
{
    wp_enqueue_script('my-script', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', true);
}

add_action('wp_enqueue_scripts', 'enqueue_my_script');


function wpse_enqueue_mobile_style()
{
    wp_register_style('mobile-style', get_stylesheet_directory_uri() . '/mobile.css', array(), '1.0');
    wp_enqueue_style('mobile-style');
}
add_action('wp_enqueue_scripts', 'wpse_enqueue_mobile_style');


function load_more_posts()
{
    $paged = $_POST['page'];
    $args = array(
        'post_type' => 'Photo',
        'posts_per_page' => 2,
        'paged' => $paged,

    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $image = get_field('Photo');
            ?>
            <div class="image-grid-item">
                <img class="img-post" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="img-fluid">
            </div>
            <?php
        }
    }

    wp_die();
}
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');



function get_images_by_date()
{
    $order = $_POST['order'];
    $args = array(
        'post_type' => 'Photo',
        'orderby' => 'date',
        'order' => $order
    );
    $query = new WP_Query($args);
    $images = array();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $image = get_field('Photo');
            array_push($images, $image);
        }
        wp_reset_postdata();
        
    }
    $html = '';
    if (!empty($images)) {
        $html .= '<div class="image-grid">';
        foreach ($images as $image) {
            $html .= '<div class="image-grid-item">';
            $html .= '<img class="img-post" src="' . $image['url'] . '" alt="' . $image['alt'] . '">';
            $html .= '<div class="overlay">';
            $html .= '<a href="#"><img class="fullscreen-img" src="' . get_stylesheet_directory_uri() . '/img/fullscreen.png" alt="fullscreen_img"></a>';
            $html .= '<a href="' . $image['permalink'] . '"><img class="eye-img" src="' . get_stylesheet_directory_uri() . '/img/eye.png" alt="eye_img"></a>';
            $html .= '<h2 class="post-title">' . get_the_title() . '</h2>';
            $html .= '<span class="post-category">';
            $categories = get_the_terms(get_the_ID(), 'categorie');
            if ($categories && !is_wp_error($categories)) {
                $category_names = array();
                foreach ($categories as $category) {
                    $category_names[] = $category->name;
                }
                $html .= '<p>' . implode(', ', $category_names) . '</p>';
            }
            $html .= '</span>';
            $html .= '</div>';
            $html .= '</div>';
        }
        
    }
    echo json_encode(array('html' => $html));
    wp_die();
}
add_action('wp_ajax_get_images_by_date', 'get_images_by_date');
add_action('wp_ajax_nopriv_get_images_by_date', 'get_images_by_date');