<?php
add_action( 'init', 'dimita_button_product' );
add_action( 'init', 'dimita_woocommerce_single_product_summary' );
add_filter( 'dimita_custom_category', 'woocommerce_maybe_show_product_subcategories' );
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display');
function dimita_button_product(){
	$dimita_settings = dimita_global_settings();
	//Button List Product
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	//Cart
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
		add_action('woocommerce_after_shop_loop_item', 'dimita_woocommerce_template_loop_add_to_cart', 15 );
	//Whishlist
	if(isset($dimita_settings['product-wishlist']) && $dimita_settings['product-wishlist'] && class_exists( 'YITH_WCWL' ) ){
		add_action('woocommerce_after_shop_loop_item', 'dimita_add_loop_wishlist_link', 20 );	
	}
	//Compare
	if(isset($dimita_settings['product-compare']) && $dimita_settings['product-compare'] && class_exists( 'YITH_WOOCOMPARE' ) ){
		add_action('woocommerce_after_shop_loop_item', 'dimita_add_loop_compare_link', 15 );
	}	
	//Quickview
		add_action('woocommerce_after_shop_loop_item', 'dimita_quickview', 35 );
	/* Remove sold by in product loops */
	if(class_exists("WCV_Vendors")){
		remove_action( 'woocommerce_after_shop_loop_item', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9, 2);
		add_action('woocommerce_after_shop_loop_item_title', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 5 );
	}
}
function dimita_woocommerce_single_product_summary(){
	global $product;
	$product_stock = dimita_get_config('product-stock',true);
	$show_brands = dimita_get_config('show-brands',true);
	$show_offer = dimita_get_config('show-offer',true);
	$show_countdown = dimita_get_config('show-countdown',true);
	$show_trust_bages = dimita_get_config('show-trust-bages',true);
	$show_sticky_cart = dimita_get_config('show-sticky-cart',true);
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash');	
	add_action( 'woocommerce_after_add_to_cart_button', 'dimita_add_loop_wishlist_link', 30 );
	add_action( 'woocommerce_after_add_to_cart_button', 'dimita_add_loop_compare_link', 35 );
	add_action( 'woocommerce_single_product_summary', 'dimita_add_social', 45 );
	if($product_stock){
		add_action( 'woocommerce_single_product_summary', 'dimita_label_stock', 15 );
	}
	if($show_brands){
		add_action( 'woocommerce_single_product_summary', 'dimita_get_brans', 10 );
	}
	if($show_offer){
		add_action( 'woocommerce_single_product_summary', 'dimita_get_offer', 20 );
	}
	if($show_countdown){
		add_action( 'woocommerce_single_product_summary', 'dimita_get_countdown', 20 );
	}
	if($show_trust_bages){
		add_action( 'woocommerce_single_product_summary', 'dimita_trust_bages', 50 );
	}
	if($show_sticky_cart){
		add_action( 'woocommerce_after_single_product', 'dimita_sticky_cart', 50 );
	}
}
if( defined( 'YITH_WCWL' ) && ! function_exists( 'dimita_yith_wcwl_ajax_update_count' ) ){
	function dimita_yith_wcwl_ajax_update_count(){
		wp_send_json( array(
		'count' => yith_wcwl_count_all_products()
		));
	}
	add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', 'dimita_yith_wcwl_ajax_update_count' );
	add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'dimita_yith_wcwl_ajax_update_count' );
}
function dimita_update_total_price() {
	global $woocommerce;
	check_ajax_referer( 'dimita_ajax_nonce', 'security' );
	$data = array(
		'total_price' => $woocommerce->cart->get_cart_total(),
	);
	wp_send_json($data);
}	
add_action( 'wp_ajax_dimita_update_total_price', 'dimita_update_total_price' );
add_action( 'wp_ajax_nopriv_dimita_update_total_price', 'dimita_update_total_price' );	
/* Ajax Search */
add_action( 'wp_ajax_dimita_search_products_ajax', 'dimita_search_products_ajax' );
add_action( 'wp_ajax_nopriv_dimita_search_products_ajax', 'dimita_search_products_ajax' );
function dimita_search_products_ajax(){
	$character = (isset($_GET['character']) && $_GET['character'] ) ? $_GET['character'] : '';
	$limit = (isset($_GET['limit']) && $_GET['limit'] ) ? $_GET['limit'] : 5;
	$category = (isset($_GET['category']) && $_GET['category'] ) ? $_GET['category'] : "";
	$args = array(
		'post_type' 			=> 'product',
		'post_status'    		=> 'publish',
		'ignore_sticky_posts'   => 1,	  
		's' 					=> $character,
		'posts_per_page'		=> $limit
	);
	
	if($category){
		$args['tax_query'] = array(
			array(
				'taxonomy'  => 'product_cat',
				'field'     => 'slug',
				'terms'     => $category ));
	}
	$list = new WP_Query( $args );
	$json = array();
	if ($list->have_posts()) {
		while($list->have_posts()): $list->the_post();
		global $product, $post;
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->id ), 'shop_catalog' );
		$json[] = array(
			'product_id' => $product->id,
			'name'       => $product->get_title(),		
			'image'		 =>  $image[0],
			'link'		 =>  get_permalink( $product->id ),
			'price'      =>  $product->get_price_html(),
		);			
		endwhile;
	}
	die (json_encode($json));
}
function dimita_label_stock(){
	global $product; 
	$stock = ( $product->is_in_stock() )? 'in-stock' : 'out-stock' ; ?>
	<div class="product-stock <?php echo esc_attr( $stock ); ?>">    
		<span><?php esc_html_e( 'Availability:', 'dimita' ); ?></span>
		<i class="fa fa-check-square-o"></i><span class="stock"><?php  if( $product->is_in_stock() ){ echo esc_html__( 'In Stock', 'dimita' ); }else{ echo esc_html__( 'Out stock', 'dimita' ); } ?></span>
	</div>
<?php } 
function dimita_get_brans(){
	global $product;
	$terms = get_the_terms( $product->get_id() , 'product_brand' ); ?>
	<?php if($terms): ?>
	<div class="brands-single">
		<h2 class="title-brand"><?php echo esc_html__("Brand:","dimita") ?></h2>
		<ul class="product-brand">
			<?php 
			foreach( $terms as $term ) {
				if( $term && is_object($term) ) :
				$thumb 	= ( get_term_meta( $term->term_id, 'thumbnail_bid', true ) );
				$thubnail = !empty($thumb) ? $thumb : "http://placehold.it/200x200"; ?>
				<li class="item-brand">
					<?php echo '<a href="'. get_term_link( $term->term_id, 'product_brand' ).'"><img src="'.esc_url($thubnail).'" alt="'.esc_attr($term->name).'"></a>'; ?>
				</li>
				<?php endif; ?>
			<?php } ?>
		</ul>
	</div>
	<?php endif; ?>
<?php }
function dimita_get_offer(){
	global $product;
	$offer  = (get_post_meta( $product->get_id(), 'offer_product', true )) ? get_post_meta($product->get_id(), 'offer_product', true ) : "";
	if ( $offer ):?>
		<div class="offer-product">
			<?php echo wp_kses($offer,'social'); ?>
		</div>
	<?php endif; ?>
<?php }
function dimita_get_countdown(){
	global $product;
	$start_time = get_post_meta( $product->get_id(), '_sale_price_dates_from', true );
	$countdown_time = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
	$orginal_price = get_post_meta( $product->get_id(), '_regular_price', true );	
	$sale_price = get_post_meta( $product->get_id(), '_sale_price', true );	
	$symboy = get_woocommerce_currency_symbol( get_woocommerce_currency() );
	if ( $countdown_time ):
		$date = bwp_timezone_offset( $countdown_time ); ?>
		<div class="countdown-single">
			<h2 class="title-countdown"><?php echo esc_html__("Hungry up ! Deal end in :","dimita") ?></h2>
			<div class="product-countdown"  data-day="<?php echo esc_attr__("Days","dimita"); ?>" data-hour="<?php echo esc_attr__("Hours","dimita"); ?>" data-min="<?php echo esc_attr__("Mins","dimita"); ?>" data-sec="<?php echo esc_attr__("Secs","dimita"); ?>" data-date="<?php echo esc_attr( $date ); ?>" data-price="<?php echo esc_attr( $symboy.$orginal_price ); ?>" data-sttime="<?php echo esc_attr( $start_time ); ?>" data-cdtime="<?php echo esc_attr( $countdown_time ); ?>" data-id="<?php echo esc_attr('product_'.$product->get_id()); ?>"></div>
		</div>
	<?php endif; ?>
<?php }
function dimita_trust_bages(){
	$dimita_settings = dimita_global_settings();
	if(isset($dimita_settings['trust-bages']['url']) && !empty($dimita_settings['trust-bages']['url'])):?>
		<div class="payment-product">
			<h2><?php echo esc_html__("Guaranteed Safe Checkout","dimita") ?></h2>
			<img src="<?php echo esc_url($dimita_settings['trust-bages']['url']); ?>" alt="<?php echo esc_attr__( 'Trust Bages','dimita' ); ?>">
		</div>
	<?php endif; ?>
<?php }
function dimita_sticky_cart(){
	global $product; ?>
	<div class="sticky-product">
		<div class="content">
			<div class="content-product">
				<div class="item-thumb">
					<a href="<?php echo get_permalink( $product->get_id() ); ?>"><img src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>" /></a>
				</div>
				<div class="content-bottom">
					<div class="item-title">
						<a href="<?php echo esc_url(get_permalink( $product->get_id() )); ?>"><?php echo esc_html($product->get_title()); ?></a>
					</div>
					<div class="price">
						<?php echo wp_kses($product->get_price_html(),'social'); ?>
					</div>
					<?php if ( $rating_html = wc_get_rating_html( $product->get_average_rating() ) ) { ?>
						<div class="rating">
							<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
							<div class="review-count">
								( <?php echo esc_attr($product->get_review_count());?><?php echo esc_html__(' review','dimita');?> )
							</div>
						</div>
					<?php }else{ ?>
						<div class="rating none">
							<div class="star-rating none"></div>
							<div class="review-count">
								( 0 <?php echo esc_html__(' reviews','dimita');?> )
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="content-cart">
				<form class="cart" method="post" enctype='multipart/form-data'>
					<div class="quantity-button">
						<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
						<?php
							if ( ! $product->is_sold_individually() ) {
								woocommerce_quantity_input( array(
									'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
									'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product ),
									'input_value' => ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 )
								) );
							}
						?>
						<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
						<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php }
