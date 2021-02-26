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