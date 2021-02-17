<?php
	$tag_id = 'recent_post_' .rand().time(); 
	$args = array(
	'post_type' => 'post',
	'cat' => $category, 
	'posts_per_page' => $limit
	);

	$query = new WP_Query($args);
	$post_count = $query->post_count;
	$j = 0;
?>
<?php if($query->have_posts()):?>
<div class="bwp-recent-post <?php echo esc_attr($layout); ?>">
 <div class="block">
 	<?php if(isset($title1) && $title1) { ?>
	<div class="title-block">
		<h2><?php echo esc_html($title1); ?></h2>
		<?php if($description) { ?>
		<div class="page-description"><?php echo esc_html($description); ?></div>
		<?php } ?>  
	</div>
	<?php } ?>
	<div class="block_content">
		<div id="<?php echo esc_attr($tag_id); ?>" class="slick-carousel" data-nav="<?php echo esc_attr($show_nav);?>" data-columns4="<?php echo $columns4; ?>" data-columns3="<?php echo $columns3; ?>" data-columns2="<?php echo $columns2; ?>" data-columns1="<?php echo $columns1; ?>" data-columns="<?php echo $columns; ?>">
			<?php while($query->have_posts()):$query->the_post(); ?>
				<div class="item <?php echo esc_attr($attributes) ?>">
					<div  <?php post_class( 'post-grid' ); ?>>	
					<div class="post-inner style">
						<div class="post-iamge">
							<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
							<?php
								if( has_post_thumbnail() ) :
									the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title() ) );
								else :
									echo '<img src="' . esc_url( get_template_directory_uri() . '/images/placeholder.jpg' ) . '" alt="' . get_the_title() . '">';
								endif;
							?>
							</a>
						</div>
						<div class="post-content">
							<div class="categories">
								<a href="<?php echo esc_url(dimita_category_post()->cat_link);?>"><?php echo esc_html(dimita_category_post()->name); ?></a>
							</div>
							<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
							<div class="date-cmt">
								<div class="meta-date"><?php wpbingo_posted_on(); ?></div>
								<div class="entry-meta-head">
									<span class="comments-link">
										<?php 
										$comment_count =  wp_count_comments(get_the_ID())->total_comments;
										if($comment_count > 0) {
										?>
											<?php if($comment_count == 1){?>
												<?php echo esc_attr($comment_count) .'<span>'. esc_html__(' Comment', 'wpbingo').'</span>'; ?>
											<?php }else{ ?>
												<?php echo esc_attr($comment_count) .'<span>'. esc_html__(' Comments', 'wpbingo').'</span>'; ?>
											<?php } ?>
										<?php }else{ ?>
											<?php echo esc_attr($comment_count) .'<span>'. esc_html__(' Comments', 'wpbingo').'</span>'; ?>
										<?php } ?>
									</span>
								</div>
							</div>
						</div>
					</div>
					</div><!-- #post-## -->
				</div>
			<?php endwhile; wp_reset_postdata(); ?>
		</div>
	</div>
 </div>
</div>
<?php endif;?>