<section id="scholarship-outro" class="gs-scholarship-outro">
    <h2><?php echo $scholarship_title; ?> Page</h2>

    <p>Want to learn more about <?php echo $institution_name; ?>, <?php echo $scholarship_title; ?>, requirements, application process, and other related information? Check the <a href="<?php echo $scholarship_page_link; ?>"><?php echo $scholarship_title; ?> page</a>!</p>

    
    <!-- <h2>Popular Scholarships in  <?php echo $country_name; ?></h2>  -->

    <?php

    // $country_institutions = get_institutions_location($country_name);

    // $country_institutions_ids = $country_institutions->posts;

    
    // $best_scholarships_by_country = [];
    
    // foreach($country_institutions_ids as $id ) {
        // $scholarships = get_scholarships_by_weight($id); // Assuming there is a function to retrieve scholarships by weight for a given institution ID.
        
        // $best_scholarships_by_country = array_merge($best_scholarships_by_country, $scholarships->posts);
        
    // }

    // We only get the Top 5 Scholarships by Scholarship Weight
    // $best_scholarships_by_country = array_slice( $best_scholarships_by_country, 0, 5);
    // ?>
    <!-- Display Popular Scholarships in Country --->

    <!-- <div class="gs-popular-scholarships-container"> -->
        <!-- <?php foreach($best_scholarships_by_country as $key => $scholarship) : ?> -->
            <!-- <div class="gs-popular-scholarship-item"> -->
                <!-- <a href="<?php echo get_the_permalink($scholarship) ?>"><?php echo get_the_title($scholarship); ?></a> -->
            <!-- </div> -->
        <!-- <?php endforeach ?> -->
    <!-- </div> -->

</section>

