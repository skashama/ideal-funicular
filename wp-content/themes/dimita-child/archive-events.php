<?php 
	get_header();	
	$layout_blog = dimita_blog_view();
	$class_content_blog = 'blog-content-'.esc_attr($layout_blog);
?>
<div class="container">
	<div class="category-posts row">
		<div class="cate-post-content col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<section id="primary" class="content-area">
				<div id="content" class="site-content <?php echo esc_attr($class_content_blog);?>" role="main">
						<?php if ( have_posts() ) : ?>
						<?php
								// Start the Loop.
								while ( have_posts() ) : the_post();
								/*
								 * Include the post format-specific template for the content. If you want to
								 * use this in a child theme, then include a file called called content-___.php
								 * (where ___ is the post format) and that will be used instead.
								 */
								get_template_part( 'event-grid', $layout_blog);
								endwhile;
								// Previous/next page navigation.
							else :
								// If no content, include the "No posts found" template.
								get_template_part( 'templates/content/content', 'none');
						endif;
					?>
				</div><!-- #content -->
				<?php 	dimita_paging_nav(); ?>
			</section><!-- #primary -->
		</div>
    </div>
</div>
<?php
get_footer();