<?php
if ( ! function_exists( 'dimita_paging_nav' ) ) :
function dimita_paging_nav() {
	global $wp_query, $wp_rewrite;
	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}
	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );
	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}
	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';
	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';
	// Set up paginated links.
	$pagination = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $wp_query->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => esc_html__( 'Previous', 'dimita' ),
		'next_text' => esc_html__( 'Next', 'dimita' ),
		'type'      => 'list'
	) );
	if ( $pagination ) :
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'dimita' ); ?></h1>
		<div class="pagination loop-pagination">
			<?php echo wp_kses($pagination,'social'); ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;
if ( ! function_exists( 'dimita_post_nav' ) ) :
function dimita_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<div class="prevNextArticle box">
		<div class="previousArticle">
			<?php previous_post_link( '%link', '<div class="hoverExtend active"><span>'.esc_html__('Previous article','dimita').'</span></div><div class="title">%title</div>' ); ?>
		</div>
		<div class="nextArticle">
			<?php next_post_link( '%link', '<div class="hoverExtend active"><span>'.esc_html__('Next article','dimita').'</span></div><div class="title">%title</div>' ); ?>
		</div>
	</div><!-- Previous / next article -->
	<?php
}
endif;
function dimita_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'dimita_category_count' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );
		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );
		set_transient( 'dimita_category_count', $all_the_cool_cats );
	}
	if ( 1 !== (int) $all_the_cool_cats ) {
		return true;
	} else {
		return false;
	}
}
function dimita_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'dimita_category_count' );
}
add_action( 'edit_category', 'dimita_category_transient_flusher' );
add_action( 'save_post',     'dimita_category_transient_flusher' );
if ( ! function_exists( 'dimita_post_thumbnail' ) ) :
function dimita_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}
	if ( is_singular() ) : ?>
		<div class="post-thumbnail">
		<?php the_post_thumbnail( 'dimita-full-width' ); ?>
		</div>
	<?php else : ?>
		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php the_post_thumbnail( 'dimita-full-width' ); ?>
		</a>
	<?php endif; // End is_singular()
}
endif;
function dimita_page_title() {
	global $post, $dimita_settings,$wp_query;
	$enable_page_title = isset($dimita_settings['page_title']) ? $dimita_settings['page_title'] : true ;
	if($enable_page_title){
		$bg = isset($dimita_settings['page_title_bg']['url']) ? $dimita_settings['page_title_bg']['url'] : "";
		$class_empty = (empty($bg)) ? " empty-image" : "";
		?>
		<div class="page-title bwp-title<?php echo esc_attr($class_empty); ?>" <?php echo (!empty($bg) ? ' style="background-image:url(' . esc_url( $bg ) . ');"' : ''); ?>>
			<div class="container" >
				<?php $enable_breadcrumb = isset($dimita_settings['breadcrumb']) ? $dimita_settings['breadcrumb'] : true ; ?>
				<?php if($enable_breadcrumb) : ?>
					<?php
						if(function_exists('is_woocommerce') && is_woocommerce()){
							if (class_exists("WCV_Vendors") && WCV_Vendors::is_vendor_page()){
								get_template_part( 'breadcrumb');
							}else{
								dimita_woocommerce_breadcrumb();
							}
						}else{
							get_template_part( 'breadcrumb');
						}		
					?>			
				<?php endif; ?>
				<?php if(!is_single() ) :  ?>
					<h1>
						<?php						
						if( is_category() ) :
							single_cat_title();
						elseif (class_exists("WCV_Vendors") && WCV_Vendors::is_vendor_page()) :
							$vendor_shop 		= urldecode( get_query_var( 'vendor_shop' ) );
							$vendor_id   		= WCV_Vendors::get_vendor_id( $vendor_shop );
							$shop_name 			= WCV_Vendors::get_vendor_shop_name( stripslashes( $vendor_id ) );
						echo esc_html($shop_name);
						elseif (class_exists("WeDevs_Dokan") && dokan()->vendor->get( get_query_var( 'author' ) ) && get_query_var( 'author' ) != 0 ) :
							$store_user    = dokan()->vendor->get( get_query_var( 'author' ) );
							$shop_name 			= $store_user->get_shop_name();
							echo esc_html($shop_name);							
						elseif ( is_tax() ) :
							single_tag_title();	
						elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
							esc_html_e( 'Galleries', 'dimita' );
						elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
							esc_html_e( 'Images', 'dimita' );
						elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
							esc_html_e( 'Videos', 'dimita' );
						elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
							esc_html_e( 'Quotes', 'dimita' );
						elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
							esc_html_e( 'Audios', 'dimita' );
						elseif ( is_archive() && is_author() ) :
							esc_html_e( 'Posts by " ', 'dimita' ) . the_author() . esc_html_e(' " ','dimita');
						elseif ( function_exists('is_shop') && is_shop() ) :							
							esc_html_e( 'Shop', 'dimita' );
						elseif ( is_archive() && !is_search()) :						
							the_archive_title();
						elseif ( is_search() ) :
							printf( esc_html__( 'Search for: %s', 'dimita' ), get_search_query() );
						elseif ( is_404() ) :
							esc_html_e( '404 Error', 'dimita' );
						elseif ( is_singular( 'knowledge' ) ) :
							esc_html_e( 'Knowledge Base', 'dimita' );
						elseif ( is_home() ) :
							esc_html_e( 'Posts', 'dimita' );
						else :
							echo get_the_title();
						endif;
						?>
					</h1>
				<?php endif; ?>
			</div><!-- .container -->
		</div><!-- Page Title -->
	<?php } ?>
<?php }
if ( ! function_exists( 'dimita_single_posted_on' ) ) :
function dimita_single_posted_on() { 
	global $dimita_settings,$post; ?>
	<div class="entry-meta">
		<!-- Categories -->
		<?php $categories_list = get_the_category_list( __( ', ', 'dimita' ) );
		if ( $categories_list ) : ?>
			<span class="cat-links">
				<span><?php echo esc_html__('', 'dimita'); ?></span>
				<?php echo wp_kses( $categories_list,'social' ); ?>
			</span>
		<?php endif; ?>
		<!-- End if categories. -->
	</div>			
<?php }
endif;
if ( ! function_exists( 'dimita_single_posted_on_2' ) ) :
function dimita_single_posted_on_2(){
	global $dimita_settings,$post; ?>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) { ?>
			<span class="sticky-post"><?php echo esc_html__( 'Featured', 'dimita' ) ?></span>
		<?php } ?>
		<?php if (dimita_get_config('archives-author')) { ?>
			<div class="entry-author">
				<span class="entry-meta-link"><i class="fa fa-user"></i><?php the_author_posts_link(); ?></span>
			</div>
		<?php } ?>
		<?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ) ) && dimita_categorized_blog() ) : ?>
			<div class="cat-links"><i class="fa fa-folder"></i> <?php echo get_the_category_list(', '); ?></div>
		<?php endif; ?>		
		<span class="post-date">
			<i class="fa fa-clock-o"></i><?php echo dimita_time_link(); ?>
		</span>
		<div class="comments-link">
			<i class="fa fa-comment"></i>
			<a href="<?php echo esc_attr('#respond'); ?>" >
				<?php 
				$comment_count =  wp_count_comments(get_the_ID())->total_comments;
				if($comment_count > 0) {
				?>
					<?php if($comment_count == 1){?>
						<?php echo esc_attr($comment_count) .'<span>'. esc_html__(' Comment', 'dimita').'</span>'; ?>
					<?php }else{ ?>
						<?php echo esc_attr($comment_count) .'<span>'. esc_html__(' Comments', 'dimita').'</span>'; ?>
					<?php } ?>
				<?php }else{ ?>
					<?php echo esc_attr($comment_count) .'<span>'. esc_html__(' Comments', 'dimita').'</span>'; ?>
				<?php } ?>
			</a>
		</div>
