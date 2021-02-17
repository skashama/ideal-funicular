<?php 
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
	<?php if($terms){ ?>
	<div class="select_category pwb-dropdown dropdown">
		<span class="pwb-dropdown-toggle dropdown-toggle" data-toggle="dropdown"><?php echo esc_html__("Category","dimita"); ?></span>
		<span class="caret"></span>
		<ul class="pwb-dropdown-menu dropdown-menu category-search">
		<li data-value="" class="<?php  echo (empty($category_slug) ?  esc_attr("active") : ""); ?>"><?php echo esc_html__("All Category","dimita"); ?></li>
			<?php foreach($terms as $term){?>
				<li data-value="<?php echo esc_attr($term->slug); ?>" class="<?php  echo (($term->slug == $category_slug) ?  esc_attr("active") : ""); ?>"><?php echo esc_html($term->name); ?></li>
				<?php
					$terms_vl1 =	get_terms( 'product_cat', 
					array( 
							'parent' => '', 
							'hide_empty' => false,
							'parent' 		=> $term->term_id, 
					));						
				?>	
				
				<?php foreach ($terms_vl1 as $term_vl1) { ?>
					<li data-value="<?php echo esc_attr($term_vl1->slug); ?>" class="<?php  echo (($term_vl1->slug == $category_slug) ?  esc_attr("active") : ""); ?>"><?php echo esc_html($term_vl1->name); ?></li>
					<?php
						$terms_vl2 =	get_terms( 'product_cat', 
						array( 
								'parent' => '', 
								'hide_empty' => false,
								'parent' 		=> $term_vl1->term_id, 
					));	?>					
					<?php foreach ($terms_vl2 as $term_vl2) { ?>
					<li data-value="<?php echo esc_attr($term_vl2->slug); ?>" class="<?php  echo (($term_vl2->slug == $category_slug) ?  esc_attr("active") : ""); ?>"><?php echo esc_html($term_vl2->name); ?></li>
					<?php } ?>
				<?php } ?>
				
			<?php } ?>
		</ul>	
		<input type="hidden" name="product_cat" class="product-cat" value="<?php echo esc_attr($category_slug); ?>"/>
	</div>	
	<?php } ?>	
	<div class="search-box">
		<input type="text" value="<?php echo get_search_query(); ?>" name="s" id="ss" class="input-search s" placeholder="<?php echo esc_attr__( 'I’m searching for...', 'dimita' ); ?>" />
		<ul class="result-search-products">
		</ul>
		<button id="searchsubmit2" class="btn" type="submit">
			<span class="icon-search">
				<i class="icon_search"></i>
			</span>
			<span><?php echo esc_html__('search','dimita'); ?></span>
		</button>
	</div>
	<input type="hidden" name="post_type" value="product" />
</form>