function dimita_woocommerce_template_loop_add_to_cart( $args = array() ) {
	global $product;
	if ( $product ) {
		$defaults = array(
			'quantity' => 1,
			'class'    => implode( ' ', array_filter( array(
					'button',
					'product_type_' . $product->get_type(),
					$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : 'read_more',
					$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
			) ) ),
		);
		$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );
		wc_get_template( 'loop/add-to-cart.php', $args );
	}
}	
function dimita_add_excerpt_in_product_archives() {
	global $post;
	if ( ! $post->post_excerpt ) return;		
	echo '<div class="item-description item-description2">'.wp_trim_words( $post->post_excerpt, 25 ).'</div>';
}	
/*add second thumbnail loop product*/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'dimita_woocommerce_template_loop_product_thumbnail', 10 );
function dimita_product_thumbnail( $size = 'woocommerce_thumbnail', $placeholder_width = 0, $placeholder_height = 0  ) {
	global $dimita_settings,$product;
	$html = '';
	$id = get_the_ID();
	$gallery = get_post_meta($id, '_product_image_gallery', true);
	$attachment_image = '';
	if(!empty($gallery)) {
		$gallery = explode(',', $gallery);
		$first_image_id = $gallery[0];
		$attachment_image = wp_get_attachment_image($first_image_id , $size, false, array('class' => 'hover-image back'));
	}
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), '' );
		if ( has_post_thumbnail() ){
			if( $attachment_image && $dimita_settings['category-image-hover']){
				$html .= '<div class="product-thumb-hover">';
				$html .= '<a href="' . get_the_permalink() . '" class="woocommerce-LoopProduct-link">';
				$html .= (get_the_post_thumbnail( $product->get_id(), $size )) ? get_the_post_thumbnail( $product->get_id(), $size ): '<img src="'.get_template_directory_uri().'/images/placeholder.jpg" alt="'. esc_attr__('No thumb', 'dimita').'">';
				if($dimita_settings['category-image-hover']){
					$html .= $attachment_image;
				}
				$html .= '</a>';
				$html .= '</div>';				
			}else{
				$html .= '<a href="' . get_the_permalink() . '" class="woocommerce-LoopProduct-link">';		
				$html .= (get_the_post_thumbnail( $product->get_id(), $size )) ? get_the_post_thumbnail( $product->get_id(), $size ): '<img src="'.get_template_directory_uri().'/images/placeholder.jpg" alt="'. esc_attr__('No thumb', 'dimita').'">';
				$html .= '</a>';
			}		
		}else{
			$html .= '<a href="' . get_the_permalink() . '" class="woocommerce-LoopProduct-link">';		
			$html .= '<img src="'.get_template_directory_uri().'/images/placeholder.jpg" alt="'. esc_attr__('No thumb', 'dimita').'">';
			$html .= '</a>';	
		}
	/* quickview */
	return $html;
}
function dimita_woocommerce_template_loop_product_thumbnail(){
	echo dimita_product_thumbnail();
}
function dimita_countdown_woocommerce_template_loop_product_thumbnail(){
	echo dimita_product_thumbnail("shop_single");
}
//Button List Product
/*********QUICK VIEW PRODUCT**********/
function dimita_product_quick_view_scripts() {	
	wp_enqueue_script('wc-add-to-cart-variation');
}
add_action( 'wp_enqueue_scripts', 'dimita_product_quick_view_scripts' );	
function dimita_quickview(){
	global $product;
	$quickview = dimita_get_config('product_quickview'); 
	if( $quickview ) : 
		echo '<span class="product-quickview"><a href="#" data-product_id="'.esc_attr($product->get_id()).'" class="quickview quickview-button quickview-'.esc_attr($product->get_id()).'" >'.apply_filters( 'out_of_stock_add_to_cart_text', 'Quick View' ).' <i class="pe-7s-search"></i>'.'</a></span>';
	endif;
}
add_action("wp_ajax_dimita_quickviewproduct", "dimita_quickviewproduct");
add_action("wp_ajax_nopriv_dimita_quickviewproduct", "dimita_quickviewproduct");
function dimita_quickviewproduct(){
	check_ajax_referer( 'dimita_ajax_nonce', 'security' );
	echo dimita_content_product();exit();
}
function dimita_content_product(){
	$productid = (isset($_REQUEST["product_id"]) && $_REQUEST["product_id"]>0) ? $_REQUEST["product_id"] : 0;
	$query_args = array(
		'post_type'	=> 'product',
		'p'			=> $productid
	);
	$outputraw = $output = '';
	$r = new WP_Query($query_args);
	if($r->have_posts()){ 
		while ($r->have_posts()){ $r->the_post(); setup_postdata($r->post);
			ob_start();
			wc_get_template_part( 'content', 'quickview-product' );
			$outputraw = ob_get_contents();
			ob_end_clean();
		}
	}
	$output = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $outputraw);
	return $output;	
}
//Wish list
function dimita_add_loop_wishlist_link(){	
	if ( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
		echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
	}
}
//Compare
function dimita_add_loop_compare_link(){
	global $post;
	$product_id = $post->ID;	
	if( class_exists( 'YITH_WOOCOMPARE' ) ){
		echo '<div class="woocommerce product compare-button"><a href="javascript:void(0)" class="compare button" data-product_id="'. esc_attr($product_id) .'" rel="nofollow">'.esc_html__("Compare","dimita").'</a></div>';	
	}	
}
function dimita_add_social() {
	if ( shortcode_exists( 'social_share' ) ) :
		echo '<div class="social-icon">';
			echo '<div class="social-title">' . esc_html__( 'Share:', 'dimita' ) . '</div>';
			echo do_action( 'woocommerce_share' );
			echo do_shortcode( "[social_share]" );
		echo '</div>';
	endif;	
}
function dimita_add_thumb_single_product() {
	echo '<div class="image-thumbnail-list">';
	do_action( 'woocommerce_product_thumbnails' );
	echo '</div>';
}
function dimita_get_class_item_product(){
	$dimita_settings = dimita_global_settings();
	$product_col_large = 12 /(dimita_get_config('product_col_large',4));	
	$product_col_medium = 12 /(dimita_get_config('product_col_medium',3));
	$product_col_sm 	= 12 /(dimita_get_config('product_col_sm',1));
	$class_item_product = 'col-lg-'.$product_col_large.' col-md-'.$product_col_medium.' col-sm-'.$product_col_sm;
	return $class_item_product;
}
function dimita_catalog_perpage(){
	$dimita_settings = dimita_global_settings();
	$query_string = dimita_get_query_string();
	parse_str($query_string, $params);
	$query_string 	= '?'.$query_string;
	$per_page 	=   (isset($dimita_settings['product_count']) && $dimita_settings['product_count'])  ? (int)$dimita_settings['product_count'] : 12;
	$product_count = (isset($params['product_count']) && $params['product_count']) ? ($params['product_count']) : $per_page;
	?>
	<div class="dimita-woocommerce-sort-count">
		<div class="woocommerce-sort-count">
			<span><?php echo esc_html__('Show','dimita'); ?></span>
			<ul class="pwb-dropdown-menu">
				<li data-value="<?php echo esc_attr($per_page); 	?>"<?php if ($product_count == $per_page){?>class="active"<?php } ?>><a href="<?php echo dimita_add_url_parameter($query_string, 'product_count', $per_page); ?>"><?php echo esc_attr($per_page); ?></a></li>
				<li data-value="<?php echo esc_attr($per_page*2); 	?>"<?php if ($product_count == $per_page*2){?>class="active"<?php } ?>><a href="<?php echo dimita_add_url_parameter($query_string, 'product_count', $per_page*2); ?>"><?php echo esc_attr($per_page*2); ?></a></li>
				<li data-value="<?php echo esc_attr($per_page*3); 	?>"<?php if ($product_count == $per_page*3){?>class="active"<?php } ?>><a href="<?php echo dimita_add_url_parameter($query_string, 'product_count', $per_page*3); ?>"><?php echo esc_attr($per_page*3); ?></a></li>
			</ul>
		</div>
	</div>
<?php }	
add_filter('loop_shop_per_page', 'dimita_loop_shop_per_page');
function dimita_loop_shop_per_page() {
	$dimita_settings = dimita_global_settings();
	$query_string = dimita_get_query_string();
	parse_str($query_string, $params);
	$per_page 	=   (isset($dimita_settings['product_count']) && $dimita_settings['product_count'])  ? (int)$dimita_settings['product_count'] : 12;
	$product_count = (isset($params['product_count']) && $params['product_count']) ? ($params['product_count']) : $per_page;
	return $product_count;
}	
function dimita_found_posts(){
	wc_get_template( 'loop/woocommerce-found-posts.php' );
}	
remove_action('woocommerce_before_main_content', 'dimita_woocommerce_breadcrumb', 20);	
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
function dimita_search_form_product(){
	$query_string = dimita_get_query_string();
	parse_str($query_string, $params);
	$category_slug = isset( $params['product_cat'] ) ? $params['product_cat'] : '';
	$terms =	get_terms( 'product_cat', 
	array(  
		'hide_empty' => true,	
		'parent' => 0	
	));
	$class_ajax_search 	= "";	 
	$ajax_search 		= dimita_get_config('show-ajax-search',false);
	$limit_ajax_search 		= dimita_get_config('limit-ajax-search',5);
	if($ajax_search){
		$class_ajax_search = "ajax-search";
	}
	?>
	<form role="search" method="get" class="search-from <?php echo esc_attr($class_ajax_search); ?>" action="<?php echo esc_url(home_url( '/' )); ?>" data-admin="<?php echo admin_url( 'admin-ajax.php', 'dimita' ); ?>" data-noresult="<?php echo esc_html__("No Result","dimita") ; ?>" data-limit="<?php echo esc_attr($limit_ajax_search); ?>">
		<?php if($terms && is_object($terms)){ ?>
		<div class="select_category pwb-dropdown dropdown">
			<span class="pwb-dropdown-toggle dropdown-toggle" data-toggle="dropdown"><?php echo esc_html__("Category","dimita"); ?></span>
			<span class="caret"></span>
			<ul class="pwb-dropdown-menu dropdown-menu category-search">
			<li data-value="" class="<?php  echo (empty($category_slug) ?  esc_attr("active") : ""); ?>"><?php echo esc_html__("Browse Category","dimita"); ?></li>
				<?php foreach($terms as $term){ ?>
					<?php if( $term && is_object($term) ): ?>
						<li data-value="<?php echo esc_attr($term->slug); ?>" class="<?php  echo (($term->slug == $category_slug) ?  esc_attr("active") : ""); ?>"><?php echo esc_html($term->name); ?></li>
						<?php
							$terms_vl1 =	get_terms( 'product_cat', 
							array( 
									'parent' => '', 
									'hide_empty' => false,
									'parent' 		=> $term->term_id, 
							));						
						?>
						<?php if( $terms_vl1 && is_object($terms_vl1) ): ?>
							<?php foreach ($terms_vl1 as $term_vl1) { ?>
								<?php if( $term_vl1 && is_object($term_vl1) ): ?>
									<li data-value="<?php echo esc_attr($term_vl1->slug); ?>" class="<?php  echo (($term_vl1->slug == $category_slug) ?  esc_attr("active") : ""); ?>"><?php echo esc_html($term_vl1->name); ?></li>
									<?php
										$terms_vl2 =	get_terms( 'product_cat', 
										array( 
												'parent' => '', 
												'hide_empty' => false,
												'parent' 		=> $term_vl1->term_id, 
									));	?>
									<?php if( $terms_vl2 && is_object($terms_vl2) ): ?>	
										<?php foreach ($terms_vl2 as $term_vl2) { ?>
											<?php if( $term_vl1 && is_object($term_vl1) ): ?>
											<li data-value="<?php echo esc_attr($term_vl2->slug); ?>" class="<?php  echo (($term_vl2->slug == $category_slug) ?  esc_attr("active") : ""); ?>"><?php echo esc_html($term_vl2->name); ?></li>
											<?php endif; ?>
										<?php } ?>
									<?php endif; ?>
								<?php endif; ?>
							<?php } ?>
						<?php endif; ?>
					<?php endif; ?>
				<?php } ?>
			</ul>	
			<input type="hidden" name="product_cat" class="product-cat" value="<?php echo esc_attr($category_slug); ?>"/>
		</div>	
		<?php } ?>	
		<div class="search-box">
			<button id="searchsubmit" class="btn" type="submit">
				<i class="icon_search"></i>
				<span><?php echo esc_html__('search','dimita'); ?></span>
			</button>
			<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" class="input-search s" placeholder="<?php echo esc_attr__( 'Search', 'dimita' ); ?>" />
			<ul class="result-search-products">
			</ul>
		</div>
		<input type="hidden" name="post_type" value="product" />
	</form>
<?php }
function dimita_top_cart(){
	global $woocommerce; ?>
	<div id="cart" class="top-cart">
		<a class="cart-icon" href="<?php echo get_permalink( wc_get_page_id( 'cart' ) ); ?>" title="<?php esc_attr_e('View your shopping cart', 'dimita'); ?>">
			<i class="flaticon-bag"></i>
		</a>
	</div>
<?php }
function dimita_button_filter(){
	$html = '<a class="button-filter-toggle">'.esc_html__( 'Filter', 'dimita' ).'</a>';
	echo wp_kses_post($html);
}	
function dimita_image_single_product(){
	$dimita_settings = dimita_global_settings();
	$class = new stdClass;
	$class->show_thumb = dimita_get_config('product-thumbs',false);
	$position = dimita_get_config('position-thumbs',"bottom");
	$class->position = $position;
	if($class->show_thumb && $position == "outsite"){
		add_action( 'woocommerce_single_product_summary', 'dimita_add_thumb_single_product', 40 );
	}	
	if($position == 'left' || $position == "right"){
		$class->class_thumb = "col-sm-2";
		$class->class_data_image = 'data-vertical="true" data-verticalswiping="true"';
		$class->class_image = "col-sm-10";
	}else{
		$class->class_thumb = $class->class_image = "col-sm-12";
		$class->class_data_image = "";
	}
	if(isset($dimita_settings['product-thumbs-count']) && $dimita_settings['product-thumbs-count'])
		$product_count_thumb = 	$dimita_settings['product-thumbs-count'];
	else
		$product_count_thumb = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
	$product_count_thumb = get_post_meta( get_the_ID(), 'product_count_thumb', true ) ? get_post_meta( get_the_ID(), 'product_count_thumb', true ) : $product_count_thumb;
	$class->product_count_thumb =	$product_count_thumb;
	$product_layout_thumb = dimita_get_config("layout-thumbs","zoom");
	$class->product_layout_thumb =	$product_layout_thumb;	
	return $class;
}
function dimita_category_top_bar(){
	$sidebar_product = dimita_category_sidebar();
	add_action('woocommerce_before_shop_loop','woocommerce_result_count',20); 
	add_action('woocommerce_before_shop_loop','dimita_display_view', 40);
	remove_action('woocommerce_before_shop_loop','dimita_found_posts', 20);
	add_action('woocommerce_before_shop_loop','woocommerce_catalog_ordering', 30);
	add_action('woocommerce_before_shop_loop','dimita_catalog_perpage', 35);
	$category_style  = dimita_get_config('category_style','sidebar');
	if($category_style != 'sidebar' && $category_style != 'filter_dropdown'){
		add_action('woocommerce_before_shop_loop','dimita_button_filter', 25);
	}	
	do_action( 'woocommerce_before_shop_loop' );
}
function dimita_get_product_discount(){
	global $product;
	$discount = 0;
	if ($product->is_on_sale() && $product->is_type( 'variable' )){
		$available_variations = $product->get_available_variations();
		for ($i = 0; $i < count($available_variations); ++$i) {
			$variation_id=$available_variations[$i]['variation_id'];
			$variable_product1= new WC_Product_Variation( $variation_id );
			$regular_price = $variable_product1->get_regular_price();
			$sales_price = $variable_product1->get_sale_price();
			if(is_numeric($regular_price) && is_numeric($sales_price)){
				$percentage = round( (( $regular_price - $sales_price ) / $regular_price ) * 100 ) ;
				if ($percentage > $discount) {
					$discount = $percentage;
				}
			}
		}
	}elseif($product->is_on_sale() && $product->is_type( 'simple' )){
		$regular_price	= $product->get_regular_price();
		$sales_price	= $product->get_sale_price();
		if(is_numeric($regular_price) && is_numeric($sales_price)){
			$discount = round( ( ( $regular_price - $sales_price ) / $regular_price ) * 100 );
		}
	}
	if( $discount > 0 ){
		$text_discount = "-".$discount.'%';
	}else{
		$text_discount = '';
	}
	return 	$text_discount;
}	
function dimita_category_bottom(){
	remove_action('woocommerce_after_shop_loop','woocommerce_result_count', 20);
	do_action( 'woocommerce_after_shop_loop' );
}
add_action( 'woocommerce_before_quantity_input_field', 'dimita_display_quantity_plus' );
function dimita_display_quantity_plus() {
   $html = '<button type="button" class="plus" >+</button>';
   echo wp_kses($html,'social');
}
add_action( 'woocommerce_after_quantity_input_field', 'dimita_display_quantity_minus' );
function dimita_display_quantity_minus() {
	$html = '<button type="button" class="minus" >-</button>';
	echo wp_kses($html,'social');
}

