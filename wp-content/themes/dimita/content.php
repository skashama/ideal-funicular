<?php $dimita_settings = dimita_global_settings(); ?>
<article id="post-<?php esc_attr(the_ID()); ?>" <?php post_class(); ?>>
	<?php if ( get_the_post_thumbnail() ){ ?>
		<div class="entry-thumb single-thumb">
			<?php the_post_thumbnail( 'full' ); ?>
		</div>
	<?php }; ?>	
	<?php if ( is_search() ) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="post-content">
		<?php
			$show_post_title = dimita_get_config('post-title',true);
			if ($show_post_title){
				if ( is_single() ){
					the_title( '<h3 class="entry-title">', '</h3>' );
				}else {
					the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
				}
			}
		?>
		<div class="entry-by entry-meta">
			<?php dimita_single_posted_on_2(); ?>
		</div>
		<div class="post-excerpt clearfix">
			<?php
				/* translators: %s: Name of current post */
				the_content( sprintf(
					the_title( '<span class="screen-reader-text">', '</span>', false )
				) );
				wp_link_pages( array(
					'before'      => '<div class="page-links clearfix"><span class="page-links-title">' . esc_html__( 'Pages:', 'dimita' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
			?>
		</div>
		<div class="clearfix"></div>
	</div><!-- .entry-content -->
	<div class="post-content-entry">
		<!-- Tag -->
		<?php
		if ( 'post' === get_post_type() ) {
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'dimita' ) );
			if ( $tags_list ) {
				printf( '<div class="tags-links"><i class="fa fa-tag"></i>' . esc_html__( ' %1$s', 'dimita' ) . '</div>', $tags_list ); // WPCS: XSS OK.
			}
		}		
		?>
		<!-- Social Share -->
		<?php if ( shortcode_exists( 'social_share' ) ) : ?> 
			<div class="entry-social-share">
			<span class="title-social"><i class="fa fa-share-alt"></i></span>
			<?php echo do_shortcode( "[social_share]" ); ?>	
			</div>
		<?php endif; ?>
	</div>
	<!-- Previous/next post navigation. -->
	<div class="clearfix"></div>
	<?php dimita_entry_footer(); ?>	
	<?php endif; ?>
</article><!-- #post-## -->