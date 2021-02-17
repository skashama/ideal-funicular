<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.7.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php 
if ( !class_exists('Woocommerce') ) { 
	return false;
}
global $woocommerce; ?>
<?php do_action( 'woocommerce_before_mini_cart' ); ?>
<div class="cart-icon-big"></div>
<ul class="cart_list product_list_widget <?php echo esc_attr($args['list_class']); ?>">
	<?php if ( ! WC()->cart->is_empty() ) : ?>
		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					?>
					<li class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
						<?php
						echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
							'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s"><i class="fa fa-trash-o"></i></a>',
							esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
							esc_html__( 'Remove this item', 'dimita' ),
							esc_attr( $product_id ),
							esc_attr( $_product->get_sku() )
						), $cart_item_key );
						?>
						<?php if ( ! $_product->is_visible() ) : ?>
							<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail );?>
						<?php else : ?>
							<a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>" class="product-image">
								<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
							</a>
						<?php endif; ?>
						<a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>" class="product-name">
							<?php echo esc_html($product_name); ?>
						</a>		
						<?php
						$rating_count = $_product->get_rating_count();
						$review_count = $_product->get_review_count();
						$average      = $_product->get_average_rating();
						if ( $rating_count > 0 ) : ?>
							<div class="woocommerce-product-rating" itemscope itemtype="http://schema.org/AggregateRating">
								<div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'dimita' ), $average ); ?>">
									<span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
										<strong class="rating"><?php echo esc_html( $average ); ?></strong> <?php printf( __( 'out of ', 'dimita' ), '<span>', '</span>' ); ?>
										<?php printf( _n( 'based on %s customer rating', 'based on %s customer ratings', $rating_count, 'dimita' ), '<span class="rating">' . $rating_count . '</span>' ); ?>
									</span>
								</div>
							</div>
						<?php endif; ?>						
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
						<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<div class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</div>', $cart_item, $cart_item_key ); ?>
						</li>
					<?php
				}
			}
		?>
	<?php else : ?>
		<li class="empty"><?php esc_html_e( 'No products in the cart.', 'dimita' ); ?></li>
	<?php endif; ?>
</ul><!-- end product list -->
<?php if ( ! WC()->cart->is_empty() ) : ?>
	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
	<div class="total-cart"><div class="title-total"><?php esc_html_e( 'Total: ', 'dimita' ); ?></div><div class="total-price"><?php echo wp_kses($woocommerce->cart->get_cart_total(),'social'); ?></div></div>
<?php endif; ?>
<?php if ( ! WC()->cart->is_empty() ) : ?>
	<div class="buttons">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="button btn view-cart btn-primary"><?php esc_html_e( 'View cart', 'dimita' ); ?></a>
		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="button btn checkout btn-default"><?php esc_html_e( 'Check out', 'dimita' ); ?></a>
	</div>
<?php endif; ?>
<?php do_action( 'woocommerce_after_mini_cart' ); ?>