<?php }
endif;
if ( ! function_exists( 'dimita_single_author' ) ) :
function dimita_single_author(){
	global $dimita_settings,$post;
	$user_description = get_user_meta( get_the_author_meta( 'ID' ), 'description', true ); ?>
	<?php if ( dimita_get_config('archives-author',true) && $user_description ) { ?>
		<div class="entry-meta-author">
			<div class="author-avatar">
				<span class="author-image"><?php echo get_avatar( get_the_author_meta( 'ID' ), 100); ?> </span>
			</div>
			<div class="author-info">
				<span class="author-link"><?php the_author_posts_link(); ?></span>
				<span class="author-description"><?php the_author_meta('description'); ?></span>
			</div>
		</div>	
	<?php } ?>
<?php }
endif;
if ( ! function_exists( 'dimita_posted_on' ) ) :
function dimita_posted_on() { 
	global $dimita_settings,$post; ?>
		<div class="entry-meta">
			<div class="post-date">
				<span><i class="fa fa-clock-o"></i><?php echo dimita_time_link(); ?></span>
			</div>
			<?php if (dimita_get_config('archives-author')) { ?>
				<div class="entry-author">
					<span class="entry-meta-link"><i class="fa fa-pencil-square-o"></i><?php the_author_posts_link(); ?></span>
				</div>
			<?php } ?>
			<div class="comments-link">
				<i class="fa fa-comment"></i>
				<?php 
				$comment_count =  wp_count_comments(get_the_ID())->total_comments;
				if($comment_count > 0) {
				?>
					<?php if($comment_count == 1){?>
						<a href="<?php comments_link(); ?>"><?php echo esc_attr($comment_count) .'<span>'. esc_html__(' Comment', 'dimita').'</span>'; ?></a>
					<?php }else{ ?>
						<a href="<?php comments_link(); ?>"><?php echo esc_attr($comment_count) .'<span>'. esc_html__(' Comments', 'dimita').'</span>'; ?></a>
					<?php } ?>
				<?php }else{ ?>
					<?php echo '<span class="no-comment">'. esc_html__('No Comments', 'dimita').'</span>'; ?>
				<?php } ?>
			</div>
		</div>			
<?php }
endif;
if ( ! function_exists( 'dimita_posted_on_2' ) ) :
function dimita_posted_on_2() { 
	global $dimita_settings,$post; ?>	
		<?php if (dimita_get_config('archives-author')) { ?>
			<div class="entry-author">
				<span class="entry-meta-link"><i class="fa fa-user"></i><?php the_author_posts_link(); ?></span>
			</div>
		<?php } ?>
		<div class="entry-date">
			<i class="fa fa-calendar"></i>
			<?php echo dimita_time_link(); ?>
		</div>
<?php }
endif;
if ( ! function_exists( 'dimita_entry_footer' ) ) :
	function dimita_entry_footer() {
		edit_post_link(
			sprintf(
				wp_kses(
					__( 'Edit <span class="screen-reader-text">%s</span>', 'dimita' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;
if ( ! function_exists( 'dimita_time_link' ) ) :
	function dimita_time_link() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%3$s, %4$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%3$s, %4$s</time><time class="updated" datetime="%6$s">%7$s</time>';
		}
		$time_string = sprintf(
			$time_string,
			get_the_date( DATE_W3C ),
			get_the_date('l'),
			get_the_date('F j'),
			get_the_date('Y'),
			get_the_date('g:i a'),
			get_the_modified_date( DATE_W3C ),
			get_the_modified_date()
		);
		return sprintf(
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);
	}
endif;