function dimita_woocommerce_output_product_categories( ){
	$product_categories = get_terms( 'product_cat', array('hide_empty' => true) );
	if ( ! $product_categories ) {
		return false;
	}
	foreach ( $product_categories as $category ) {
		wc_get_template(
			'content-only-product_cat.php',
			array(
				'category' => $category,
			)
		);
	}
	return true;
}
function dimita_get_video_product(){
	global $product;
	$video  = (get_post_meta( $product->get_id(), 'video_product', true )) ? get_post_meta($product->get_id(), 'video_product', true ) : "";
	if($video){ ?>
		<div class="dimita-product-button "><div class="dimita-bt-video"><a class="bwp-video" href="<?php echo esc_url($video); ?>"><?php echo esc_html__( 'Play video', 'dimita' ); ?></a></div></div>
	<?php }
}
function dimita_view_product(){
	global $product;
	$view  = (get_post_meta( $product->get_id(), 'view_product', true )) ? get_post_meta($product->get_id(), 'view_product', true ) : "";
	if($view == 'true'){ $j=0; ?>
	<?php $attachment_ids = $product->get_gallery_image_ids(); ?>
	<div class="dimita-360-button"><i class="icon-arrow"></i><?php echo esc_html__("360 product view","dimita") ?></div>
	<div class="content-product-360-view">
		<div class="product-360-view" data-count="<?php echo esc_attr(count($attachment_ids)-1); ?>">
			<div class="dimita-360-button"><i class="icon_close"></i></div>
			<div class="images-display">
				<ul class="images-list">
				<?php
					foreach ( $attachment_ids as $attachment_id ) {		
						$image_link = wp_get_attachment_url( $attachment_id );
						if ( ! $image_link )
							continue;
						$image_title 	= esc_attr( get_the_title( $attachment_id ) );
						$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );
						$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' ), 0, $attr = array(
							'title' => $image_title,
							'alt'   => $image_title
							) ); ?>
						<li class="images-display image-<?php echo esc_attr($j); ?> <?php if($j==0){ ?>active<?php } ?>"><?php echo wp_kses($image,'social'); ?></li>
						<?php $j++;
					}
				?>
				</ul>
			</div>
		</div>
	</div>
	<?php }
}
?>