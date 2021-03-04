<?php 
/* Template Name: Services Template */ 
?>

<?php 
  // $link = get_field('service_cta');
  $i;
?>


<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12">    
			<div id="main-content" class="main-content">
				<div id="primary" class="content-area">
					<div id="content" class="site-content" role="main">

            <?php 
              $rows = get_field('featured_service');
              if( $rows ): ?>
                <div class="container-fluid">
                  <?php for( $i = 0; $i <= count($rows) - 1; $i++ ):
                    $current = $rows[$i];
                    $image = $current['service_image'];
                    if( $i%2 == 0 ):
                      ?>
                      <div class="row justify-content-center service-row">
                      <div class="col-12 col-md-6 image-section">                        
                        <figure class="featured-image">
                          <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
                        </figure>
                      </div>

                      <div class="col-12 col-md-6 text-section">
                        <h2><?php echo esc_html( $current['service_title'] ); ?></h2>
                        <p><?php echo $current['service_description']; ?></p>
                        <div>
                          <?php 
                          $link = $current['service_cta']; 
                          if( $link ): ?>
                            <a href="<?php echo esc_url( $link['url'] ); ?>" class="btn btn-outline-info" tabindex="-1" role="button"><?php echo esc_html( $link['title'] ); ?></a>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  
                      <?php else: ?>
                      <div class="row justify-content-center service-row">
                        <div class="col-12 col-md-6 text-section">
                          <h2><?php echo esc_html( $current['service_title'] ); ?></h2>
                          <p><?php echo $current['service_description']; ?></p>
                        <div>
                            <?php 
                            $link = $current['service_cta']; 
                            if( $link ): ?>
                              <a href="<?php echo esc_url( $link['url'] ); ?>" class="btn btn-outline-info" tabindex="-1" role="button"><?php echo esc_html( $link['title'] ); ?></a>
                            <?php endif; ?>
                        </div>
                        </div>

                      <?php $image = $current['service_image'];
                      ?>
                      <div class="col-12 col-md-6 image-section">                        
                        <figure class="featured-image">
                          <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
                        </figure>
                      </div>
                    </div>
                    <?php endif; ?>    
                  <?php endfor; ?>
              </div>
              <?php endif; ?>               

					</div><!-- #content -->
				</div><!-- #primary -->
			</div><!-- #main-content -->
		</div>   
    </div>
</div>
<?php
get_footer();