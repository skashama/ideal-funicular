<?php 
	global $instance;
	$format = get_post_format();
?>
<div class="list-post">
    <article id="post-<?php esc_attr(the_ID()); ?>" <?php post_class(); ?>>
		<?php if( empty($format) || $format == 'image' || $format == 'quote') : ?>	
			<?php if ( get_the_post_thumbnail() ){?>
			<div class="entry-thumb single-thumb">
				<a class="post-thumbnail" href="<?php echo esc_url(the_permalink()); ?>" title="<?php the_title_attribute(); ?>">
					<?php the_post_thumbnail( 'dimita-full-width' )?>				
				</a>
			</div>		
			<?php } ?>
		<?php elseif( $format == 'video' || $format == 'audio' ) : ?>
			<?php if ( get_the_post_thumbnail() ){?>
			<div class="entry-thumb single-thumb">
				<a class="post-thumbnail" href="<?php esc_url(the_permalink()); ?>" title="<?php echo the_title_attribute(); ?>">
					<?php the_post_thumbnail( 'dimita-full-width', array( 'alt' => get_the_title() ) );	?>      
				</a> 
			</div>
			<?php } ?>
		<?php elseif( $format == 'gallery' ) : 
			$ids = "";	
			if(preg_match_all('/\[gallery(.*?)?\]/', get_post($instance['post_id'])->post_content, $matches)){
				$attrs = array();
					if (count($matches[1])>0){
						foreach ($matches[1] as $m){
							$attrs[] = shortcode_parse_atts($m);
						}
					}
					if (count($attrs)> 0){
						foreach ($attrs as $attr){
							if (is_array($attr) && array_key_exists('ids', $attr)){
								$ids = $attr['ids'];
								break;
							}
						}
					}
				?>
				<?php if($ids){ ?>
				<div class="entry-thumb">
					<div id="gallery_slider_<?php echo esc_attr($post->ID); ?>" class="gallery-slider">	
						<div class="slick-carousel" data-columns4="1" data-columns3="1" data-columns2="1" data-columns1="1" data-columns="1" data-nav="true">
								<?php
									if($ids){
										$ids = explode(',', $ids);						
										foreach ( $ids as $i => $id ){ ?>
											<div class="item">
													<?php echo wp_get_attachment_image($id, 'dimita-full-width'); ?>
											</div>
										<?php }	
									}
								?>
						</div>
					</div>
				</div>
				<?php }
			} ?>			
		<?php endif; ?>			
		<div class="post-content">
			<?php if ( is_sticky() && is_home() && ! is_paged() ) { ?>
				<span class="sticky-post"><?php echo esc_html__( 'Featured', 'dimita' ) ?></span>
			<?php } ?>
        	<h3 class="entry-title"><a href="<?php echo esc_url(the_permalink()) ?>"><?php echo the_title(); ?></a></h3>
			<?php dimita_posted_on(); ?>
        	<?php
        		if (dimita_get_config('blog-excerpt')) {
                    echo dimita_get_excerpt( dimita_get_config('list-blog-excerpt-length',50), true);
                }
			?>
    	</div>	
    </article><!-- #post-## -->
</div>