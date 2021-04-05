<?php 
/* Template Name: Services Template */ 
?>

<?php 
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
                <div class="container-fluid service-main">
                  <?php for( $i = 0; $i < count($rows); $i++ ):
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
                        <div class="service-cta">
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
                          <div class="service-cta">
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
          
              <section class="footer-cta">
                <div class="container-grid">
                  <div class="row-grid">
                    <div class="col-grid">
                      <h2><?php the_field('footer_cta_heading') ?></h2>
                      <p><?php the_field('footer_cta_paragraph') ?></p>
                      <div class="cta-section">
                        <?php 
                          $this_link = get_field('footer_cta_button_link'); 
                          if( $this_link ): ?>
                            <a href="<?php echo esc_url( $this_link['url']) ?>" class="btn btn-outline-dark"><?php echo esc_html( $this_link['title'] ); ?></a>
                          <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </section>    

					</div><!-- #content -->
				</div><!-- #primary -->
			</div><!-- #main-content -->
		</div>   
    </div>
</div>
<?php
get_footer();