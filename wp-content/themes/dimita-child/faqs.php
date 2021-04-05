<?php 
/* Template Name: Faqs Template */ 
?>

<?php 
  $group1 = get_field('category_1');
  $group2 = get_field('category_2');
  $group3 = get_field('category_3');
  $group4 = get_field('category_4');
  $group5 = get_field('category_5');
?>


<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-md-12">    
			<div id="main-content" class="main-content">
				<div id="primary" class="content-area">
					<div id="content" class="site-content" role="main">

          <div class="container-fluid faqs-main">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
                  <?php echo esc_html($group1['category_title']) ?>
                </a>
                <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">
                  <?php echo esc_html($group2['category_title']) ?>
                </a>
                <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">
                  <?php echo esc_html($group3['category_title']) ?>
                </a>
                <a class="nav-link" id="nav-settings-tab" data-toggle="tab" href="#nav-settings" role="tab" aria-controls="nav-settings" aria-selected="false">
                  <?php echo esc_html($group4['category_title']) ?>
                </a>
                <a class="nav-link" id="nav-config-tab" data-toggle="tab" href="#nav-config" role="tab" aria-controls="nav-config" aria-selected="false">
                  <?php echo esc_html($group5['category_title']) ?>
                </a>
              </div>
            </nav>

          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
               <?php if( $group1):                             
                  $questions = $group1['question_section'];
                ?>
                <?php 
                    if( $questions ):
                  ?>  
                <div class="accordion" id="accordionExample">
                  <?php  for( $i = 0; $i < count($questions); $i++ ):
                      $current = $questions[$i];
                      $query = $current['question'];
                      $answer = $current['answer'];
                  ?>
                
                  <div class="card">
                      <div class="card-header" id="headingOne">
                        <h2>
                          <?php 
                              $queryArr = explode(" ", $query );
                              $targetId = $queryArr[0].$i;
                          ?>
                          <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#<?php echo esc_html( $targetId) ?>" aria-expanded="true" aria-controls="collapseOne">
                            <?php echo esc_html( $query ); ?>
                          </button>    
                        </h2>
                      </div>

                      <div id="<?php echo esc_html( $targetId) ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                      <div class="card-body">
                        <?php echo $answer; ?>
                      </div>
                      </div>
                  </div>
                <?php endfor; ?>

              </div> <!-- .accordion -->                                
                <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
              <?php if( $group2):                             
                  $questions = $group2['question_section'];
                ?>
                <?php 
                    if( $questions ):
                  ?>  
                <div class="accordion" id="accordionExample">
                  <?php  for( $i = 0; $i < count($questions); $i++ ):
                      $current = $questions[$i];
                      $query = $current['question'];
                      $answer = $current['answer'];
                  ?>
              
                  <div class="card">
                      <div class="card-header" id="headingOne">
                          <h2>
                          <?php 
                              $queryArr = explode(" ", $query );
                              $targetId = $queryArr[0].$i;
                          ?>
                          <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#<?php echo esc_html( $targetId) ?>" aria-expanded="true" aria-controls="collapseOne">
                              <?php echo esc_html( $query ); ?>
                          </button>    
                          </h2>
                      </div>

                      <div id="<?php echo esc_html( $targetId) ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                      <div class="card-body">
                        <?php echo $answer; ?>
                      </div>
                      </div>
                  </div>
                <?php endfor; ?>

              </div> <!-- .accordion -->                                
                <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
              <?php if( $group3):                             
                    $questions = $group3['question_section'];
                  ?>
                  <?php 
                      if( $questions ):
                    ?>  
                  <div class="accordion" id="accordionExample">
                    <?php  for( $i = 0; $i < count($questions); $i++ ):
                        $current = $questions[$i];
                        $query = $current['question'];
                        $answer = $current['answer'];
                    ?>
                
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2>
                            <?php 
                                $queryArr = explode(" ", $query );
                                $targetId = $queryArr[0].$i;
                            ?>
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#<?php echo esc_html( $targetId) ?>" aria-expanded="true" aria-controls="collapseOne">
                                <?php echo esc_html( $query ); ?>
                            </button>    
                            </h2>
                        </div>

                        <div id="<?php echo esc_html( $targetId) ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                          <?php echo $answer; ?>
                        </div>
                        </div>
                    </div>
                  <?php endfor; ?>

                </div> <!-- .accordion -->                                
                  <?php endif; ?>
                  <?php endif; ?>
            </div>
            <div class="tab-pane fade" id="nav-settings" role="tabpanel" aria-labelledby="nav-settings-tab">
              <?php if( $group4):                             
                  $questions = $group4['question_section'];
                ?>
                <?php 
                    if( $questions ):
                  ?>  
                <div class="accordion" id="accordionExample">
                  <?php  for( $i = 0; $i < count($questions); $i++ ):
                      $current = $questions[$i];
                      $query = $current['question'];
                      $answer = $current['answer'];
                  ?>
              
                  <div class="card">
                      <div class="card-header" id="headingOne">
                          <h2>
                          <?php 
                              $queryArr = explode(" ", $query );
                              $targetId = $queryArr[0].$i;
                          ?>
                          <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#<?php echo esc_html( $targetId) ?>" aria-expanded="true" aria-controls="collapseOne">
                              <?php echo esc_html( $query ); ?>
                          </button>    
                          </h2>
                      </div>

                      <div id="<?php echo esc_html( $targetId) ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                      <div class="card-body">
                        <?php echo $answer; ?>
                      </div>
                      </div>
                  </div>
                <?php endfor; ?>

              </div> <!-- .accordion -->                                
                <?php endif; ?>
                <?php endif; ?>
            </div> <!-- tab-pane -->
          
            <div class="tab-pane fade" id="nav-config" role="tabpanel" aria-labelledby="nav-config-tab">
              <?php if( $group5):                             
                  $questions = $group5['question_section'];
                ?>
                <?php 
                    if( $questions ):
                  ?>  
                <div class="accordion" id="accordionExample">
                  <?php  for( $i = 0; $i < count($questions); $i++ ):
                      $current = $questions[$i];
                      $query = $current['question'];
                      $answer = $current['answer'];
                  ?>
              
                  <div class="card">
                      <div class="card-header" id="headingOne">
                          <h2>
                          <?php 
                              $queryArr = explode(" ", $query );
                              $targetId = $queryArr[0].$i;
                          ?>
                          <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#<?php echo esc_html( $targetId) ?>" aria-expanded="true" aria-controls="collapseOne">
                              <?php echo esc_html( $query ); ?>
                          </button>    
                          </h2>
                      </div>

                      <div id="<?php echo esc_html( $targetId) ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                      <div class="card-body">
                        <?php echo $answer; ?>
                      </div>
                      </div>
                  </div>
                <?php endfor; ?>

              </div> <!-- .accordion -->                                
                <?php endif; ?>
                <?php endif; ?>
            </div> <!-- tab-pane -->
          </div> <!-- tab-content -->
        </div> <!-- faqs-main -->

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