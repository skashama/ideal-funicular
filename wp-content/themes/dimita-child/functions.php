<?php
 
// Load Bootstrap
function dimitaChild_enqueue_script() {
    wp_enqueue_script( 'bootstrap_js', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js', array('jquery'), NULL, true );
    
    wp_enqueue_style( 'bootstrap_css', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css', false, NULL, 'all' );
 }
 
 add_action( 'wp_enqueue_scripts', 'dimitaChild_enqueue_script' );


 // Load CSS
function dimita_child_css() {
    wp_deregister_style( 'styles-child' );
    wp_register_style( 'styles-child', get_stylesheet_directory_uri() . '/style.css' );
    wp_enqueue_style( 'styles-child' );
}

add_action('wp_enqueue_scripts', 'dimita_child_css', 1001);

// Event Post type

add_action( 'init', 'register_events' );

function register_events() {

    flush_rewrite_rules();

    $labels = array(
        'name' => 'Events',
        'singular_name' => 'Event',
        'add_new' => 'Add New Events'
    );

    $args = array (
        'public' => true,
        'has_archive' => true,
        'labels' => $labels,
        'rewrite' => array( 'slug' => 'events', 'with_front' => false ),
        'supports' => array( 'title', 'author', 'thumbnail', 'custom-fields', 'excerpt' )
    );

    register_post_type( 'events', $args);
} 

// Event Taxonomy : Industry

add_action( 'init', 'define_event_industry_taxonomy' );

function define_event_industry_taxonomy() {
    $labels = array(
        'name' => 'Industry'
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'query_var' => true,
        'rewrite' => true
    );

    register_taxonomy( 'Industry', 'events', $args);
}

// Industry Taxonomy Shortcode

function list_terms_custom_taxonomy( $atts ) {
    // Inside the function we extract custom taxonomy parameter of our shortcode

    extract( shortcode_atts( array(
        'custom_taxonomy' => '',
    ), $atts ) );

    // arguments for function wp_list_categories
    $args = array(
        'taxonomy' => $custom_taxonomy,
        'title_li' => ''
    );

    // We wrap it in unordered list
    echo '<ul>';
    echo wp_list_categories($args);
    echo '</ul>';
}

// Add a shortcode that executes our function
add_shortcode( 'ct_terms', 'list_terms_custom_taxonomy');

//Allow Text widgets to execute shortcodes
add_filter('widget_text', 'do_shortcode');

?>