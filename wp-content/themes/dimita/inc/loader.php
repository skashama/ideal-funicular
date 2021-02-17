<?php
if ( ! function_exists( 'dimita_setup' ) ) :
		function dimita_setup() {
			load_theme_textdomain( 'dimita', get_template_directory() . '/languages' );
			// Add RSS feed links to <head> for posts and comments.
			add_theme_support( 'automatic-feed-links' );
			// Enable support for Post Thumbnails, and declare two sizes.
			add_theme_support( 'post-thumbnails' );
			set_post_thumbnail_size( 720, 484, true );
			add_image_size( 'dimita-full-width', 1170, 787, true );
			add_theme_support( 'title-tag' );
			/*
			 * Switch default core markup for search form, comment form, and comments
			 * to output valid HTML5.
			 */
			add_theme_support( 'html5', array(
				'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
			) );
			/*
			 * Enable support for Post Formats.
			 * See http://codex.wordpress.org/Post_Formats
			 */
			add_theme_support( 'post-formats', array(
				'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
			) );
			// This theme allows users to set a custom background.
			add_theme_support( 'custom-background', apply_filters( 'dimita_custom_background_args', array(
				'default-color' => 'f5f5f5',
			) ) );
			// Custom image header
			$dimita_image_headers = array(
				'default-image' => get_template_directory_uri().'/images/logo/logo-default.png',
				'uploads'       => true
			);
			add_theme_support( 'custom-header', $dimita_image_headers );
			// Tell the TinyMCE editor to use a custom stylesheet
			add_editor_style( 'css/editor-style.css' );
			// This theme uses its own gallery styles.
			add_filter( 'use_default_gallery_style', '__return_false' );
			add_theme_support( 'woocommerce' );
		}
		endif; 
		// dimita_setup
		add_action( 'after_setup_theme', 'dimita_setup' );
		function dimita_widgets_init() {
			register_sidebar( array(
				'name'          => esc_html__( 'Sidebar Blog', 'dimita' ),
				'id'            => 'sidebar-blog',
				'description'   => esc_html__( 'Additional sidebar that appears on the right.', 'dimita' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
			register_sidebar( array(
				'name'          => esc_html__( 'Header Top Link', 'dimita' ),
				'id'            => 'top-link',
				'description'   => esc_html__( 'Main sidebar that appears on the top.', 'dimita' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
			register_sidebar( array(
				'name'          => esc_html__( 'Header Top Link 2', 'dimita' ),
				'id'            => 'header-top-link-2',
				'description'   => esc_html__( 'Main sidebar that appears on the top.', 'dimita' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
			register_sidebar( array(
				'name'          => esc_html__( 'Sidebar Shop', 'dimita' ),
				'id'            => 'sidebar-product',
				'description'   => esc_html__( 'Main sidebar that appears on the left.', 'dimita' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
			register_sidebar( array(
				'name'          => esc_html__( 'Sidebar Vendors', 'dimita' ),
				'id'            => 'sidebar-vendor',
				'description'   => esc_html__( 'Main sidebar that appears on the left.', 'dimita' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );			
			register_sidebar( array(
				'name'          => esc_html__( 'Newsletter Popup', 'dimita' ),
				'id'            => 'newletter-popup-form',
				'description'   => esc_html__( 'Appears in the content top section of the site.', 'dimita' ),
				'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );	
			register_sidebar( array(
				'name'          => esc_html__( 'Menu Categories', 'dimita' ),
				'id'            => 'menu-categories',
				'description'   => esc_html__( 'Appears in the content top section of the site.', 'dimita' ),
				'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
			register_sidebar( array(
				'name'          => esc_html__( 'Filter Product', 'dimita' ),
				'id'            => 'filter-product',
				'description'   => esc_html__( 'Add widgets here to appear in your Filter Product.', 'dimita' ),
				'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
		}
		add_action( 'widgets_init', 'dimita_widgets_init' );
		function dimita_fonts_url() {
			$fonts_url = '';
			$rubik = _x( 'on', 'Rubik font: on or off', 'dimita' );
			$lato = _x( 'on', 'Lato Stencil One font: on or off', 'dimita' );
			if ( 'off' !== $rubik && 'off' !== $lato) {
				$font_families = array();
				if ( 'off' !== $rubik) {
				$font_families[] = 'Rubik:300,300i,400,400i,500,500i,700,700i';
				}
				if ( 'off' !== $lato ) {
				$font_families[] = 'Lato:300,300i,400,400i,700,700i';
				}
				$config_fonts = dimita_config_font();
				foreach($config_fonts as $key => $selector_fonts){
					if(isset($selector_fonts['font-family']) && $selector_fonts['font-family']){
						$font = str_replace(" ","+",$selector_fonts['font-family']);
						$font_default=implode(",",$font_families);
						$pos = strpos($font_default, $font);
						if ($pos === false)
							$font_families[] =	$font;
					}
				} 
				$query_args = array(
					'family' =>	urlencode( implode( '|', $font_families ) ),
					'subset' =>	urlencode( 'latin,latin-ext' ),
				);
				$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
			}
			return esc_url_raw( $fonts_url );
		}
		function dimita_scripts_styles() {
			wp_enqueue_style( 'dimita-fonts', dimita_fonts_url(), array(), null );
		}
		add_action( 'wp_enqueue_scripts', 'dimita_scripts_styles' );	
		function dimita_add_scripts() {
			// Load our main stylesheet.
			wp_enqueue_style( 'dimita-style', get_stylesheet_uri() );
			// Load the Internet Explorer specific stylesheet.
			wp_enqueue_style( 'dimita-ie', get_template_directory_uri() . '/css/ie.css', array( 'dimita-style' ), '20131205' );
			wp_style_add_data( 'dimita-ie', 'conditional', 'lt IE 9' );
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
			wp_enqueue_script( 'bootstrap',get_template_directory_uri().'/js/bootstrap.min.js', array('jquery'), null, true);
			wp_enqueue_script( 'jquery-mmenu-all',get_template_directory_uri().'/js/jquery.mmenu.all.min.js', array('jquery'), null, true);
			wp_enqueue_script( 'slick',get_template_directory_uri().'/js/slick.min.js',array('jquery'), null, true);
			wp_enqueue_script( 'instafeed',get_template_directory_uri().'/js/instafeed.min.js', array('jquery'), null, true);
			wp_enqueue_script( 'jquery-countdown',get_template_directory_uri().'/js/jquery.countdown.min.js', array('jquery'), null, true);
			wp_enqueue_script( 'jquery-fancybox', get_template_directory_uri().'/js/jquery.fancybox.min.js', array('jquery'), null, true);
			wp_enqueue_script( 'jquery-elevatezoom', get_template_directory_uri() . '/js/jquery.elevatezoom.js' , array('jquery'), null, true );
			wp_enqueue_script( 'jquery-swipebox', get_template_directory_uri() . '/js/jquery.swipebox.min.js' , array('jquery'), null, true );	
			wp_enqueue_script( 'isotopes', get_template_directory_uri().'/js/isotopes.js', array('jquery'), null, true);
			wp_enqueue_script( 'jquery-circlestime', get_template_directory_uri().'/js/jquery.circlestime.js', array('jquery'), null, true);
			wp_enqueue_script( '360imagerotate', get_template_directory_uri().'/js/360imagerotate.js', array('jquery'), null, true);
			wp_register_script( 'dimita-portfolio', get_template_directory_uri() . '/js/portfolio.js', array('jquery'), null, true );
			wp_enqueue_script( 'dimita-portfolio' );
			$direction = dimita_get_direction(); 
			if( is_rtl() || $direction == "rtl"){
				wp_enqueue_style( 'bootstrap-rtl',get_template_directory_uri().'/css/bootstrap-rtl.css' );
			}else{
				wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/css/bootstrap.css' );
			}
			wp_enqueue_style('fancybox', get_template_directory_uri().'/css/jquery.fancybox.css', array(), null);
			wp_enqueue_style('circlestime', get_template_directory_uri().'/css/jquery.circlestime.css', array(), null);
			wp_enqueue_style( 'mmenu-all', get_template_directory_uri().'/css/jquery.mmenu.all.css' );
			wp_enqueue_style('slick', get_template_directory_uri().'/css/slick/slick.css', array(), null);
			wp_enqueue_style( 'font-awesome',get_template_directory_uri().'/css/font-awesome.css' );
			wp_enqueue_style( 'materia',get_template_directory_uri().'/css/materia.css' );
			wp_enqueue_style( 'elegant',get_template_directory_uri().'/css/elegant.css' );
			wp_enqueue_style( 'ionicons',get_template_directory_uri().'/css/ionicons.css' );
			wp_enqueue_style( 'icomoon',get_template_directory_uri().'/css/icomoon.css' );
			wp_enqueue_style( 'Pe-icon-7-stroke',get_template_directory_uri().'/css/pe-icon-7-stroke.css' );
			wp_enqueue_style( 'flaticon',get_template_directory_uri().'/css/flaticon.css' );
			add_filter( 'woocommerce_enqueue_styles', '__return_false' );	
		}
		add_action( 'wp_enqueue_scripts', 'dimita_add_scripts' );
		function dimita_admin_style() {
		  wp_enqueue_style('dimita-admin-styles', get_template_directory_uri().'/inc/admin/css/options.css');
		}
		add_action('admin_enqueue_scripts', 'dimita_admin_style');		
?>