<?php
/**
 * Twenty Twenty Five Child functions
 */

// Task 1 & 2: Assets Enqueue
function fooz_enqueue_assets()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_uri(), array('parent-style'));

    wp_enqueue_script(
        'fooz-scripts',
        get_stylesheet_directory_uri() . '/assets/js/scripts.js',
        array(),
        '1.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'fooz_enqueue_assets');

// Task 3: Register Custom Post Type "Books" and Taxonomy "Genre"

function fooz_register_books_cpt()
{

    // Task 3.1: Register Genre Taxonomy (must be registered before CPT)
    $genre_labels = array(
        'name' => _x('Genres', 'taxonomy general name', 'fooz'),
        'singular_name' => _x('Genre', 'taxonomy singular name', 'fooz'),
        'search_items' => __('Search Genres', 'fooz'),
        'all_items' => __('All Genres', 'fooz'),
        'parent_item' => __('Parent Genre', 'fooz'),
        'parent_item_colon' => __('Parent Genre:', 'fooz'),
        'edit_item' => __('Edit Genre', 'fooz'),
        'update_item' => __('Update Genre', 'fooz'),
        'add_new_item' => __('Add New Genre', 'fooz'),
        'new_item_name' => __('New Genre Name', 'fooz'),
        'menu_name' => __('Genres', 'fooz'),
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

    // Task 3.2: Register Custom Post Type "Books"
    $book_labels = array(
        'name' => _x('Books', 'Post type general name', 'fooz'),
        'singular_name' => _x('Book', 'Post type singular name', 'fooz'),
        'menu_name' => _x('Books', 'Admin Menu text', 'fooz'),
        'name_admin_bar' => _x('Book', 'Add New on Toolbar', 'fooz'),
        'add_new' => __('Add New', 'fooz'),
        'add_new_item' => __('Add New Book', 'fooz'),
        'new_item' => __('New Book', 'fooz'),
        'edit_item' => __('Edit Book', 'fooz'),
        'view_item' => __('View Book', 'fooz'),
        'all_items' => __('All Books', 'fooz'),
        'search_items' => __('Search Books', 'fooz'),
        'not_found' => __('No books found.', 'fooz'),
        'not_found_in_trash' => __('No books found in Trash.', 'fooz'),
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
        'menu_icon' => 'dashicons-book',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true, // Enable Gutenberg support
        'taxonomies' => array('genre'),
    );

    register_post_type('books', $book_args);
}
add_action('init', 'fooz_register_books_cpt');