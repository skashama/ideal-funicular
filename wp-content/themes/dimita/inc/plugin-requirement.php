<?php
/***** Active Plugin ********/
add_action( 'tgmpa_register', 'dimita_register_required_plugins' );
function dimita_register_required_plugins() {
    $plugins = array(
		array(
            'name'               => esc_html__('Woocommerce', 'dimita'), 
            'slug'               => 'woocommerce', 
            'required'           => false
        ),
		array(
            'name'      		 => esc_html__('Elementor', 'dimita'),
            'slug'     			 => 'elementor',
            'required' 			 => false
        ),		
		array(
            'name'               => esc_html__('Revolution Slider', 'dimita'), 
			'slug'               => 'revslider',
			'source'             => get_template_directory() . '/plugins/revslider.zip', 
			'required'           => true, 
        ),
		array(
            'name'               => esc_html__('Wpbingo Core', 'dimita'), 
            'slug'               => 'wpbingo', 
            'source'             => get_template_directory() . '/plugins/wpbingo.zip',
            'required'           => true, 
        ),			
		array(
            'name'               => esc_html__('Redux Framework', 'dimita'), 
            'slug'               => 'redux-framework', 
            'required'           => false
        ),			
		array(
            'name'      		 => esc_html__('Contact Form 7', 'dimita'),
            'slug'     			 => 'contact-form-7',
            'required' 			 => false
        ),	
		array(
            'name'     			 => esc_html__('YITH Woocommerce Wishlist', 'dimita'),
            'slug'      		 => 'yith-woocommerce-wishlist',
            'required' 			 => false
        ),
		array(
            'name'      		 => esc_html__('YITH Woocommerce Compare', 'dimita'),
            'slug'      		 => 'yith-woocommerce-compare',
            'required'			 => false
        ),		
		array(
            'name'     			 => esc_html__('WooCommerce Variation Swatches', 'dimita'),
            'slug'      		 => 'variation-swatches-for-woocommerce',
            'required' 			 => false
        ),
    );
    $config = array();
    tgmpa( $plugins, $config );
}