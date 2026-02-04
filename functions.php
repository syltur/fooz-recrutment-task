<?php
/**
 * Twenty Twenty Five Child functions
 */

function fooz_force_classic_templates($template)
{
    if (is_singular('books')) {
        $custom = get_stylesheet_directory() . '/single-books.php';
        if (file_exists($custom)) {
            return $custom;
        }
    }
    if (is_tax('genre')) {
        $custom = get_stylesheet_directory() . '/taxonomy-genre.php';
        if (file_exists($custom)) {
            return $custom;
        }
    }
    return $template;
}
add_filter('template_include', 'fooz_force_classic_templates', 99);

function fooz_enqueue_assets()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_uri(), array('parent-style'));

    // Task #2: Load custom JavaScript in footer
    wp_enqueue_script(
        'fooz-scripts',
        get_stylesheet_directory_uri() . '/assets/js/scripts.js',
        array(),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'fooz_enqueue_assets');

//Task #3: Register Books CPT and Genre Taxonomy

function fooz_register_library_assets()
{

    // Task #3.1: Register Genre Taxonomy
    $genre_labels = array(
        'name' => _x('Genres', 'taxonomy general name', 'fooz'),
        'singular_name' => _x('Genre', 'taxonomy singular name', 'fooz'),
        'search_items' => __('Search Genres', 'fooz'),
        'all_items' => __('All Genres', 'fooz'),
        'edit_item' => __('Edit Genre', 'fooz'),
        'update_item' => __('Update Genre', 'fooz'),
        'add_new_item' => __('Add New Genre', 'fooz'),
        'new_item_name' => __('New Genre Name', 'fooz'),
        'menu_name' => __('Genre', 'fooz'),
    );

    $genre_args = array(
        'hierarchical' => true,
        'labels' => $genre_labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'book-genre'),
    );

    register_taxonomy('genre', array('books'), $genre_args);

    // Task #3.2: Register Custom Post Type "Books"
    $book_labels = array(
        'name' => _x('Books', 'Post type general name', 'fooz'),
        'singular_name' => _x('Book', 'Post type singular name', 'fooz'),
        'menu_name' => _x('Books', 'Admin Menu text', 'fooz'),
        'add_new' => __('Add New', 'fooz'),
        'add_new_item' => __('Add New Book', 'fooz'),
        'edit_item' => __('Edit Book', 'fooz'),
        'new_item' => __('New Book', 'fooz'),
        'view_item' => __('View Book', 'fooz'),
        'all_items' => __('All Books', 'fooz'),
    );

    $book_args = array(
        'labels' => $book_labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'library'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
        'taxonomies' => array('genre'),
    );

    register_post_type('books', $book_args);
}
add_action('init', 'fooz_register_library_assets');

// Task #4.1: Dynamic loading
function fooz_load_latest_books()
{
    check_ajax_referer('fooz_book_nonce', 'nonce');
    $exclude_id = isset($_POST['exclude_id']) ? intval($_POST['exclude_id']) : 0;

    $args = array(
        'post_type' => 'books',
        'posts_per_page' => 20,
        'post__not_in' => array($exclude_id),
        'orderby' => 'date',
        'order' => 'DESC'
    );

    $query = new WP_Query($args);
    $books = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $books[] = array(
                'name' => get_the_title(),
                'date' => get_the_date(),
                'genre' => strip_tags(get_the_term_list(get_the_ID(), 'genre', '', ', ')),
                'excerpt' => get_the_excerpt()
            );
        }
    }

    wp_reset_postdata();
    wp_send_json($books);
}
add_action('wp_ajax_get_latest_books', 'fooz_load_latest_books');
add_action('wp_ajax_nopriv_get_latest_books', 'fooz_load_latest_books');

function fooz_localize_ajax()
{
    wp_localize_script('fooz-scripts', 'fooz_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('fooz_book_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'fooz_localize_ajax', 20);

//Task #4.2: Set limit to 5 books per page for genre taxonomy    

function fooz_modify_genre_query($query)
{
    if (!is_admin() && $query->is_main_query() && is_tax('genre')) {
        $query->set('posts_per_page', 5);
    }
}
add_action('pre_get_posts', 'fooz_modify_genre_query');

//Task #5: Register FAQ Block
function fooz_register_blocks()
{
    register_block_type(__DIR__ . '/blocks/faq-accordion');
}
add_action('init', 'fooz_register_blocks');