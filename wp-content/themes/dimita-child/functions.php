<?php
 
// Load Bootstrap
function dimitaChild_enqueue_script() {
    wp_enqueue_script( 'jquery','https://code.jquery.com/jquery-3.5.1.slim.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'popper','https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js', array( 'jquery' ),'',true );
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
        'taxonomies' => array( 'category', 'post_tag' ),
        'rewrite' => array( 'slug' => 'events', 'with_front' => false ),
        'supports' => array( 'title', 'author', 'thumbnail', 'custom-fields', 'excerpt' ),
        'menu_icon' => 'dashicons-calendar-alt'
    );

    register_post_type( 'events', $args);
} 

// Register "Type of Events" Custom Taxonomy

add_action( 'init', 'type_event', 0 );

function type_event() {

	$labels = array(
		'name'                       => _x( 'Type of Events', 'Taxonomy General Name', 'dimita-child' ),
		'singular_name'              => _x( 'Type of Event', 'Taxonomy Singular Name', 'dimita-child' ),
		'menu_name'                  => __( 'Type of Event', 'dimita-child' ),
		'all_items'                  => __( 'All Types of Event', 'dimita-child' ),
		'parent_item'                => __( 'Parent Type of Event', 'dimita-child' ),
		'parent_item_colon'          => __( 'Type of Event:', 'dimita-child' ),
		'new_item_name'              => __( 'New Type of Event', 'dimita-child' ),
		'add_new_item'               => __( 'Add Type of Event', 'dimita-child' ),
		'edit_item'                  => __( 'Edit Type of Event', 'dimita-child' ),
		'update_item'                => __( 'Update Type of Event', 'dimita-child' ),
		'view_item'                  => __( 'View Type of Event', 'dimita-child' ),
		'separate_items_with_commas' => __( 'Separate Type of Event with commas', 'dimita-child' ),
		'add_or_remove_items'        => __( 'Add or remove Type of Event', 'dimita-child' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'dimita-child' ),
		'popular_items'              => __( 'Popular Types of Event', 'dimita-child' ),
		'search_items'               => __( 'Search Types of Event', 'dimita-child' ),
		'not_found'                  => __( 'Not Found', 'dimita-child' ),
		'no_terms'                   => __( 'No Type of Event', 'dimita-child' ),
		'items_list'                 => __( 'Types of Event list', 'dimita-child' ),
		'items_list_navigation'      => __( 'Type of Event list navigation', 'dimita-child' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'type_event', array( 'events' ), $args );

}
 
// Prepends category name(s) to the event titles
function tribe_events_title_include_cat ($title, $id) {
 
  $separator = ' ?? '; // HTML Separator between categories and title
  $cats = get_the_terms($id, 'tribe_events_cat');
  $is_ajax = defined('DOING_AJAX') && DOING_AJAX;
  $is_truly_admin = is_admin() && !$is_ajax;
 
  if (tribe_is_event($id) && $cats && !is_single() && !$is_truly_admin) {
    $cat_titles = array();
    foreach($cats as $i) {
      $cat_titles[] = $i->name;
    }
    $title = implode(', ', $cat_titles) . $separator . $title;
  }
 
  return $title;
}
add_filter('the_title', 'tribe_events_title_include_cat', 100, 2);

?>