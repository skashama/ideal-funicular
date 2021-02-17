<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header();
do_action( 'woocommerce_before_main_content' );
$category_style  		= dimita_get_config('category_style','sidebar');
$shop_background	 	= dimita_get_config('shop_background',false);
$current_category 		= get_queried_object();
$subcategories_style 	= dimita_get_config('style-subcategories','image_categories');
$show_subcategories 	= dimita_get_config('show-subcategories',false);
$sub_col_large 			= dimita_get_config('sub_col_large',6);
$sub_col_medium 		= dimita_get_config('sub_col_medium',4);
$sub_col_sm 			= dimita_get_config('sub_col_sm',3);
$id_category 			= (isset($current_category->term_id) && $current_category->term_id) ? $current_category->term_id : 0;
$show_bestseller	 			= dimita_get_config('show-bestseller-category',false);
$show_banner	= dimita_get_config('show-banner-category',false);
?>
<div class="<?php echo esc_attr($category_style); ?><?php if($shop_background) { ?> shop_background<?php } ?>">
	<div class="container">
		<div class="main-archive-product row">
			<?php if(( ($category_style == 'sidebar') || ($category_style == 'filter_drawer') ) && is_active_sidebar('sidebar-product')): ?>	
				<div class="bwp-sidebar sidebar-product <?php echo esc_attr(dimita_get_class()->class_sidebar_left); ?>">
					<?php if($category_style == 'filter_drawer'): ?>
						<div class="button-filter-toggle hidden-lg hidden-md">
							<?php echo esc_html__("Hide Filter","dimita") ?>
						</div>
					<?php endif; ?>
					<?php if ( ( class_exists("WCV_Vendors") && WCV_Vendors::is_vendor_page() ) || is_tax('dc_vendor_shop') ) { ?>
						<?php dynamic_sidebar( 'sidebar-vendor' ); ?>
					<?php }else{ ?>	
						<?php dynamic_sidebar( 'sidebar-product' ); ?>
					<?php } ?>
				</div>				
			<?php endif; ?>
			<div class="<?php echo esc_attr(dimita_get_class()->class_product_content); ?>" >
				<?php do_action( 'woocommerce_archive_description' ); ?>
				<?php if ( have_posts() ) : ?>
					<div class="bwp-top-bar top clearfix">				
						<?php dimita_category_top_bar(); ?>							
					</div>
					<?php if($category_style != 'sidebar' && $category_style != 'filter_drawer' && is_active_sidebar('filter-product')): ?>
						<div class="bwp-sidebar sidebar-product-filter full">
							<?php if($category_style == 'filter_offcanvas'): ?>
								<div class="button-filter-toggle">
									<?php echo esc_html__("Hide Filter","dimita") ?>
								</div>
							<?php endif; ?>
							<?php dynamic_sidebar( 'filter-product' ); ?>
						</div>
					<?php endif; ?>
					<div class="content-products-list">
						<?php
							wc_get_template(
								'archive-product-banner.php',
								array(
									'id_category' => $id_category,
									'show_banner' => $show_banner
								)
							);
						?>
						<?php
							wc_get_template(
								'archive-product-bestseller.php',
								array(
									'id_category' 		=> $id_category,
									'show_bestseller'	=> $show_bestseller
								)
							);
						?>
						<?php woocommerce_product_loop_start(); ?>
							<?php while ( have_posts() ) : the_post(); ?>
								<?php wc_get_template_part( 'content', 'product' ); ?>
							<?php endwhile;  ?>
						<?php woocommerce_product_loop_end(); ?>
					</div>
					<div class="bwp-top-bar bottom clearfix">
						<?php do_action('woocommerce_after_shop_loop'); ?>
					</div>
				<?php else : ?>
					<?php wc_get_template( 'loop/no-products-found.php' ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>	
</div>
<?php
do_action( 'woocommerce_after_main_content' );
get_footer( 'shop' );
?>