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



// La fontion ajax pour charger lus des photos sur la page d'accueil
function load_more_posts()
{
    $paged = $_POST['page'];
    $args = array(
        'post_type' => 'Photo',
        'posts_per_page' => 4,
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
                <a href="#"><img class="fullscreen-img" src="<?php echo get_stylesheet_directory_uri() . '/img/fullscreen.png'; ?>"
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
            <?php
        }
    }

    wp_die();
}
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');


// La fonction ajax pour trier les photos par rapport a la date de publication
function get_images_by_date()
{
    $order = $_POST['order'];

    $args = array(
        'meta_key' => 'annee',
        'orderby' => 'meta_value',
        'post_type' => 'Photo',
        'order' => $order
    );
    $query = new WP_Query($args);
    $images = array();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $image = get_field('Photo', get_the_ID());
            $category = '';
            $categories = get_the_terms(get_the_ID(), 'categorie');
            if ($categories && !is_wp_error($categories)) {
                $category_names = array();
                foreach ($categories as $category) {
                    $category_names[] = $category->name;
                }
                $category = implode(', ', $category_names);
            }
            $title = get_the_title();
            $permalink = get_permalink();
            $images[] = array(
                'url' => $image['url'],
                'alt' => $image['alt'],
                'category' => $category,
                'title' => $title,
                'permalink' => $permalink
            );
        }
        wp_reset_postdata();
    }

    $html = '';
    if (!empty($images)) {
        $html .= '<div class="image-grid">';
        foreach ($images as $image) {
            $html .= '<div class="image-grid-item">';
            $html .= '<img class="img-post" src="' . $image['url'] . '" alt="' . $image['alt'] . '" class="img-fluid">';
            $html .= '<a href="#"><img class="fullscreen-img" src="' . get_stylesheet_directory_uri() . '/img/fullscreen.png" alt="fullscreen_img"></a>';
            $html .= '<a href="' . $image['permalink'] . '"><img class="eye-img" src="' . get_stylesheet_directory_uri() . '/img/eye.png" alt="eye_img"></a>';
            $html .= '<h2 class="post-title">' . $image['title'] . '</h2>';
            $html .= '<span class="post-category">';
            $html .= '<p>' . $image['category'] . '</p>';
            $html .= '</span></div>';
        }
    }
    echo json_encode(array('html' => $html));
    wp_die();
}


add_action('wp_ajax_get_images_by_date', 'get_images_by_date');
add_action('wp_ajax_nopriv_get_images_by_date', 'get_images_by_date');

// La fonction ajax pour filtrer les photos par rapport a la categorie et format

add_action('wp_ajax_get_filtered_posts', 'get_filtered_posts');
add_action('wp_ajax_nopriv_get_filtered_posts', 'get_filtered_posts');

function get_filtered_posts()
{
    $categorie = $_POST['categorie'];
    $format = $_POST['format'];

    $args = array(
        'post_type' => 'Photo',
        'orderby' => 'date',
        'order' => 'DESC',
        'tax_query' => array(
            'relation' => 'AND',
        ),
    );

    if ($categorie) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $categorie,
        );
    }

    if ($format) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    $query = new WP_Query($args);

    $images = array();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $image = get_field('Photo');
            $title = get_the_title();
            $categories = get_the_terms(get_the_ID(), 'categorie');
            $category_names = array();
            if ($categories && !is_wp_error($categories)) {
                foreach ($categories as $category) {
                    $category_names[] = $category->name;
                }
            }
            $category = implode(', ', $category_names);
            $link = get_permalink();
            array_push($images, array('image' => $image, 'title' => $title, 'category' => $category, 'link' => $link));
        }
        wp_reset_postdata();
    }

    $data = array(
        'success' => true,
        'html' => '',
    );
    if (!empty($images)) {
        foreach ($images as $image_data) {
            $html .= '<div class="image-grid-item">';
            $html .= '<img class="img-post" src="' . $image_data['image']['url'] . '" alt="' . $image_data['image']['alt'] . '" class="img-fluid">';
            $html .= '<a href="#"><img class="fullscreen-img" src="' . get_stylesheet_directory_uri() . '/img/fullscreen.png" alt="fullscreen_img"></a>';
            $html .= '<a href="' . $image_data['link'] . '"><img class="eye-img" src="' . get_stylesheet_directory_uri() . '/img/eye.png" alt="eye_img"></a>';
            $html .= '<h2 class="post-title">' . $image_data['title'] . '</h2>';
            $html .= '<span class="post-category">';
            $html .= '<p>' . $image_data['category'] . '</p>';
            $html .= '</span></div>';
        }
        $data['html'] = $html;
    }

    echo json_encode($data);
    wp_die();
}


function load_custom_script()
{
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/js/lightbox.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'load_custom_script');