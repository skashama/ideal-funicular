<?php
/**
 * Dimita Settings Options
 */
if (!class_exists('Redux_Framework_dimita_settings')) {
    class Redux_Framework_dimita_settings {
        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;
        public function __construct() {
            if (!class_exists('ReduxFramework')) {
                return;
            }
            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }
        }
        public function initSettings() {
            $this->theme = wp_get_theme();
            // Set the default arguments
            $this->setArguments();
            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();
            // Create the sections and fields
            $this->setSections();
            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }
        function compiler_action($options, $css, $changed_values) {
        }
        function dynamic_section($sections) {
            return $sections;
        }
        function change_arguments($args) {
            return $args;
        }
        function change_defaults($defaults) {
            return $defaults;
        }
        function remove_demo() {
        }
        public function setSections() {
            $page_layouts = dimita_options_layouts();
            $sidebars = dimita_options_sidebars();
            $dimita_header_type = dimita_options_header_types();
            $dimita_banners_effect = dimita_options_banners_effect();
            // General Settings  ------------
            $this->sections[] = array(
                'icon' => 'fa fa-home',
                'icon_class' => 'icon',
                'title' => esc_html__('General', 'dimita'),
                'fields' => array(                
                )
            );  
            // Layout Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Layout', 'dimita'),
                'fields' => array(
                    array(
                        'id' => 'background_img',
                        'type' => 'media',
                        'title' => esc_html__('Background Image', 'dimita'),
                        'sub_desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id'=>'show-newletter',
                        'type' => 'switch',
                        'title' => esc_html__('Show Newletter Form', 'dimita'),
                        'default' => false,
                        'on' => esc_html__('Show', 'dimita'),
                        'off' => esc_html__('Hide', 'dimita'),
                    ),
                    array(
                        'id' => 'background_newletter_img',
                        'type' => 'media',
                        'title' => esc_html__('Popup Newletter Image', 'dimita'),
                        'url'=> true,
                        'readonly' => false,
                        'sub_desc' => '',
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/newsletter-image.jpg'
                        )
                    ),
                    array(
                            'id' => 'back_active',
                            'type' => 'switch',
                            'title' => esc_html__('Back to top', 'dimita'),
                            'sub_desc' => '',
                            'desc' => '',
                            'default' => '1'// 1 = on | 0 = off
                            ),                          
                    array(
                            'id' => 'direction',
                            'type' => 'select',
                            'title' => esc_html__('Direction', 'dimita'),
                            'options' => array( 'ltr' => esc_html__('Left to Right', 'dimita'), 'rtl' => esc_html__('Right to Left', 'dimita') ),
                            'default' => 'ltr'
                        )        
                )
            );
            // Logo & Icons Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Logo & Icons', 'dimita'),
                'fields' => array(
                    array(
                        'id'=>'sitelogo',
                        'type' => 'media',
                        'compiler'  => 'true',
                        'mode'      => false,
                        'title' => esc_html__('Logo', 'dimita'),
                        'desc'      => esc_html__('Upload Logo image default here.', 'dimita'),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/logo/logo.png'
                        )
                    )
                )
            );
			//Vertical Menu
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'subsection' => true,
                'title' => esc_html__('Vertical Menu', 'dimita'),
                'fields' => array( 
                    array(
                        'id'        => 'max_number_1530',
                        'type'      => 'text',
                        'title'     => esc_html__('Max number on screen >= 1530px', 'dimita'),
                        'default'   => '12'
                    ),
                    array(
                        'id'        => 'max_number_1200',
                        'type'      => 'text',
                        'title'     => esc_html__('Max number on on screen >= 1200px', 'dimita'),
                        'default'   => '8'
                    ),
					array(
                        'id'        => 'max_number_991',
                        'type'      => 'text',
                        'title'     => esc_html__('Max number on on screen >= 991px', 'dimita'),
                        'default'   => '6'
                    )
                )
            );
            // Header Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Header', 'dimita'),
                'fields' => array(
                    array(
                        'id'=>'header_style',
                        'type' => 'image_select',
                        'full_width' => true,
                        'title' => esc_html__('Header Type', 'dimita'),
                        'options' => $dimita_header_type,
                        'default' => '3'
                    ),
                    array(
                        'id'=>'show-header-top',
                        'type' => 'switch',
                        'title' => esc_html__('Show Header Top', 'dimita'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                    array(
                        'id'=>'show-searchform',
                        'type' => 'switch',
                        'title' => esc_html__('Show Search Form', 'dimita'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                    array(
                        'id'=>'show-ajax-search',
                        'type' => 'switch',
                        'title' => esc_html__('Show Ajax Search', 'dimita'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita')
                    ),
                    array(
                        'id'=>'limit-ajax-search',
                        'type' => 'text',
                        'title' => esc_html__('Limit Of Result Search', 'dimita'),
						'default' => 6,
						'required' => array('show-ajax-search','equals',true)
                    ),					
                    array(
                        'id'=>'search-cats',
                        'type' => 'switch',
                        'title' => esc_html__('Show Categories', 'dimita'),
                        'required' => array('search-type','equals',array('post', 'product')),
                        'default' => false,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                    array(
                        'id'=>'show-wishlist',
                        'type' => 'switch',
                        'title' => esc_html__('Show Wishlist', 'dimita'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                    array(
                        'id'=>'show-compare',
                        'type' => 'switch',
                        'title' => esc_html__('Show Compare', 'dimita'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),				
                    array(
                        'id'=>'show-minicart',
                        'type' => 'switch',
                        'title' => esc_html__('Show Mini Cart', 'dimita'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),		
                    array(
                        'id'=>'enable-sticky-header',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Sticky Header', 'dimita'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),		
                    array(
                        'id'=>'sale',
                        'type' => 'text',
                        'title' => esc_html__('Topbar Sale', 'dimita'),
                        'default' => ''
                    ),
                    array(
                        'id'=>'shipping',
                        'type' => 'text',
                        'title' => esc_html__('Shipping', 'dimita'),
                        'default' => ''
                    ),
					array(
                        'id'=>'email',
                        'type' => 'text',
                        'title' => esc_html__('Header Email', 'dimita'),
                        'default' => ''
                    ),
					array(
                        'id'=>'link-email',
                        'type' => 'text',
                        'title' => esc_html__('Header Link Email', 'dimita'),
                        'default' => '#'
                    ),
					array(
                        'id'=>'location',
                        'type' => 'text',
                        'title' => esc_html__('Header Location', 'dimita'),
                        'default' => ''
                    ),
					array(
                        'id'=>'link-location',
                        'type' => 'text',
                        'title' => esc_html__('Header Link Location', 'dimita'),
                        'default' => '#'
                    ),
					array(
                        'id'=>'open-time',
                        'type' => 'text',
                        'title' => esc_html__('Open Time', 'dimita'),
                        'default' => ''
                    ),
					array(
                        'id'=>'call-phone',
                        'type' => 'text',
                        'title' => esc_html__('Call Us', 'dimita'),
                        'default' => ''
                    )					
                )
            );
            // Footer Settings
            $footers = dimita_get_footers();
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Footer', 'dimita'),
                'fields' => array(
                    array(
                        'id' => 'footer_style',
                        'type' => 'image_select',
                        'title' => esc_html__('Footer Style', 'dimita'),
                        'sub_desc' => esc_html__( 'Select Footer Style', 'dimita' ),
                        'desc' => '',
                        'options' => $footers,
                        'default' => '32'
                    ),
                )
            );
            // Copyright Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Copyright', 'dimita'),
                'fields' => array(
                    array(
                        'id' => "footer-copyright",
                        'type' => 'textarea',
                        'title' => esc_html__('Copyright', 'dimita'),
                        'default' => sprintf( wp_kses('&copy; Copyright %s. All Rights Reserved.', 'dimita'), date('Y') )
                    ),
                    array(
                        'id'=>'footer-payments',
                        'type' => 'switch',
                        'title' => esc_html__('Show Payments Logos', 'dimita'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                    array(
                        'id'=>'footer-payments-image',
                        'type' => 'media',
                        'url'=> true,
                        'readonly' => false,
                        'title' => esc_html__('Payments Image', 'dimita'),
                        'required' => array('footer-payments','equals','1'),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/payments.png'
                        )
                    ),
                    array(
                        'id'=>'footer-payments-image-alt',
                        'type' => 'text',
                        'title' => esc_html__('Payments Image Alt', 'dimita'),
                        'required' => array('footer-payments','equals','1'),
                        'default' => ''
                    ),
                    array(
                        'id'=>'footer-payments-link',
                        'type' => 'text',
                        'title' => esc_html__('Payments Link URL', 'dimita'),
                        'required' => array('footer-payments','equals','1'),
                        'default' => ''
                    )
                )
            );
            // Page Title Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Page Title', 'dimita'),
                'fields' => array(
                    array(
                        'id'=>'page_title',
                        'type' => 'switch',
                        'title' => esc_html__('Show Page Title', 'dimita'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                    array(
                        'id'=>'page_title_bg',
                        'type' => 'media',
                        'url'=> true,
                        'readonly' => false,
                        'title' => esc_html__('Background', 'dimita'),
                        'required' => array('page_title','equals', true),
	                    'default' => array(
                            'url' => "",
                        )							
                    ),
                    array(
                        'id' => 'breadcrumb',
                        'type' => 'switch',
                        'title' => esc_html__('Show Breadcrumb', 'dimita'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                        'required' => array('page_title','equals', true),
                    ),
                )
            );
            // 404 Page Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('404 Error', 'dimita'),
                'fields' => array(
                    array(
                        'id'=>'title-error',
                        'type' => 'text',
                        'title' => esc_html__('Content Page 404', 'dimita'),
                        'desc' => esc_html__('Input a block slug name', 'dimita'),
                        'default' => 'page not found'
                    ),     
                    array(
                        'id'=>'sub-error',
                        'type' => 'text',
                        'title' => esc_html__('Content Page 404', 'dimita'),
                        'desc' => esc_html__('Input a block slug name', 'dimita'),
                        'default' => 'If difficulties persist, please contact the System Administrator of this site and report the error below...'
                    ),               
                    array(
                        'id'=>'btn-error',
                        'type' => 'text',
                        'title' => esc_html__('Button Page 404', 'dimita'),
                        'desc' => esc_html__('Input a block slug name', 'dimita'),
                        'default' => 'home page'
                    ),
                    array(
                        'id'=>'img-404',
                        'type' => 'media',
                        'compiler'  => 'true',
                        'mode'      => false,
                        'title' => esc_html__('Image', 'dimita'),
                        'desc'      => esc_html__('Upload images 404 default here.', 'dimita'),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/image_404.png'
                        )
                    )                      
                )
            );
            // Social Share Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Social Share', 'dimita'),
                'fields' => array(
                    array(
                        'id'=>'social-share',
                        'type' => 'switch',
                        'title' => esc_html__('Show Social Links', 'dimita'),
                        'desc' => esc_html__('Show social links in post and product, page, portfolio, etc.', 'dimita'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                    array(
                        'id'=>'share-fb',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Facebook Share', 'dimita'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                    array(
                        'id'=>'share-tw',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Twitter Share', 'dimita'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                    array(
                        'id'=>'share-linkedin',
                        'type' => 'switch',
                        'title' => esc_html__('Enable LinkedIn Share', 'dimita'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                    array(
                        'id'=>'share-pinterest',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Pinterest Share', 'dimita'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                )
            );
            $this->sections[] = array(
				'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Socials Link', 'dimita'),
                'fields' => array(
                    array(
                        'id'=>'socials_link',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Socials link', 'dimita'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                    array(
                        'id'=>'link-fb',
                        'type' => 'text',
                        'title' => esc_html__('Enter Facebook link', 'dimita'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-tw',
                        'type' => 'text',
                        'title' => esc_html__('Enter Twitter link', 'dimita'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-linkedin',
                        'type' => 'text',
                        'title' => esc_html__('Enter LinkedIn link', 'dimita'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-youtube',
                        'type' => 'text',
                        'title' => esc_html__('Enter Youtube link', 'dimita'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-pinterest',
                        'type' => 'text',
                        'title' => esc_html__('Enter Pinterest link', 'dimita'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-instagram',
                        'type' => 'text',
                        'title' => esc_html__('Enter Instagram link', 'dimita'),
						'default' => '#'
                    ),
                )
            );			
            //     The end -----------
            // Styling Settings  -------------
            $this->sections[] = array(
                'icon' => 'icofont icofont-brand-appstore',
                'icon_class' => 'icon',
                'title' => esc_html__('Styling', 'dimita'),
                'fields' => array(              
                )
            );  
            // Color & Effect Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Color & Effect', 'dimita'),
                'fields' => array(
                    array(
                        'id'=>'compile-css',
                        'type' => 'switch',
                        'title' => esc_html__('Compile Css', 'dimita'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),					
                    array(
                      'id' => 'main_theme_color',
                      'type' => 'color',
                      'title' => esc_html__('Main Theme Color', 'dimita'),
                      'subtitle' => esc_html__('Select a main color for your site.', 'dimita'),
                      'default' => '#222222',
                      'transparent' => false,
					  'required' => array('compile-css','equals',array(true)),
                    ),      
                    array(
                        'id'=>'show-loading-overlay',
                        'type' => 'switch',
                        'title' => esc_html__('Loading Overlay', 'dimita'),
                        'default' => false,
                        'on' => esc_html__('Show', 'dimita'),
                        'off' => esc_html__('Hide', 'dimita'),
                    ),
                    array(
                        'id'=>'banners_effect',
                        'type' => 'image_select',
                        'full_width' => true,
                        'title' => esc_html__('Banner Effect', 'dimita'),
                        'options' => $dimita_banners_effect,
                        'default' => 'banners-effect-1'
                    )                   
                )
            );
            // Typography Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Typography', 'dimita'),
                'fields' => array(
                    array(
                        'id'=>'select-google-charset',
                        'type' => 'switch',
                        'title' => esc_html__('Select Google Font Character Sets', 'dimita'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                    array(
                        'id'=>'google-charsets',
                        'type' => 'button_set',
                        'title' => esc_html__('Google Font Character Sets', 'dimita'),
                        'multi' => true,
                        'required' => array('select-google-charset','equals',true),
                        'options'=> array(
                            'cyrillic' => 'Cyrrilic',
                            'cyrillic-ext' => 'Cyrrilic Extended',
                            'greek' => 'Greek',
                            'greek-ext' => 'Greek Extended',
                            'khmer' => 'Khmer',
                            'latin' => 'Latin',
                            'latin-ext' => 'Latin Extneded',
                            'vietnamese' => 'Vietnamese'
                        ),
                        'default' => array('latin','greek-ext','cyrillic','latin-ext','greek','cyrillic-ext','vietnamese','khmer')
                    ),
                    array(
                        'id'=>'family_font_body',
                        'type' => 'typography',
                        'title' => esc_html__('Body Font', 'dimita'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
						'output'      => array('body'),
                        'color' => false,
                        'default'=> array(
                            'color'=>"#777777",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'14px',
                            'line-height' => '22px'
                        ),
                    ),
                    array(
                        'id'=>'h1-font',
                        'type' => 'typography',
                        'title' => esc_html__('H1 Font', 'dimita'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' 	=> false,
						'output'      => array('body h1'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'36px',
                            'line-height' => '44px'
                        ),
                    ),
                    array(
                        'id'=>'h2-font',
                        'type' => 'typography',
                        'title' => esc_html__('H2 Font', 'dimita'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h2'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'300',
                            'font-family'=>'Open Sans',
                            'font-size'=>'30px',
                            'line-height' => '40px'
                        ),
                    ),
                    array(
                        'id'=>'h3-font',
                        'type' => 'typography',
                        'title' => esc_html__('H3 Font', 'dimita'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h3'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'25px',
                            'line-height' => '32px'
                        ),
                    ),
                    array(
                        'id'=>'h4-font',
                        'type' => 'typography',
                        'title' => esc_html__('H4 Font', 'dimita'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h4'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'20px',
                            'line-height' => '27px'
                        ),
                    ),
                    array(
                        'id'=>'h5-font',
                        'type' => 'typography',
                        'title' => esc_html__('H5 Font', 'dimita'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h5'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'600',
                            'font-family'=>'Open Sans',
                            'font-size'=>'14px',
                            'line-height' => '18px'
                        ),
                    ),
                    array(
                        'id'=>'h6-font',
                        'type' => 'typography',
                        'title' => esc_html__('H6 Font', 'dimita'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h6'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'14px',
                            'line-height' => '18px'
                        ),
                    ),
                    array(
                        'id'=>'family_font_custom',
                        'type' => 'typography',
                        'title' => esc_html__('Custom Font', 'dimita'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
                        'default'=> array(
                            'color'=>"#777777",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'14px',
                            'line-height' => '22px'
                        ),
                    ),
                    array(
                            'id' => 'class_font_custom',
                            'type' => 'text',
                            'title' => esc_html__('Custom Class', 'dimita'),
                            'sub_desc' => esc_html__( 'Example : .product_title .', 'dimita' ), 
                            'default' => '.product_title'
                    )                   
                )
            );
            //     The end -----------          
            if ( class_exists( 'Woocommerce' ) ) :
                $this->sections[] = array(
                    'icon' => 'icofont icofont-cart-alt',
                    'icon_class' => 'icon',
                    'title' => esc_html__('Ecommerce', 'dimita'),
                    'fields' => array(              
                    )
                );
                $this->sections[] = array(
                    'icon' => 'icofont icofont-double-right',
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Product Archives', 'dimita'),
                    'fields' => array(
                        array(
                            'id'=>'category_style',
                            'title' => esc_html__('Product Archives Style', 'dimita'),
                            'type' => 'select',
							'options' => array(
								'default' => esc_html__('Filter Default', 'dimita'),
                                'sidebar' => esc_html__('Sidebar', 'dimita'),       
                                'filter_drawer' => esc_html__('Filter Drawer', 'dimita'),
								'filter_dropdown' => esc_html__('Filter Dropdown', 'dimita'),
								'filter_offcanvas' => esc_html__('Filter Off Canvas', 'dimita'),
                             ),
                            'default' => 'sidebar',
                        ),
                        array(
                            'id'=>'woo-show-rating',
                            'type' => 'switch',
                            'title' => esc_html__('Show Rating in Woocommerce Products Widget', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),
                        array(
                            'id'=>'category-view-mode',
                            'type' => 'button_set',
                            'title' => esc_html__('View Mode', 'dimita'),
                            'options' => dimita_ct_category_view_mode(),
                            'default' => 'grid',
                        ),
                        array(
                            'id' => 'product_count',
                            'type' => 'text',
                            'title' => esc_html__('Shop pages show at product', 'dimita'),
                            'default' => '12',
                            'sub_desc' => esc_html__( 'Type Count Product Per Shop Page', 'dimita' ),
                        ),							
                        array(
                            'id' => 'product_col_large',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Listing column Desktop', 'dimita'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',                         
                                    '6' => '6'                          
                                ),
                            'default' => '4',
                            'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'dimita' ),
                        ),
                        array(
                            'id' => 'product_col_medium',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Listing column Medium Desktop', 'dimita'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',                         
                                    '6' => '6'                          
                                ),
                            'default' => '3',
                            'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'dimita' ),
                        ),
                        array(
                            'id' => 'product_col_sm',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Listing column Ipad Screen', 'dimita'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',                         
                                    '6' => '6'                          
                                ),
                            'default' => '3',
                            'sub_desc' => esc_html__( 'Select number of column on Ipad Screen', 'dimita' ),
                        ),
						array(
                            'id' => 'product_col_xs',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Listing column Mobile Screen', 'dimita'),
                            'options' => array(
									'1' => '1',
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',                         
                                ),
                            'default' => '2',
							'required' => array('category-view-mode','equals','grid'),
                            'sub_desc' => esc_html__( 'Select number of column on Mobile Screen', 'dimita' ),
                        ),
						array(
                            'id'=>'show-bestseller-category',
                            'type' => 'switch',
                            'title' => esc_html__('Show Bestseller on Page Category', 'dimita'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),
						 array(
                            'id' => 'bestseller_limit',
                            'type' => 'text',
                            'title' => esc_html__('Shop product Bestseller', 'dimita'),
                            'default' => '9',
							'required' => array('show-bestseller-category','equals',true),
                        ),
						array(
                            'id'=>'show-banner-category',
                            'type' => 'switch',
                            'title' => esc_html__('Show Banner Category', 'dimita'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),
                        array(
                            'id'=>'category-image-hover',
                            'type' => 'switch',
                            'title' => esc_html__('Enable Image Hover Effect', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),
                        array(
                            'id'=>'category-hover',
                            'type' => 'switch',
                            'title' => esc_html__('Enable Hover Effect', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),
                        array(
                            'id'=>'product-wishlist',
                            'type' => 'switch',
                            'title' => esc_html__('Show Wishlist', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),
						array(
							'id'=>'product-compare',
							'type' => 'switch',
							'title' => esc_html__('Show Compare', 'dimita'),
							'default' => false,
							'on' => esc_html__('Yes', 'dimita'),
							'off' => esc_html__('No', 'dimita'),
						),						
                        array(
                            'id'=>'product_quickview',
                            'type' => 'switch',
                            'title' => esc_html__('Show Quick View', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita')
                        ),
                        array(
                            'id'=>'product-quickview-label',
                            'type' => 'text',
                            'required' => array('product-quickview','equals',true),
                            'title' => esc_html__('"Quick View" Text', 'dimita'),
                            'default' => ''
                        ),
                    )
                );
                $this->sections[] = array(
                    'icon' => 'icofont icofont-double-right',
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Single Product', 'dimita'),
                    'fields' => array(
                        array(
                            'id'=>'sidebar_detail_product',
                            'type' => 'image_select',
                            'title' => esc_html__('Page Layout', 'dimita'),
                            'options' => $page_layouts,
                            'default' => 'full'
                        ),
                        array(
                            'id'=>'product-stock',
                            'type' => 'switch',
                            'title' => esc_html__('Show "Out of stock" Status', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),
						array(
                            'id'=>'show-sticky-cart',
                            'type' => 'switch',
                            'title' => esc_html__('Show Sticky Cart Product', 'dimita'),
                            'default' => false,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),
						array(
                            'id'=>'show-brands',
                            'type' => 'switch',
                            'title' => esc_html__('Show Brands', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),
						array(
                            'id'=>'show-offer',
                            'type' => 'switch',
                            'title' => esc_html__('Show Offer List', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),						
						array(
                            'id'=>'show-countdown',
                            'type' => 'switch',
                            'title' => esc_html__('Show CountDown', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),
                        array(
                            'id'=>'product-short-desc',
                            'type' => 'switch',
                            'title' => esc_html__('Show Short Description', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),
                        array(
                            'id'=>'show-trust-bages',
                            'type' => 'switch',
                            'title' => esc_html__('Show Trust Bages Product', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),
						array(
							'id' => 'trust-bages',
							'type' => 'media',
							'title' => esc_html__('Trust Bages', 'dimita'),
							'url'=> true,
							'readonly' => false,
							'required' => array('show-trust-bages','equals',true),
							'sub_desc' => '',
							'default' => array(
								'url' => ""
							)
						),                 
                        array(
                            'id'=>'product-related',
                            'type' => 'switch',
                            'title' => esc_html__('Show Related Products', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),
                        array(
                            'id'=>'product-related-count',
                            'type' => 'text',
                            'required' => array('product-related','equals',true),
                            'title' => esc_html__('Related Products Count', 'dimita'),
                            'default' => '10'
                        ),
                        array(
                            'id'=>'product-related-cols',
                            'type' => 'button_set',
                            'required' => array('product-related','equals',true),
                            'title' => esc_html__('Related Product Columns', 'dimita'),
                            'options' => dimita_ct_related_product_columns(),
                            'default' => '4',
                        ),
                        array(
                            'id'=>'product-upsell',
                            'type' => 'switch',
                            'title' => esc_html__('Show Upsell Products', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),                      
                        array(
                            'id'=>'product-upsell-count',
                            'type' => 'text',
                            'required' => array('product-upsell','equals',true),
                            'title' => esc_html__('Upsell Products Count', 'dimita'),
                            'default' => '10'
                        ),
                        array(
                            'id'=>'product-upsell-cols',
                            'type' => 'button_set',
                            'required' => array('product-upsell','equals',true),
                            'title' => esc_html__('Upsell Product Columns', 'dimita'),
                            'options' => dimita_ct_related_product_columns(),
                            'default' => '3',
                        ),
                        array(
                            'id'=>'product-crosssells',
                            'type' => 'switch',
                            'title' => esc_html__('Show Crooss Sells Products', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),                      
                        array(
                            'id'=>'product-crosssells-count',
                            'type' => 'text',
                            'required' => array('product-crosssells','equals',true),
                            'title' => esc_html__('Crooss Sells Products Count', 'dimita'),
                            'default' => '10'
                        ),
                        array(
                            'id'=>'product-crosssells-cols',
                            'type' => 'button_set',
                            'required' => array('product-crosssells','equals',true),
                            'title' => esc_html__('Crooss Sells Product Columns', 'dimita'),
                            'options' => dimita_ct_related_product_columns(),
                            'default' => '3',
                        ),						
                        array(
                            'id'=>'product-hot',
                            'type' => 'switch',
                            'title' => esc_html__('Show "Hot" Label', 'dimita'),
                            'desc' => esc_html__('Will be show in the featured product.', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),
                        array(
                            'id'=>'product-hot-label',
                            'type' => 'text',
                            'required' => array('product-hot','equals',true),
                            'title' => esc_html__('"Hot" Text', 'dimita'),
                            'default' => ''
                        ),
                        array(
                            'id'=>'product-sale',
                            'type' => 'switch',
                            'title' => esc_html__('Show "Sale" Label', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),
                         array(
                            'id'=>'product-sale-percent',
                            'type' => 'switch',
                            'required' => array('product-sale','equals',true),
                            'title' => esc_html__('Show Sale Price Percentage', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),  
                        array(
                            'id'=>'product-share',
                            'type' => 'switch',
                            'title' => esc_html__('Show Social Share Links', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),
                    )
                );
                $this->sections[] = array(
                    'icon' => 'icofont icofont-double-right',
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Image Product', 'dimita'),
                    'fields' => array(
                        array(
                            'id'=>'product-thumbs',
                            'type' => 'switch',
                            'title' => esc_html__('Show Thumbnails', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),
                        array(
                            'id'=>'position-thumbs',
                            'type' => 'button_set',
                            'title' => esc_html__('Position Thumbnails', 'dimita'),
                            'options' => array('left' => esc_html__('Left', 'dimita'),
												'right' => esc_html__('Right', 'dimita'),
												'bottom' => esc_html__('Bottom', 'dimita'),
												'outsite' => esc_html__('Outsite', 'dimita')),
                            'default' => 'bottom',
							'required' => array('product-thumbs','equals',true),
                        ),						
                        array(
                            'id' => 'product-thumbs-count',
                            'type' => 'button_set',
                            'title' => esc_html__('Thumbnails Count', 'dimita'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4', 
									'5' => '5', 									
                                    '6' => '6'                          
                                ),
							'default' => '4',
							'required' => array('product-thumbs','equals',true),
                        ),
                        array(
                            'id'=>'product-image-popup',
                            'type' => 'switch',
                            'title' => esc_html__('Enable Image Popup', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
                        ),						
                        array(
                            'id'=>'layout-thumbs',
                            'type' => 'button_set',
                            'title' => esc_html__('Layouts Thumbnails', 'dimita'),
                            'options' => array('zoom' => esc_html__('Zoom', 'dimita'),
												'scroll' => esc_html__('Scroll', 'dimita'),
												'sticky' => esc_html__('Sticky', 'dimita'),
												'sticky2' => esc_html__('Sticky 2', 'dimita'),
												'slider' => esc_html__('Slider', 'dimita'),
												'small_grid' => esc_html__('Image Grid', 'dimita'),
											),		
                            'default' => 'zoom',
                        ),
                        array(
                            'id'=>'zoom-type',
                            'type' => 'button_set',
                            'title' => esc_html__('Zoom Type', 'dimita'),
                            'options' => array('inner' => esc_html__('Inner', 'dimita'), 'lens' => esc_html__('Lens', 'dimita')),
                            'default' => 'inner',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-scroll',
                            'type' => 'switch',
                            'title' => esc_html__('Scroll Zoom', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-border',
                            'type' => 'text',
                            'title' => esc_html__('Border Size', 'dimita'),
                            'default' => '2',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-border-color',
                            'type' => 'color',
                            'title' => esc_html__('Border Color', 'dimita'),
                            'default' => '#f9b61e',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),                      
                        array(
                            'id'=>'zoom-lens-size',
                            'type' => 'text',
                            'required' => array('zoom-type','equals',array('lens')),
                            'title' => esc_html__('Lens Size', 'dimita'),
                            'default' => '200',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-lens-shape',
                            'type' => 'button_set',
                            'required' => array('zoom-type','equals',array('lens')),
                            'title' => esc_html__('Lens Shape', 'dimita'),
                            'options' => array('round' => esc_html__('Round', 'dimita'), 'square' => esc_html__('Square', 'dimita')),
                            'default' => 'square',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-contain-lens',
                            'type' => 'switch',
                            'required' => array('zoom-type','equals',array('lens')),
                            'title' => esc_html__('Contain Lens Zoom', 'dimita'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'dimita'),
                            'off' => esc_html__('No', 'dimita'),
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-lens-border',
                            'type' => 'text',
                            'required' => array('zoom-type','equals',array('lens')),
                            'title' => esc_html__('Lens Border', 'dimita'),
                            'default' => true,
							'required' => array('layout-thumbs','equals',"zoom")
                        ),
                    )
                );
            endif;
            // Blog Settings  -------------
            $this->sections[] = array(
                'icon' => 'icofont icofont-ui-copy',
                'icon_class' => 'icon',
                'title' => esc_html__('Blog', 'dimita'),
                'fields' => array(              
                )
            );      
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Blog & Post Archives', 'dimita'),
                'fields' => array(
                    array(
                        'id'=>'post-format',
                        'type' => 'switch',
                        'title' => esc_html__('Show Post Format', 'dimita'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                    array(
                        'id'=>'hot-label',
                        'type' => 'text',
                        'title' => esc_html__('"HOT" Text', 'dimita'),
                        'desc' => esc_html__('Hot post label', 'dimita'),
                        'default' => ''
                    ),
                    array(
                        'id'=>'sidebar_blog',
                        'type' => 'image_select',
                        'title' => esc_html__('Page Layout', 'dimita'),
                        'options' => $page_layouts,
                        'default' => 'left'
                    ),
                    array(
                        'id' => 'layout_blog',
                        'type' => 'button_set',
                        'title' => esc_html__('Layout Blog', 'dimita'),
                        'options' => array(
                                'list'  =>  esc_html__( 'List', 'dimita' ),
                                'grid' =>  esc_html__( 'Grid', 'dimita' ),
								'masonry' =>  esc_html__( 'Masonry', 'dimita' )	
                        ),
                        'default' => 'list',
                        'sub_desc' => esc_html__( 'Select style layout blog', 'dimita' ),
                    ),
                    array(
                        'id' => 'blog_col_large',
                        'type' => 'button_set',
                        'title' => esc_html__('Blog Listing column Desktop', 'dimita'),
                        'required' => array('layout_blog','equals','grid'),
                        'options' => array(
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',                         
                                '6' => '6'                          
                            ),
                        'default' => '4',
                        'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'dimita' ),
                    ),
                    array(
                        'id' => 'blog_col_medium',
                        'type' => 'button_set',
                        'title' => esc_html__('Blog Listing column Medium Desktop', 'dimita'),
                        'required' => array('layout_blog','equals','grid'),
                        'options' => array(
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',                         
                                '6' => '6'                          
                            ),
                        'default' => '3',
                        'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'dimita' ),
                    ),   
                    array(
                        'id' => 'blog_col_sm',
                        'type' => 'button_set',
                        'title' => esc_html__('Blog Listing column Ipad Screen', 'dimita'),
                        'required' => array('layout_blog','equals','grid'),
                        'options' => array(
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',                         
                                '6' => '6'                          
                            ),
                        'default' => '3',
                        'sub_desc' => esc_html__( 'Select number of column on Ipad Screen', 'dimita' ),
                    ),   					
                    array(
                        'id'=>'archives-author',
                        'type' => 'switch',
                        'title' => esc_html__('Show Author', 'dimita'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                    array(
                        'id'=>'archives-comments',
                        'type' => 'switch',
                        'title' => esc_html__('Show Count Comments', 'dimita'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),                  
                    array(
                        'id'=>'blog-excerpt',
                        'type' => 'switch',
                        'title' => esc_html__('Show Excerpt', 'dimita'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                    array(
                        'id'=>'list-blog-excerpt-length',
                        'type' => 'text',
                        'required' => array('blog-excerpt','equals',true),
                        'title' => esc_html__('List Excerpt Length', 'dimita'),
                        'desc' => esc_html__('The number of words', 'dimita'),
                        'default' => '20',
                    ),
                    array(
                        'id'=>'grid-blog-excerpt-length',
                        'type' => 'text',
                        'required' => array('blog-excerpt','equals',true),
                        'title' => esc_html__('Grid Excerpt Length', 'dimita'),
                        'desc' => esc_html__('The number of words', 'dimita'),
                        'default' => '12',
                    ),                  
                )
            );
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Single Post', 'dimita'),
                'fields' => array(
                    array(
                        'id'=>'post-single-layout',
                        'type' => 'image_select',
                        'title' => esc_html__('Page Layout', 'dimita'),
                        'options' => $page_layouts,
                        'default' => 'left'
                    ),
                    array(
                        'id'=>'post-title',
                        'type' => 'switch',
                        'title' => esc_html__('Show Title', 'dimita'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                    array(
                        'id'=>'post-author',
                        'type' => 'switch',
                        'title' => esc_html__('Show Author Info', 'dimita'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
                    ),
                    array(
                        'id'=>'post-comments',
                        'type' => 'switch',
                        'title' => esc_html__('Show Comments', 'dimita'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'dimita'),
                        'off' => esc_html__('No', 'dimita'),
					)
				)
			);	
            $this->sections[] = array(
				'id' => 'wbc_importer_section',
				'title'  => esc_html__( 'Demo Importer', 'dimita' ),
				'icon'   => 'fa fa-cloud-download',
				'desc'   => wp_kses( 'Increase your max execution time, try 40000 I know its high but trust me.<br>
				Increase your PHP memory limit, try 512MB.<br>
				1. The import process will work best on a clean install. You can use a plugin such as WordPress Reset to clear your data for you.<br>
				2. Ensure all plugins are installed beforehand, e.g. WooCommerce - any plugins that you add content to.<br>
				3. Be patient and wait for the import process to complete. It can take up to 3-5 minutes.<br>
				4. Enjoy','social' ),				
				'fields' => array(
					array(
						'id'   => 'wbc_demo_importer',
						'type' => 'wbc_importer'
					)
				)
            );			
        }
        public function setHelpTabs() {
        }
        public function setArguments() {
            $theme = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args = array(
                'opt_name'          => 'dimita_settings',
                'display_name'      => $theme->get('Name') . ' ' . esc_html__('Theme Options', 'dimita'),
                'display_version'   => esc_html__('Theme Version: ', 'dimita') . dimita_version,
                'menu_type'         => 'submenu',
                'allow_sub_menu'    => true,
                'menu_title'        => esc_html__('Theme Options', 'dimita'),
                'page_title'        => esc_html__('Theme Options', 'dimita'),
                'footer_credit'     => esc_html__('Theme Options', 'dimita'),
                'google_api_key' => 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII',
                'disable_google_fonts_link' => true,
                'async_typography'  => false,
                'admin_bar'         => false,
                'admin_bar_icon'       => 'dashicons-admin-generic',
                'admin_bar_priority'   => 50,
                'global_variable'   => '',
                'dev_mode'          => false,
                'customizer'        => false,
                'compiler'          => false,
                'page_priority'     => null,
                'page_parent'       => 'themes.php',
                'page_permissions'  => 'manage_options',
                'menu_icon'         => '',
                'last_tab'          => '',
                'page_icon'         => 'icon-themes',
                'page_slug'         => 'dimita_settings',
                'save_defaults'     => true,
                'default_show'      => false,
                'default_mark'      => '',
                'show_import_export' => true,
                'show_options_object' => false,
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => false,
                'output_tag'        => false,
                'database'              => '',
                'system_info'           => false,
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                ),
                'ajax_save'                 => false,
                'use_cdn'                   => true,
            );
            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
            }
            $this->args['intro_text'] = sprintf('<p style="color: #0088cc">'.wp_kses('Please regenerate again default css files in <strong>Skin > Compile Default CSS</strong> after <strong>update theme</strong>.', 'dimita').'</p>', $v);
        }           
    }
	if ( !function_exists( 'wbc_extended_example' ) ) {
		function wbc_extended_example( $demo_active_import , $demo_directory_path ) {
			reset( $demo_active_import );
			$current_key = key( $demo_active_import );	
			if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] )) {
				//Import Sliders
				if ( class_exists( 'RevSlider' ) ) {
					$wbc_sliders_array = array(
						'dimita' => array('slider-1.zip','slider-2.zip','slider-3.zip','slider-4.zip','slider-5.zip','slider-6.zip','slider-7.zip','slider-8.zip','slider-9.zip')
					);
					$wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];
					if( is_array( $wbc_slider_import ) ){
						foreach ($wbc_slider_import as $slider_zip) {
							if ( !empty($slider_zip) && file_exists( $demo_directory_path.'rev_slider/'.$slider_zip ) ) {
								$slider = new RevSlider();
								$slider->importSliderFromPost( true, true, $demo_directory_path.'rev_slider/'.$slider_zip );
							}
						}
					}else{
						if ( file_exists( $demo_directory_path.'rev_slider/'.$wbc_slider_import ) ) {
							$slider = new RevSlider();
							$slider->importSliderFromPost( true, true, $demo_directory_path.'rev_slider/'.$wbc_slider_import );
						}
					}
				}				
				// Setting Menus
				$primary = get_term_by( 'name', 'Main menu', 'nav_menu' );
				$primary_vertical = get_term_by( 'name', 'Vertical Menu', 'nav_menu' );
				$primary_currency = get_term_by( 'name', 'Currency Menu', 'nav_menu' );
				$primary_language = get_term_by( 'name', 'Language Menu', 'nav_menu' );
				if ( isset( $primary->term_id ) ) {
					set_theme_mod( 'nav_menu_locations', array(
							'main_navigation' => $primary->term_id,
							'vertical_menu' => $primary_vertical->term_id,
							'currency_menu' => $primary_currency->term_id,
							'language_menu' => $primary_language->term_id	
						)
					);
				}
				// Set HomePage
				$home_page = 'Home 1';	
				$page = get_page_by_title( $home_page );
				if ( isset( $page->ID ) ) {
					update_option( 'page_on_front', $page->ID );
					update_option( 'show_on_front', 'page' );
				}					
			}
		}
		// Uncomment the below
		add_action( 'wbc_importer_after_content_import', 'wbc_extended_example', 10, 2 );
	}
    global $reduxDimitaSettings;
    $reduxDimitaSettings = new Redux_Framework_dimita_settings();
}