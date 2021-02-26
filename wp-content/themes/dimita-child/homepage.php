<?php 
/* Template Name: Homepage Template */ 
?>


<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12">    
			<div id="main-content" class="main-content">
				<div id="primary" class="content-area">
					<div id="content" class="site-content" role="main">
							
							<h3 class="mt-4"><?php the_field('page_title'); ?></h3>
							<p><?php the_field('page_description'); ?></p>
					</div><!-- #content -->
				</div><!-- #primary -->
			</div><!-- #main-content -->
		</div>   
    </div>
</div>
<?php
get_footer();