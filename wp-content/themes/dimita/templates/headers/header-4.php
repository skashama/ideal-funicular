	<?php 
		$dimita_settings = dimita_global_settings();
		$enable_sticky_header = ( isset($dimita_settings['enable-sticky-header']) && $dimita_settings['enable-sticky-header'] ) ? ($dimita_settings['enable-sticky-header']) : false;
		$show_minicart = (isset($dimita_settings['show-minicart']) && $dimita_settings['show-minicart']) ? ($dimita_settings['show-minicart']) : false;
		$show_searchform = (isset($dimita_settings['show-searchform']) && $dimita_settings['show-searchform']) ? ($dimita_settings['show-searchform']) : false;		
		$show_wishlist = (isset($dimita_settings['show-wishlist']) && $dimita_settings['show-wishlist']) ? ($dimita_settings['show-wishlist']) : false;
	?>
	<h1 class="bwp-title hide"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	<header id="bwp-header" class="bwp-header header-v4">
		<div class='header-wrapper'>
			<div class="header-top">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-5 header-left">
						<?php dimita_header_logo(); ?>
					</div>
					<?php if($show_minicart || $show_searchform || (is_active_sidebar('top-link')) ){ ?>
					<div class="col-lg-6 col-md-6 col-sm-6 col-7 header-page-link">
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
						<?php if($show_minicart && class_exists( 'WooCommerce' )){ ?>
						<div class="wpbingoCartTop">
							<?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
						</div>
						<?php } ?>
						<div class="header-content sticky-sidebar">
							<div class="active-menu">
								<span class="line-1"></span>
								<span class="line-2"></span>
								<span class="line-3"></span>
							</div>
							<div class="header-main">
								<div class="active-menu"></div>
								<div class="wpbingo-menu-mobile wpbingo-menu-sidebar">
									<?php dimita_top_menu(); ?>
								</div>
							</div>
						</div>
					</div>
					<?php }else{ ?>
						<div class="col-lg-6 col-md-6 col-sm-6 col-7 header-page-link">
							<div class="header-content sticky-sidebar">
								<div class="active-menu">
									<span class="line-1"></span>
									<span class="line-2"></span>
									<span class="line-3"></span>
								</div>
								<div class="header-main">
									<div class="active-menu"></div>
									<div class="wpbingo-menu-mobile wpbingo-menu-sidebar">
										<?php dimita_top_menu(); ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</header><!-- End #bwp-header -->