<section id="scholarship-outro" class="gs-scholarship-outro">
    <h2><?php echo $scholarship_title; ?> Page</h2>

    <p>Want to learn more about <?php echo $institution_name; ?>, <?php echo $scholarship_title; ?>, scholarship requirements, deadlines, application process, and other related information?  Check the <a href="<?php echo $scholarship_page_link; ?>"><?php echo $scholarship_title; ?> page</a>!</p>

    <?php 
    
    if($scholarship_video){ 
               
                $parsed_url = parse_url($scholarship_video);
                parse_str($parsed_url['query'], $query_params);
                $video_id = $query_params['v']; ?>
                 
                 <div class="youtube-video-shortcode-container">
                 <?php echo do_shortcode("[lyte id='$video_id' /]"); ?>
                </div>
            
             <?php } 

    ?>

    <!-- <h2>Popular Scholarships in  <?php //echo $country_name; ?></h2>  -->

    <?php

    $country_institution = get_field('institution_country');
    $best_scholarships_country_query = get_best_scholarships_country($country_institution, 5);

    $best_scholarships_ids = $best_scholarships_country_query->get_posts();
    ?>

   <!--  <div class="gs-popular-scholarships-container">
        <?php foreach($best_scholarships_ids as $key => $scholarship) : ?>
            <div class="gs-popular-scholarship-item">
                <a href="<?php echo get_the_permalink($scholarship) ?>"><?php echo get_the_title($scholarship); ?></a>
            </div>
        <?php endforeach ?>
    </div> -->

</section>

