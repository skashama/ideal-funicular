<?php 
if ( !class_exists('Woocommerce') ) { 
	return false;
}
global $woocommerce; ?>
<div id="cart" class="dropdown mini-cart top-cart">
	<a class="dropdown-toggle cart-icon" data-toggle="dropdown" data-hover="dropdown" data-delay="0" href="#" title="<?php esc_attr_e('View your shopping cart', 'dimita'); ?>">
		<div class="icon-cart"><i class="icon_cart_alt"></i><span class="cart-count"><?php echo esc_attr($woocommerce->cart->cart_contents_count); ?></span></div>
		<div class="cart-content">
		<span class="mini-cart-items"><span class="items-class"> <?php echo esc_html__('My Cart','dimita') ?> </span></span>
		<span class="text-price-cart"><?php echo wp_kses($woocommerce->cart->get_cart_total(),'social'); ?></span>
		</div>
    </a>
	<div class="cart-popup">
		<?php woocommerce_mini_cart(); ?>
	</div>
</div>