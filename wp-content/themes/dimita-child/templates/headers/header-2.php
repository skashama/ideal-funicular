	<?php 
		$dimita_settings = dimita_global_settings();
		$show_minicart = (isset($dimita_settings['show-minicart']) && $dimita_settings['show-minicart']) ? ($dimita_settings['show-minicart']) : false;
		$enable_sticky_header = ( isset($dimita_settings['enable-sticky-header']) && $dimita_settings['enable-sticky-header'] ) ? ($dimita_settings['enable-sticky-header']) : false;
		$show_searchform = (isset($dimita_settings['show-searchform']) && $dimita_settings['show-searchform']) ? ($dimita_settings['show-searchform']) : false;
		$show_wishlist = (isset($dimita_settings['show-wishlist']) && $dimita_settings['show-wishlist']) ? ($dimita_settings['show-wishlist']) : false;
	?>
	<h1 class="bwp-title hide"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	<header id='bwp-header' class="bwp-header header-v2">	
    <?php if(isset($dimita_settings['show-header-top']) && $dimita_settings['show-header-top']){ ?>
      <div id="bwp-topbar" class="topbar-v1">
        <div class="topbar-inner">
          <div class="container">
            <div class="row">
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 topbar-left hidden-xs">
                <?php if( isset($dimita_settings['email']) && $dimita_settings['email'] ) : ?>
                <div class="email  hidden-xs">
                  <label><?php echo esc_html__("Email:","dimita") ?></label> <a href="<?php echo esc_attr($dimita_settings['link-email']); ?>"><?php echo esc_html($dimita_settings['email']); ?></a>
                </div>
                <?php endif; ?>
                <?php if( isset($dimita_settings['sale']) && $dimita_settings['sale'] ) : ?>
                <div class="location hidden-sm hidden-xs">
                  <label><?php echo esc_html__("Today’s Deal:","dimita") ?></label><?php echo esc_html($dimita_settings['sale']); ?>
                </div>
                <?php endif; ?>
              </div>
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 topbar-right">
                <?php if( isset($dimita_settings['location']) && $dimita_settings['location'] ) : ?>
                  <div class="order hidden-sm hidden-xs">
                    <a href="<?php echo esc_attr($dimita_settings['link-location']); ?>"><?php echo esc_html($dimita_settings['location']); ?></a>
                  </div>
                <?php endif; ?>
                <?php if(is_active_sidebar('header-top-link-2')){ ?>
                  <div class="block-top-link">					
                    <?php dynamic_sidebar( 'header-top-link-2' ); ?>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php } ?>
		<div class='header-wrapper '>
			<div class='header-content' data-sticky_header="<?php echo esc_attr($enable_sticky_header); ?>">
				<?php if(($show_searchform || $show_wishlist || $show_minicart || (is_active_sidebar('top-link')) ) && class_exists( 'WooCommerce' )){ ?>
				<div class="header-main">
					<div class="container">
						<div class="content-header">
							<div class="row">
								<div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 col-12 header-logo">
									<?php dimita_header_logo(); ?>
								</div>
								<div class="col-xl-8 col-lg-8 col-md-6 col-sm-6 col-3 wpbingo-menu-mobile header-main">
									<div class="header-menu-bg">
										<?php dimita_top_menu(); ?>
									</div>
								</div>
								<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-9 header-page-link">
									<!-- Begin Search -->
									<?php if($show_searchform && class_exists( 'WooCommerce' )){ ?>
									<div class="search-box">
										<div class="search-toggle"><i class="icon_search"></i></div>
									</div>
									<?php } ?>	
									<!-- End Search -->	
									<?php if(is_active_sidebar('top-link')){ ?>
									<div class="block-top-link">
										<?php dynamic_sidebar( 'top-link' ); ?>
									</div>
									<?php } ?>
									<?php if($show_wishlist && class_exists( 'YITH_WCWL' )){ ?>
									<div class="wishlist-box hidden-xs hidden-sm">
										<a href="<?php echo get_permalink( get_option('yith_wcwl_wishlist_page_id') ); ?>"><i class="icon-like"></i><?php echo esc_html__('My wishlist', 'dimita'); ?></a>
										<span class="count-wishlist"><?php echo yith_wcwl_count_all_products(); ?></span>
									</div>
									<?php } ?>
									<?php if($show_minicart && class_exists( 'WooCommerce' )){ ?>
									<div class="wpbingoCartTop">
										<?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
									</div>
									<?php } ?>								
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php }else{ ?>
					<div class="header-main header-default">
						<div class="container">
							<div class="content-header">
								<div class="row">
									<div class="col-xl-2 col-lg-2 col-md-6 col-sm-6 col-6 header-logo">
										<?php dimita_header_logo(); ?>
									</div>
									<div class="col-xl-10 col-lg-10 col-md-6 col-sm-6 col-6 wpbingo-menu-mobile header-main">
										<div class="header-menu-bg">
											<?php dimita_top_menu(); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div><!-- End header-wrapper -->
	</header><!-- End #bwp-header -->