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

              <div class="row">
                  <div class="col-3">
                      <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                      <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                          <?php echo esc_html($group1['category_title']) ?>
                      </a>
                      <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                          <?php echo esc_html($group2['category_title']) ?>
                      </a>
                      <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">
                          <?php echo esc_html($group3['category_title']) ?>
                      </a>
                      <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                          <?php echo esc_html($group4['category_title']) ?>
                      </a>
                      </div>
                  </div>

                  <div class="col-9">
                      <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">                                    
                            
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
                                      <h2 class="mb-0">
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
                        </div> <!-- tab pan fade -->

                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                
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
                                        <h2 class="mb-0">
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
                          </div> <!-- tab pan fade -->

                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                              
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
                                        <h2 class="mb-0">
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
                          </div> <!-- tab pan fade -->

                        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                              
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
                                        <h2 class="mb-0">
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
                          </div> <!-- tab pan fade -->
                          
                      </div>
                  </div>
              </div>

					</div><!-- #content -->
				</div><!-- #primary -->
			</div><!-- #main-content -->
		</div>   
    </div>
</div>
<?php
get_footer();