	<?php 
		$dimita_settings = dimita_global_settings();
		$show_minicart = (isset($dimita_settings['show-minicart']) && $dimita_settings['show-minicart']) ? ($dimita_settings['show-minicart']) : false;
		$enable_sticky_header = ( isset($dimita_settings['enable-sticky-header']) && $dimita_settings['enable-sticky-header'] ) ? ($dimita_settings['enable-sticky-header']) : false;
		$show_searchform = (isset($dimita_settings['show-searchform']) && $dimita_settings['show-searchform']) ? ($dimita_settings['show-searchform']) : false;
		$show_wishlist = (isset($dimita_settings['show-wishlist']) && $dimita_settings['show-wishlist']) ? ($dimita_settings['show-wishlist']) : false;
		$show_compare = (isset($dimita_settings['show-compare']) && $dimita_settings['show-compare']) ? ($dimita_settings['show-compare']) : false;
	?>
	<h1 class="bwp-title hide"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	<header id='bwp-header' class="bwp-header header-v10">
		<?php if(isset($dimita_settings['show-header-top']) && $dimita_settings['show-header-top']){ ?>
		<div id="bwp-topbar" class="topbar-v1">
			<div class="topbar-inner">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 topbar-left">
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
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 topbar-right">
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
				<?php if(($show_searchform || $show_minicart || $show_wishlist || (is_active_sidebar('top-link')) ) && class_exists( 'WooCommerce' )){ ?>
				<div class="header-top">
					<div class="container">
						<div class="row">
							<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 header-logo">
								<?php dimita_header_logo(); ?>
							</div>
							<div class="col-xl-9 col-lg-9 col-md-6 col-sm-6 col-6 header-page-info">
								<div class="header-info">
									<?php if( isset($dimita_settings['call-phone']) && $dimita_settings['call-phone'] ) : ?>
										<div class="header-info-content hidden-sm hidden-xs">
											<div class="icon"><i class="icon_phone" aria-hidden="true"></i></div>
											<div class="content">
												<label><?php echo esc_html__("call us:","dimita") ?></label>
												<p><?php echo esc_html($dimita_settings['call-phone']); ?></p>
											</div>
										</div>
									<?php endif; ?>
									<?php if( isset($dimita_settings['open-time']) && $dimita_settings['open-time'] ) : ?>
										<div class="header-info-content hidden-md hidden-sm hidden-xs">
											<div class="icon"><i class="icon_clock_alt" aria-hidden="true"></i></div>
											<div class="content">
												<label><?php echo esc_html__("open time:","dimita") ?></label>
												<p><?php echo esc_html($dimita_settings['open-time']); ?></p>
											</div>
										</div>
									<?php endif; ?>
								</div>
								<div class="header-page-link">
									<?php if($show_searchform && class_exists( 'WooCommerce' )){ ?>
										<div class="search-box hidden-md hidden-lg">
											<div class="search-toggle"><i class="icon_search"></i></div>
										</div>
									<?php } ?>
									<?php if(is_active_sidebar('top-link')){ ?>
										<div class="block-top-link acount">
											<?php dynamic_sidebar( 'top-link' ); ?>
										</div>
									<?php } ?>
									<?php if($show_compare && class_exists( 'YITH_WOOCOMPARE' )){ ?>
									<div class="compare-box hidden-sm hidden-xs">        
										<a href="/?action=yith-woocompare-view-table&iframe=yes" class="yith-woocompare-open"><?php echo esc_html__('Compare', 'dimita')?></a>
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
				<div class="header-bottom">
					<div class="container">
						<div class="content-header">
							<div class="wpbingo-menu-mobile header-main">
								<?php dimita_top_menu(); ?>
							</div>
							<div class=" header-search-form">
								<div class="content-main">
									<div class="header-menu-bg hidden-sm hidden-xs">
										<!-- Begin Search -->
										<?php if($show_searchform && class_exists( 'WooCommerce' )){ ?>
											<?php get_template_part( 'search-form' ); ?>
										<?php } ?>
										<!-- End Search -->
									</div>
								</div>
								<div class="hidden-lg hidden-md pull-right">
									<?php dimita_navbar_vertical_menu(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php }else{ ?>
					<div class="header-default">
						<div class="container">
							<div class="row">
								<div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6 header-logo">
									<?php dimita_header_logo(); ?>
								</div>
								<div class="col-xl-10 col-lg-9 col-6 wpbingo-menu-mobile header-main">
									<div class="content-header">
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